<?php

namespace App\Calculators;

use App\Entities\Transactions\TransactionEntity;
use App\Services\CurrencyService;
use App\Counters\PrivateTransactionFeeCounter;
use DateTime;

final readonly class WithdrawPrivateTypeCalculator implements CommissionFeeCalculatorInterface
{
    public function __construct(
        private PrivateTransactionFeeCounter $transactionStateManager,
        private CurrencyService $currencyService,
    ) {
    }

    public function calculate(TransactionEntity $transaction): float
    {
        $operationSum = $transaction->getOperationSum();
        $operationCurrency = $transaction->getOperationCurrency();
        $userId = $transaction->getUserId();

        //convert the operation sum to the base currency (in our case it's EUR)
        $convertedOperationSum = $this->currencyService->convertToDefaultCurrency($operationCurrency, $operationSum);

        $weekId = DateTime::createFromFormat('Y-m-d', $transaction->getCreatedAt())->format('o-W');

        $transactionCountForWeek = $this->transactionStateManager->getTransactionCountForWeek($userId, $weekId);
        $spentSumDuringWeek = $this->transactionStateManager->getTransactionSumForWeek($userId, $weekId);

        //here I check whether the transaction should be without a fee or not
        if (
            $transactionCountForWeek < AVAILABLE_NON_FEE_TRANSACTION_COUNT_PER_WEEK
            &&
            $spentSumDuringWeek + $convertedOperationSum <= AVAILABLE_NON_FEE_TRANSACTION_SUM_PER_WEEK
        ) {
            $this->transactionStateManager->addTransaction(
                $userId,
                $weekId,
                $spentSumDuringWeek + $convertedOperationSum
            );

            return 0;
        }

        $excessSum = ($spentSumDuringWeek + $convertedOperationSum) > AVAILABLE_NON_FEE_TRANSACTION_SUM_PER_WEEK
            ? ($spentSumDuringWeek + $convertedOperationSum) - AVAILABLE_NON_FEE_TRANSACTION_SUM_PER_WEEK
            : $convertedOperationSum;

        $this->transactionStateManager->addTransaction(
            $userId,
            $weekId,
            $convertedOperationSum - $excessSum
        );

        $excessInOriginalCurrency = $this->currencyService->convertFromDefaultCurrency(
            $operationCurrency,
            $excessSum
        );

        return $excessInOriginalCurrency * WITHDRAW_PRIVATE_RATE;
    }
}
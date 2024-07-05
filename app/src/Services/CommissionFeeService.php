<?php

namespace App\Services;

use App\Calculators\DepositTypeCalculator;
use App\Calculators\WithdrawBusinessTypeCalculator;
use App\Calculators\WithdrawPrivateTypeCalculator;
use App\Entities\Transactions\TransactionEntity;
use App\Enums\Transactions\TransactionOperationTypeStringEnum;
use App\Enums\Transactions\TransactionUserTypeStringEnum;
use App\Providers\Transactions\TransactionProviderInterface;
use App\Counters\PrivateTransactionFeeCounter;

readonly final class CommissionFeeService
{
    public function __construct(
        private TransactionProviderInterface $transactionProvider,
        private CurrencyService $currencyService,
        private PrivateTransactionFeeCounter $transactionStateManager,
    ) {
    }

    public function calculateCommissionFees(): array
    {
        $result = [];

        foreach ($this->transactionProvider->getTransactions() as $transaction) {
            $draftSum = match ($transaction->getOperationType()) {
                TransactionOperationTypeStringEnum::DEPOSIT => (new DepositTypeCalculator())->calculate($transaction),
                TransactionOperationTypeStringEnum::WITHDRAW => $this->handleWithdrawTransaction($transaction),
            };

            $result[] = !$this->currencyService->isHasCents($transaction->getOperationCurrency())
                ? ceil($draftSum)
                : number_format(ceil($draftSum * 100) / 100, 2, thousands_separator: '');
        }

        return $result;
    }

    private function handleWithdrawTransaction(TransactionEntity $transaction): float
    {
        return match ($transaction->getUserType()) {
            TransactionUserTypeStringEnum::BUSINESS => (new WithdrawBusinessTypeCalculator())->calculate($transaction),
            TransactionUserTypeStringEnum::PRIVATE => (new WithdrawPrivateTypeCalculator(
                $this->transactionStateManager,
                $this->currencyService,
            ))->calculate($transaction),
        };
    }
}
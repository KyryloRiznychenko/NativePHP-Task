<?php

namespace App\Calculators;

use App\Entities\Transactions\TransactionEntity;

final readonly class WithdrawBusinessTypeCalculator implements CommissionFeeCalculatorInterface
{
    public function calculate(TransactionEntity $transaction): float
    {
        return $transaction->getOperationSum() * WITHDRAW_BUSINESS_RATE;
    }
}
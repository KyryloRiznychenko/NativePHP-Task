<?php

namespace App\Calculators;

use App\Entities\Transactions\TransactionEntity;

final readonly class DepositTypeCalculator implements CommissionFeeCalculatorInterface
{
    public function calculate(TransactionEntity $transaction): float
    {
        return $transaction->getOperationSum() * DEPOSIT_RATE;
    }
}
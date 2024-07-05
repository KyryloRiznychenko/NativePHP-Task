<?php

namespace App\Calculators;

use App\Entities\Transactions\TransactionEntity;

interface CommissionFeeCalculatorInterface
{
    public function calculate(TransactionEntity $transaction): float;
}
<?php

namespace App\Providers\Transactions;

use App\Entities\Transactions\TransactionEntity;

interface TransactionProviderInterface
{
    /**
     * @return TransactionEntity[]
     */
    public function getTransactions(): array;
}
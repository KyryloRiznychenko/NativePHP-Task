<?php

namespace App\Enums\Transactions;

enum TransactionOperationTypeStringEnum: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
}

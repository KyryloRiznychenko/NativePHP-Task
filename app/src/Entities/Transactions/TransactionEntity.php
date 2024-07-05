<?php

namespace App\Entities\Transactions;

use App\Enums\Transactions\TransactionOperationTypeStringEnum;
use App\Enums\Transactions\TransactionUserTypeStringEnum;

readonly class TransactionEntity
{
    public function __construct(
        private string $createdAt,
        private int $userId,
        private TransactionUserTypeStringEnum $userType,
        private TransactionOperationTypeStringEnum $operationType,
        private float $operationSum,
        private string $operationCurrency,
    ) {
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserType(): TransactionUserTypeStringEnum
    {
        return $this->userType;
    }

    public function getOperationType(): TransactionOperationTypeStringEnum
    {
        return $this->operationType;
    }

    public function getOperationSum(): float
    {
        return $this->operationSum;
    }

    public function getOperationCurrency(): string
    {
        return $this->operationCurrency;
    }
}
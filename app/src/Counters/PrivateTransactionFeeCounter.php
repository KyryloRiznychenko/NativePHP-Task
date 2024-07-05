<?php

namespace App\Counters;

class PrivateTransactionFeeCounter
{
    private array $transactions = [];

    public function addTransaction(int $userId, string $weekId, float $amount): void
    {
        if (!isset($this->transactions[$userId][$weekId])) {
            $this->transactions[$userId][$weekId] = [];
        }

        $this->transactions[$userId][$weekId][] = $amount;
    }

    public function getTransactionSumForWeek(int $userId, string $weekId): float
    {
        return array_sum($this->transactions[$userId][$weekId] ?? []);
    }

    public function getTransactionCountForWeek(int $userId, string $weekId): int
    {
        return count($this->transactions[$userId][$weekId] ?? []);
    }
}
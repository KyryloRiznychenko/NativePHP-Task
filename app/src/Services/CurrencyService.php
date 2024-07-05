<?php

namespace App\Services;

use App\Repositories\Currencies\CurrencyRateRepositoryInterface;

readonly class CurrencyService
{
    public function __construct(private CurrencyRateRepositoryInterface $rateRepository)
    {
    }

    public function convertToDefaultCurrency(string $inputCurrency, float $sum): float
    {
        return $inputCurrency === AVAILABLE_NON_FEE_TRANSACTION_SUM_PER_WEEK_IN_CURRENCY
            ? $sum
            : $sum / $this->rateRepository->getRate($inputCurrency);
    }

    public function convertFromDefaultCurrency(string $originCurrency, float $sum): float
    {
        return $this->rateRepository->getRate($originCurrency) * $sum;
    }

    public function isHasCents(string $inputCurrency): bool
    {
        return match ($inputCurrency) {
            'JPY' => false,
            default => true,
        };
    }
}
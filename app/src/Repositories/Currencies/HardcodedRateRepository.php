<?php

namespace App\Repositories\Currencies;

final class HardcodedRateRepository implements CurrencyRateRepositoryInterface
{
    protected array $rates = [
        'EUR' => 1,
        'USD' => 1.1497,
        'JPY' => 129.53,
    ];

    public function getRate(string $currencyName): float
    {
        return $this->rates[$currencyName];
    }
}
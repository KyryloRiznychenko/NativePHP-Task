<?php

namespace App\Repositories\Currencies;

interface CurrencyRateRepositoryInterface
{
    public function getRate(string $currencyName): float;
}
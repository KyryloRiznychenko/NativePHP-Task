<?php

namespace App\Exceptions\Rates;

use Exception;

class InvalidRateNameException extends Exception
{
    public function __construct(string $currencyName)
    {
        parent::__construct("Rate is not available for currency '$currencyName'");
    }
}
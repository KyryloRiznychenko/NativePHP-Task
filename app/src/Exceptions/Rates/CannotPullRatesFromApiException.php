<?php

namespace App\Exceptions\Rates;

use Exception;

class CannotPullRatesFromApiException extends Exception
{
    public function __construct(string $apiUrl)
    {
        parent::__construct("Cannot pull rates from the $apiUrl");
    }
}
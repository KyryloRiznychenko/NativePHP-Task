<?php

namespace App\Repositories\Currencies;

use App\Exceptions\Rates\CannotPullRatesFromApiException;
use App\Exceptions\Rates\InvalidRateNameException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

final readonly class ExchangeratesApiRateRepository implements CurrencyRateRepositoryInterface
{
    private array $rates;

    /**
     * @throws Exception
     */
    public function __construct(
        private string $apiUrl,
        private string $apiKey,
    ) {
        $this->pullRates();
    }

    /**
     * Usually, we need to always pull the latest rates when it comes to money.
     * But for the test task, I decided to keep them in 'cache' for don't spam the test API (I have a limit on calls)
     *
     * @throws Exception
     */
    private function pullRates(): void
    {
        try {
            $response = (new Client())
                ->get($this->apiUrl, ['query' => ['access_key' => $this->apiKey]])
                ->withHeader('Content-Type', 'application/json');
            $rates = json_decode($response->getBody(), true)['rates'];
        } catch (GuzzleException $e) {
            throw new CannotPullRatesFromApiException($this->apiUrl);
        }

        $this->rates = $rates;
    }

    /**
     * @throws InvalidRateNameException
     * @throws Exception
     */
    public function getRate(string $currencyName): float
    {
        if (!array_key_exists($currencyName, $this->rates)) {
            throw new InvalidRateNameException($currencyName);
        }

        return $this->rates[$currencyName];
    }
}
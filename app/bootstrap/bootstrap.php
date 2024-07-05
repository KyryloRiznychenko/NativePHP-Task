<?php

use App\Providers\Transactions\CsvTransactionProvider;
use App\Repositories\Currencies\ExchangeratesApiRateRepository;
use App\Repositories\Currencies\HardcodedRateRepository;
use App\Services\CommissionFeeService;
use App\Services\CurrencyService;
use App\Counters\PrivateTransactionFeeCounter;
use Bootstrap\Container;

require_once __DIR__.'../../config.php';

global $container;
$container = new Container();

$container->set(CsvTransactionProvider::class, fn() => new CsvTransactionProvider(INPUT_CSV_FILE_PATH));
$container->set(CurrencyService::class, fn(Container $container) => new CurrencyService(
    IS_USE_HARDCODED_RATES
        ? new HardcodedRateRepository()
        : new ExchangeratesApiRateRepository(EXCHANGERATES_API_URL, EXCHANGERATES_API_KEY)
));

$container->set(CommissionFeeService::class, fn(Container $container) => new CommissionFeeService(
    $container->get(CsvTransactionProvider::class),
    $container->get(CurrencyService::class),
    new PrivateTransactionFeeCounter(),
));
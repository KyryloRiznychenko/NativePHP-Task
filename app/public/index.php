<?php

global $container;

use App\Services\CommissionFeeService;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../bootstrap/bootstrap.php";

/** @var CommissionFeeService $commissionFeeService */
$commissionFeeService = $container->get(CommissionFeeService::class);
$outPutResult = $commissionFeeService->calculateCommissionFees();


foreach ($outPutResult as $result) {
    echo "$result\n";
}
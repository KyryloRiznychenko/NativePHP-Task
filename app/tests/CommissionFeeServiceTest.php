<?php

namespace Tests;

use App\Services\CommissionFeeService;
use PHPUnit\Framework\TestCase;

class CommissionFeeServiceTest extends TestCase
{
    public function testCalculateCommissionFees()
    {
        $outputFromGitHubTaskExample = [
            0.60,
            3.00,
            0.00,
            0.06,
            1.50,
            0,
            0.70,
            0.30,
            0.30,
            3.00,
            0.00,
            0.00,
            8612,
        ];

        global $container;
        /** @var CommissionFeeService $commissionFeeService */
        $commissionFeeService = $container->get(CommissionFeeService::class);
        $result = $commissionFeeService->calculateCommissionFees();

        $this->assertEquals($outputFromGitHubTaskExample, $result);
    }
}
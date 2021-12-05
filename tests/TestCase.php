<?php

namespace Tests;

use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function mockClientRequest($available = true, $price = 29900)
    {
        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available, $price));

        // Can also be done as:
        // ClientFactory::shouldReceive('make->checkAvailability')
        // ->andReturn(
        //     new StockStatus($available = true, $price = 9900)
        // );

        // Or:
        // $clientMock = Mockery::mock(Client::class);
        // $clientMock->shouldReceive('checkAvailability')->andReturn(new StockStatus($available = true, $price = 9900));
        // ClientFactory::shouldReceive('make')->andReturn($clientMock);

        // Or:
        // ClientFactory::shouldReceive('make')->andReturn(new class implements Client
        // {
        //     public function checkAvailability(Stock $stock): StockStatus
        //     {
        //         return new StockStatus($available = true, $price = 9900);
        //     }
        // });
    }
}

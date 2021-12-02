<?php

namespace Tests\Unit;

use App\Clients\ClientException;
use App\Clients\StockStatus;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_throws_an_exception_if_client_is_not_found_when_tracking()
    {
        $this->seed(RetailerWithProductSeeder::class);

        Retailer::first()->update(['name' => 'Foo Retailer']);

        $this->expectException(ClientException::class);

        Stock::first()->track();
    }

    /** @test */
    function it_updates_local_stock_status_after_being_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(
                new StockStatus($available = true, $price = 9900)
            );

        // Can also be done as:
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

        $stock = tap(Stock::first())->track();

        $this->assertTrue($stock->in_stock);
        $this->assertEquals(9900, $stock->price);
    }
}

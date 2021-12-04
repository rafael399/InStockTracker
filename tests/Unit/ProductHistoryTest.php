<?php

namespace Tests\Unit;

use App\Models\ProductHistory;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_records_history_each_time_stock_is_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

        Http::fake(fn () => ['salePrice' => 99.00, 'onlineAvailability' => true]);

        $this->assertEquals(0, ProductHistory::count());

        $stock = tap(Stock::first())->track();

        $this->assertEquals(1, ProductHistory::count());

        $history = ProductHistory::first();

        $this->assertEquals($stock->price, $history->price);
        $this->assertEquals($stock->in_stock, $history->in_stock);
        $this->assertEquals($stock->product_id, $history->product_id);
        $this->assertEquals($stock->id, $history->stock_id);
    }
}

<?php

namespace Tests\Unit;

use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_records_history_each_time_stock_is_tracked()
    {
        Notification::fake();

        $this->seed(RetailerWithProductSeeder::class);

        $this->mockClientRequest($available = true, $price = 99);

        $product = tap(Product::first(), function ($product) {
            $this->assertCount(0, $product->productHistory);

            $product->track();

            $this->assertCount(1, $product->refresh()->productHistory);
        });

        $history = $product->productHistory->first();
        $this->assertEquals($price, $history->price);
        $this->assertEquals($available, $history->in_stock);
        $this->assertEquals($product->id, $history->product_id);
        $this->assertEquals($product->stock[0]->id, $history->stock_id);
    }
}

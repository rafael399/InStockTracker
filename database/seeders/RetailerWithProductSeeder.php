<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;

class RetailerWithProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $switch = Product::create(['name' => 'Nintendo Switch']);

        $bestBuy = Retailer::create(['name' => 'Best Buy']);

        $bestBuy->addStock($switch, new Stock([
            'price' => 10000,
            'url' => 'https://',
            'sku' => '12345',
            'in_stock' => false
        ]));

        User::factory()->create(['email' => 'john@email.com']);
    }
}

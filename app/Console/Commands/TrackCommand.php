<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class TrackCommand extends Command
{
    protected $signature = 'track';

    protected $description = 'Track all product stock';

    public function handle()
    {
        $products = Product::all();

        $this->output->progressStart($products->count());

        $products->each(function ($product) {
            $product->track();

            $this->output->progressAdvance();
        });

        $this->showResults();
    }

    protected function showResults()
    {
        $this->output->progressFinish();

        $data = Product::leftJoin('stock', 'stock.product_id', '=', 'products.id')
            ->get(['name', 'price', 'url', 'in_stock']);

        $this->table(
            ['Name', 'Price', 'Url', 'In Stock'],
            $data
        );
    }
}

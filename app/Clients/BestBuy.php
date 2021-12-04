<?php

namespace App\Clients;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class BestBuy implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {
        $results = Http::get($this->endpoint($stock->sku))->json();

        return new StockStatus(
            $results['onlineAvailability'],
            $this->dollarsToCents($results['salePrice'])
        );
    }

    protected function endpoint($sku): string
    {
        $apiKey = config('services.clients.bestBuy.apiKey');

        return "https://api.bestbuy.com/v1/products/{$sku}.json?apiKey={$apiKey}";
    }

    private function dollarsToCents($value)
    {
        return (int) ($value * 100);
    }
}

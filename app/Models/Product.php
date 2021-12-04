<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function track()
    {
        $this->stock->each->track(
            fn ($stock) => $this->recordProductHistory($stock)
        );
    }

    public function inStock()
    {
        return $this->stock()->where('in_stock', true)->exists();
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function productHistory()
    {
        return $this->hasMany(ProductHistory::class);
    }

    public function recordProductHistory(Stock $stock): void
    {
        $this->productHistory()->create([
            'price' => $stock->price,
            'in_stock' => $stock->in_stock,
            'stock_id' => $stock->id,
        ]);
    }
}

<?php

namespace App\Models;

use App\UseCases\TrackStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function track()
    {
        TrackStock::dispatch($this);

        // Can also be done as:
        // dispatch(new TrackStock($this));

        // Or:
        // (new TrackStock($this))->handle();
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

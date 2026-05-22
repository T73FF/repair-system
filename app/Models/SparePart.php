<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    protected $fillable = [
        'article', 'name', 'brand', 'purchase_price', 
        'sale_price', 'stock_quantity', 'min_stock', 'category', 'notes'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function orderSpareParts()
    {
        return $this->hasMany(OrderSparePart::class);
    }
}
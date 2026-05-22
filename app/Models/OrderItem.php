<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'repair_order_id', 'service_name', 'price', 'quantity', 'total'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function repairOrder()
    {
        return $this->belongsTo(RepairOrder::class);
    }
}
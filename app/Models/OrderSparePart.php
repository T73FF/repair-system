<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderSparePart extends Model
{
    protected $fillable = [
        'repair_order_id', 'spare_part_id', 'quantity', 
        'price_per_unit', 'total'
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function repairOrder()
    {
        return $this->belongsTo(RepairOrder::class);
    }

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }
}
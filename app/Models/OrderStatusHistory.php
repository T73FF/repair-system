<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    protected $table = 'order_status_history';   // ← Вот это важно!

    protected $fillable = [
        'repair_order_id', 'old_status', 'new_status', 
        'changed_by', 'comment'
    ];

    public function repairOrder()
    {
        return $this->belongsTo(RepairOrder::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'changed_by');
    }
}
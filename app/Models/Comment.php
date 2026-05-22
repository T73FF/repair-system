<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'repair_order_id', 'user_id', 'comment', 'is_internal'
    ];

    public function repairOrder()
    {
        return $this->belongsTo(RepairOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    protected $fillable = [
        'user_id', 'full_name', 'phone', 'specialization', 'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function repairOrders()
    {
        return $this->hasMany(RepairOrder::class);
    }
}
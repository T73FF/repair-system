<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'phone', 'email', 'address', 'passport', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function repairOrders()
    {
        return $this->hasMany(RepairOrder::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'client_id', 'brand', 'model', 'serial_number', 'category',
        'manufacture_year', 'photos', 'condition', 'notes'
    ];

    protected $casts = [
        'photos' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function repairOrders()
    {
        return $this->hasMany(RepairOrder::class);
    }
}
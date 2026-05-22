<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairOrder extends Model
{
    protected $fillable = [
        'order_number', 'client_id', 'equipment_id', 'technician_id',
        'created_by', 'status', 'repair_type', 'problem_description',
        'diagnostic_result', 'work_done', 'total_amount', 'paid_amount', 'deadline'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'deadline' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function spareParts()
    {
        return $this->hasMany(OrderSparePart::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }
}
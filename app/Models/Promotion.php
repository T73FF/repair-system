<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'title', 'description', 'code', 'discount_percent',
        'discount_amount', 'starts_at', 'expires_at', 'is_active',
        'background_color', 'text_color'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isActive()
    {
        return $this->is_active && now()->between($this->starts_at, $this->expires_at);
    }

    public function getRemainingSeconds()
    {
        if (!$this->isActive()) return 0;
        return max(0, $this->expires_at->timestamp - now()->timestamp);
    }
}
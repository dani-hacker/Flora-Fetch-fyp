<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'plant_id',
        'quantity',
        'price_at_purchase',
    ];

    protected $casts = [
        'price_at_purchase' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public function getLineTotalAttribute(): float
    {
        return $this->quantity * $this->price_at_purchase;
    }
}

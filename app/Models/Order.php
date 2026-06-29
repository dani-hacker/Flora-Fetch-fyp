<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'shipping_address',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Status helpers
    public function isPending(): bool    { return $this->status === 'Pending'; }
    public function isProcessing(): bool { return $this->status === 'Processing'; }
    public function isDelivered(): bool  { return $this->status === 'Delivered'; }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'Pending'    => 'yellow',
            'Processing' => 'blue',
            'Delivered'  => 'green',
            default      => 'gray',
        };
    }
}

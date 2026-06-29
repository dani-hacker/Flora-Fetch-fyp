<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'sunlight_requirement',
        'watering_need',
        'stock_quantity',
        'image_url',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    // Relationships
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes for filtering
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeBySunlight($query, $sunlight)
    {
        return $query->where('sunlight_requirement', $sunlight);
    }

    public function scopeByWatering($query, $watering)
    {
        return $query->where('watering_need', $watering);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    // Helper
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function getImagePathAttribute(): string
    {
        return $this->image_url
            ? asset('images/plants/' . $this->image_url)
            : asset('images/placeholder.jpg');
    }
}

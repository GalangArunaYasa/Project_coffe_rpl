<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'kategori',
        'tag',
        'gambar',
        'is_active',
        'is_bestseller',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_bestseller' => 'boolean',
        'harga' => 'integer',
        'stok' => 'integer',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function restockLogs(): HasMany
    {
        return $this->hasMany(RestockLog::class);
    }

    public function restockRequests(): HasMany
    {
        return $this->hasMany(RestockRequest::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBestseller($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeLowStock($query, $threshold = 5)
    {
        return $query->where('stok', '<=', $threshold);
    }
}
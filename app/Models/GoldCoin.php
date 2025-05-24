<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldCoin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'karat',
        'price_per_gram',
        'description',
        'image',
        'image_driver',
        'status'
    ];

    protected $casts = [
        'price_per_gram' => 'decimal:8',
        'status' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(GoldCoinOrder::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}

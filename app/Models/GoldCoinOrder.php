<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldCoinOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gold_coin_id',
        'weight_in_grams',
        'price_per_gram',
        'subtotal',
        'purchase_charges',
        'total_charges',
        'gst_amount',
        'total_price',
        'payment_source',
        'status',
        'admin_feedback',
        'trx_id',
        'address',
    ];

    protected $casts = [
        'weight_in_grams' => 'decimal:8',
        'price_per_gram' => 'decimal:8',
        'subtotal' => 'decimal:8',
        'purchase_charges' => 'array',
        'total_charges' => 'decimal:8',
        'gst_amount' => 'decimal:8',
        'total_price' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function goldCoin()
    {
        return $this->belongsTo(GoldCoin::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    /**
     * Get formatted charges breakdown
     */
    public function getChargesBreakdown()
    {
        if (!$this->purchase_charges) {
            return [];
        }

        return $this->purchase_charges;
    }

    /**
     * Get total charges amount
     */
    public function getTotalChargesAmount()
    {
        return $this->total_charges ?? $this->gst_amount ?? 0;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'type',
        'value',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'value' => 'decimal:4',
        'status' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Calculate charge amount based on subtotal
     */
    public function calculateChargeAmount($subtotal)
    {
        if ($this->type === 'percentage') {
            return ($subtotal * $this->value) / 100;
        } else {
            return $this->value;
        }
    }

    /**
     * Get all active charges ordered by sort order
     */
    public static function getActiveCharges()
    {
        return self::active()->ordered()->get();
    }
}

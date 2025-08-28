<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LaravelNovaSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_name',
        'monthly_price',
        'status',
        'start_date',
        'next_renewal_date',
        'last_renewed_date',
        'renewal_code',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'next_renewal_date' => 'date',
        'last_renewed_date' => 'date',
        'monthly_price' => 'decimal:2'
    ];

    /**
     * Get the number of days until renewal
     */
    public function getDaysUntilRenewalAttribute()
    {
        return Carbon::now()->diffInDays($this->next_renewal_date, false);
    }

    /**
     * Check if subscription is active
     */
    public function isActive()
    {
        return $this->status === 'active' && $this->next_renewal_date->isFuture();
    }

    /**
     * Check if subscription is expired
     */
    public function isExpired()
    {
        return $this->next_renewal_date->isPast();
    }

    /**
     * Get subscription status with color
     */
    public function getStatusColorAttribute()
    {
        if ($this->isActive()) {
            return 'success';
        } elseif ($this->isExpired()) {
            return 'danger';
        } else {
            return 'warning';
        }
    }

    /**
     * Get subscription status text
     */
    public function getStatusTextAttribute()
    {
        if ($this->isActive()) {
            return 'Active';
        } elseif ($this->isExpired()) {
            return 'Expired';
        } else {
            return 'Cancelled';
        }
    }

    /**
     * Renew subscription for one month
     */
    public function renew()
    {
        $this->last_renewed_date = Carbon::now();
        $this->next_renewal_date = $this->next_renewal_date->addMonth();
        $this->status = 'active';
        $this->save();
    }
}

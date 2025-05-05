<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class UserPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'purchase_date',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'purchase_date' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the plan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan that is purchased.
     */
    public function plan()
    {
        return $this->belongsTo(ManagePlan::class, 'plan_id');
    }

    /**
     * Check if the plan is active.
     */
    public function isActive()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at === null) {
            // This is a lifetime plan
            return true;
        }

        return $this->expires_at > Carbon::now();
    }
}

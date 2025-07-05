<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RgpTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_type',
        'side',
        'amount',
        'previous_rgp_l',
        'previous_rgp_r',
        'new_rgp_l',
        'new_rgp_r',
        'transaction_id',
        'remarks',
        'source',
        'related_user_id',
        'plan_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'previous_rgp_l' => 'decimal:2',
        'previous_rgp_r' => 'decimal:2',
        'new_rgp_l' => 'decimal:2',
        'new_rgp_r' => 'decimal:2',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'firstname' => 'Unknown',
            'lastname' => 'User',
            'username' => 'unknown',
            'email' => 'unknown@example.com'
        ]);
    }

    /**
     * Get the related user (if applicable).
     */
    public function relatedUser()
    {
        return $this->belongsTo(User::class, 'related_user_id');
    }

    /**
     * Get the plan (if applicable).
     */
    public function plan()
    {
        return $this->belongsTo(ManagePlan::class, 'plan_id');
    }
} 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBankDetail extends Model
{
    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'ifsc_code',
        'is_verified'
    ];
    
    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
    
    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldAgentInventoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gold_coin_id',
        'change_type',
        'quantity_change',
        'reference',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function goldCoin()
    {
        return $this->belongsTo(GoldCoin::class);
    }
}



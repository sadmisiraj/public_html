<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldAgentInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gold_coin_id',
        'stock',
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



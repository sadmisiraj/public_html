<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;



    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            \Cache::forget('ConfigureColor');
        });
    }
}

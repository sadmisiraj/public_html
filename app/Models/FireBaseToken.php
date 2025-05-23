<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FireBaseToken extends Model
{
    use HasFactory;

    protected $fillable = ['tokenable_id', 'tokenable_type', 'token'];

    public function tokenable()
    {
        return $this->morphTo(__FUNCTION__, 'tokenable_type', 'tokenable_id');
    }
}

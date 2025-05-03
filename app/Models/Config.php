<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'configs';
    
    protected $fillable = [
        'name',
        'display_name',
        'value'
    ];

    public static function getConfig($name)
    {
        return self::where('name', $name)->first()->value ?? 0;
    }

    public static function updateConfig($name, $value)
    {
        $config = self::where('name', $name)->first();
        if ($config) {
            $config->value = $value;
            $config->save();
            return true;
        }
        return false;
    }
} 
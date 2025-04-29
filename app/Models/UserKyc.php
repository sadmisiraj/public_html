<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UserKyc extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'kyc_id', 'kyc_type', 'kyc_info', 'status', 'reason'];

    protected $casts = [
        'kyc_info' => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kyc()
    {
        return $this->belongsTo(Kyc::class, 'kyc_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('userKYCRecord');
        });
    }

    public function getKycAttribute()
    {
        $kycInfo =  [];
        foreach ($this->kyc_info as $key =>  $item){

            if ($item->type === 'file'){
                $kycInfo[$key]['field_name'] =  $item->field_name;
                $kycInfo[$key]['field_label'] = $item->field_label;
                $kycInfo[$key]['field_value'] = getFile($item->field_driver , $item->field_value);
                $kycInfo[$key]['type'] = $item->type;
            }else{
                $kycInfo[$key]['field_name'] =  $item->field_name;
                $kycInfo[$key]['field_label'] = $item->field_label;
                $kycInfo[$key]['field_value'] = $item->field_value;
                $kycInfo[$key]['type'] = $item->type;
            }
        }
        return (object)$kycInfo;
    }

}

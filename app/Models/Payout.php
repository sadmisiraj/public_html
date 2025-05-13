<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Payout extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'payout_method_id', 'payout_currency_code', 'amount', 'charge', 'net_amount', 'amount_in_base_currency',
    'charge_in_base_currency', 'net_amount_in_base_currency', 'response_id', 'last_error', 'information', 'meta_field', 'feedback', 'trx_id', 'status'];

    protected $table = 'payouts';

    protected $casts = [
        'information' => 'object',
        'meta_field' => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function method()
    {
        return $this->belongsTo(PayoutMethod::class, 'payout_method_id');
    }

    public function getStatusClass()
    {
        return [
            '1' => 'text-pending',
            '2' => 'text-success',
            '3' => 'text-danger',
        ][$this->status] ?? 'text-success';
    }

    public function transactional()
    {
        return $this->morphOne(Transaction::class, 'transactional');
    }

    public function picture()
    {
        $image = $this->method->image;
        if (!$image) {
            $url = getFile($this->method->driver, $this->method->logo);
            return '<div class="avatar avatar-sm avatar-circle">
                        <img class="avatar-img" src="' . $url . '" alt="Image Description">
                     </div>';

        } else {
            $firstLetter = substr($this->method->name, 0, 1);
            return '<div class="avatar avatar-sm avatar-soft-primary avatar-circle">
                        <span class="avatar-initials">' . $firstLetter . '</span>
                     </div>';
        }
    }


    public static function boot(): void
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('payoutRecord');
        });

        static::creating(function (Payout $payout) {
            if (empty($payout->trx_id)) {
                $payout->trx_id = self::generateOrderNumber();
            }
        });
    }
    public static function generateOrderNumber()
    {
        return DB::transaction(function () {
            $lastOrder = self::lockForUpdate()->orderBy('id', 'desc')->first();
            if ($lastOrder && isset($lastOrder->trx_id)) {
                $lastOrderNumber = (int)filter_var($lastOrder->trx_id, FILTER_SANITIZE_NUMBER_INT);
                $newOrderNumber = $lastOrderNumber + 1;
            } else {
                $newOrderNumber = strRandomNum(12);
            }

            // Check again to ensure the new trx_id doesn't already exist (extra safety)
            while (self::where('trx_id', 'P'.$newOrderNumber)->exists()) {
                $newOrderNumber = (int)$newOrderNumber + 1;
            }
            return 'P' . $newOrderNumber;
        });
    }

    public function getInformation()
    {
        $info = [];
        $information = $this->information;
        
        if (empty($information)) {
            return $info;
        }

        foreach ($information as $key =>  $item) {
            if ($item->type === 'file'){
                $info[$key]['field_name'] =  $item->field_name;
                $info[$key]['field_value'] = getFile($item->field_driver , $item->field_value);
                $info[$key]['type'] = $item->type;
            }else{
                $info[$key]['field_name'] =  $item->field_name;
                $info[$key]['field_value'] = $item->field_value;
                $info[$key]['type'] = $item->type;
            }
        }
        return $info;
    }


}

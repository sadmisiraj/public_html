<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MoneyTransfer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (MoneyTransfer $moneyTransfer) {
            if (empty($moneyTransfer->trx)) {
                $moneyTransfer->trx = self::generateOrderNumber();
            }
        });
    }
    public static function generateOrderNumber()
    {
        return DB::transaction(function () {
            $lastOrder = self::lockForUpdate()->orderBy('id', 'desc')->first();
            if ($lastOrder && isset($lastOrder->trx)) {
                $lastOrderNumber = (int)filter_var($lastOrder->trx, FILTER_SANITIZE_NUMBER_INT);
                $newOrderNumber = $lastOrderNumber + 1;
            } else {
                $newOrderNumber = strRandomNum(12);
            }

            // Check again to ensure the new trx_id doesn't already exist (extra safety)
            while (self::where('trx', 'MT'.$newOrderNumber)->exists()) {
                $newOrderNumber = (int)$newOrderNumber + 1;
            }
            return 'MT' . $newOrderNumber;
        });
    }
}

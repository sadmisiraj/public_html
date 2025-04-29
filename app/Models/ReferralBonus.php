<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReferralBonus extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "referral_bonuses";

    public function user(){
        return $this->belongsTo(User::class,'from_user_id','id');
    }
    public function bonusBy(){
        return $this->belongsTo(User::class,'to_user_id','id');
    }

    public function getUser() :string
    {
        $url = route('admin.user.view.profile', optional($this->user)->id??1);
        return '<a class="d-flex align-items-center me-2" href="' . $url . '">
                                <div class="flex-shrink-0">
                                  ' . optional($this->user)->profilePicture() . '
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . optional($this->user)->firstname . ' ' . optional($this->user)->lastname . '</h5>
                                  <span class="fs-6 text-body">@' . optional($this->user)->username . '</span>
                                </div>
                              </a>';
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (ReferralBonus $referralBonus) {
            if (empty($referralBonus->transaction)) {
                $referralBonus->transaction = self::generateOrderNumber();
            }
        });
    }
    public static function generateOrderNumber()
    {
        return DB::transaction(function () {
            $lastOrder = self::lockForUpdate()->orderBy('id', 'desc')->first();
            if ($lastOrder && isset($lastOrder->transaction)) {
                $lastOrderNumber = (int)filter_var($lastOrder->transaction, FILTER_SANITIZE_NUMBER_INT);
                $newOrderNumber = $lastOrderNumber + 1;
            } else {
                $newOrderNumber = strRandomNum(12);
            }

            // Check again to ensure the new trx_id doesn't already exist (extra safety)
            while (self::where('transaction', 'R'.$newOrderNumber)->exists()) {
                $newOrderNumber = (int)$newOrderNumber + 1;
            }
            return 'R' . $newOrderNumber;
        });
    }

    public function transactional()
    {
        return $this->morphOne(Transaction::class, 'transactional');
    }

}

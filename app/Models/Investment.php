<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Investment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $appends = ['nextPayment'];

    public function getNextPaymentAttribute()
    {
        $start = new \DateTime(($this->formerly) ?: $this->created_at);
        $end = new \DateTime($this->afterward);
        $current = new \DateTime();

        if ($current < $start) {
            // If the current date is before the start date
            $percent = 0.0;
        } elseif ($current > $end) {
            // If the current date is after the end date
            $percent = 1.0;
        } else {
            // If the current date is between the start and end dates
            $totalInterval = $end->diff($start);
            $elapsedInterval = $current->diff($start);

            // Calculate the progress percentage based on elapsed time
            if($totalInterval->format('%a') != 0){
                $percent = $elapsedInterval->format('%a') / $totalInterval->format('%a');
            }else{
                $percent = 0;
            }
        }

        return sprintf('%.2f%%', $percent * 100);
    }


    public function plan()
    {
        return $this->belongsTo(ManagePlan::class,'plan_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
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

    public function getPlan()
    {
        return '<div class="flex-grow-1 ms-3">
                  <h5 class="text-hover-primary mb-0">' . optional($this->plan)->name .'</h5>
                  <span class="fs-6 text-body">' . currencyPosition($this->amount) . '</span>
                </div>';
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (Investment $investment) {
            if (empty($investment->trx)) {
                $investment->trx = self::generateOrderNumber();
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
            while (self::where('trx', 'INV'.$newOrderNumber)->exists()) {
                $newOrderNumber = (int)$newOrderNumber + 1;
            }
            return 'INV' . $newOrderNumber;
        });
    }

    public function transactional()
    {
        return $this->morphOne(Transaction::class, 'transactional');
    }
}

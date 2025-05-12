<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagePlan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'badge',
        'minimum_amount',
        'maximum_amount',
        'fixed_amount',
        'profit',
        'profit_type',
        'schedule',
        'status',
        'is_capital_back',
        'is_lifetime',
        'repeatable',
        'featured',
        'eligible_for_referral',
        'eligible_for_rgp',
        'base_plan_id',
        'allow_multiple_purchase',
        'referral_levels'
    ];

    protected $appends = ['price'];

    /*
    * Price With Currency
    */
    public function getPriceAttribute()
    {
        if ($this->fixed_amount == 0) {
            return currencyPosition($this->minimum_amount+0 ) . ' - ' . currencyPosition($this->maximum_amount+0 );
        }
        return currencyPosition($this->fixed_amount+0);
    }

    public function getStatusMessageAttribute()
    {

        if ($this->status == 0) {
            return '<span class="badge bg-soft-warning text-warning">
                    <span class="legend-indicator bg-warning"></span>' . trans('In-active') . '
                  </span>';
        }
        return '<span class="badge bg-soft-success text-success">
                    <span class="legend-indicator bg-success"></span>' . trans('Active') . '
                  </span>';
    }

    public function getFeaturedMessageAttribute()
    {

        if ($this->featured == 0) {
            return  '<span class="badge bg-soft-warning text-warning">
                    <span class="legend-indicator bg-warning"></span>' . trans('No') . '
                  </span>';
        }
        return  '<span class="badge bg-soft-success text-success">
                    <span class="legend-indicator bg-success"></span>' . trans('Yes') . '
                  </span>';
    }

    public function getReferralEligibilityMessageAttribute()
    {
        if ($this->eligible_for_referral == 0) {
            return  '<span class="badge bg-soft-warning text-warning">
                    <span class="legend-indicator bg-warning"></span>' . trans('No') . '
                  </span>';
        }
        return  '<span class="badge bg-soft-success text-success">
                    <span class="legend-indicator bg-success"></span>' . trans('Yes') . '
                  </span>';
    }

    public function getCapitalBackStatus()
    {
        if ($this->is_capital_back == 0) {
            return '
                    <span class="badge bg-danger">' . trans('No') . '</span>
                  ';
        }
        return '
                    <span class="badge bg-success">' . trans('Yes') . '</span>
                  ';
    }


    public function profitFor()
    {
        $time = ManageTime::where('time', $this->schedule)->first();
        if ($time) {
            return $time->name;
        }
    }

    public function time()
    {
        return $this->hasOne(ManageTime::class,'time','schedule');
    }

    public function capitalCal()
    {
        if ($this->is_lifetime == 0) {
            if ($this->profit_type == 1) {
                if ($this->is_capital_back == 1) {
                    $capitalEarning = 'Total ' . ($this->profit * $this->repeatable) . '% + Capital';
                } else {
                    $capitalEarning = 'Total ' . ($this->profit * $this->repeatable) . ' ' . config('basic.currency');
                }
            } else {
                if ($this->is_capital_back == 1) {
                    $capitalEarning = 'Total ' . ($this->profit * $this->repeatable) . ' ' . config('basic.currency') . ' + Capital';
                } else {
                    $capitalEarning = 'Total ' . ($this->profit * $this->repeatable) . ' ' . config('basic.currency');
                }
            }
        } else {
            $capitalEarning = trans('Lifetime Earning');
        }
        return $capitalEarning;
    }

    public function depositable()
    {
        return $this->morphOne(Deposit::class, 'depositable');
    }

    public function transactional()
    {
        return $this->morphOne(Transaction::class, 'transactional');
    }

    public function investment()
    {
        return $this->hasMany(Investment::class, 'plan_id');
    }

    /**
     * Get the base plan for this plan
     */
    public function basePlan()
    {
        return $this->belongsTo(ManagePlan::class, 'base_plan_id');
    }

    /**
     * Get plans that have this plan as their base
     */
    public function childPlans()
    {
        return $this->hasMany(ManagePlan::class, 'base_plan_id');
    }

    /**
     * Get the user plans associated with this plan
     */
    public function userPlans()
    {
        return $this->hasMany(UserPlan::class, 'plan_id');
    }
}

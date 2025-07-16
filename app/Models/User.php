<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Notify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Notify;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    public $allusers = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $appends = ['last-seen-activity','fullname','mobile'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'rgp_l' => 'integer',
        'rgp_r' => 'integer',
        'rgp_pair_matching' => 'integer',
    ];

    /**
     * Get the RGP L value as an integer
     */
    public function getRgpLAttribute($value)
    {
        return $value ? (int) $value : 0;
    }

    /**
     * Set the RGP L value
     */
    public function setRgpLAttribute($value)
    {
        $this->attributes['rgp_l'] = $value ? (int) $value : 0;
    }

    /**
     * Get the RGP R value as an integer
     */
    public function getRgpRAttribute($value)
    {
        return $value ? (int) $value : 0;
    }

    /**
     * Set the RGP R value
     */
    public function setRgpRAttribute($value)
    {
        $this->attributes['rgp_r'] = $value ? (int) $value : 0;
    }

    /**
     * Get the RGP pair matching value as an integer
     */
    public function getRgpPairMatchingAttribute($value)
    {
        return $value ? (int) $value : 0;
    }

    /**
     * Set the RGP pair matching value
     */
    public function setRgpPairMatchingAttribute($value)
    {
        $this->attributes['rgp_pair_matching'] = $value ? (int) $value : 0;
    }

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
        'balance',
        'interest_balance',
        'profit_balance',
        'total_invest',
        'total_deposit',
        'total_interest_balance',
        'status',
        'provider',
        'provider_id',
        'image',
        'image_driver',
        'country_code',
        'country',
        'phone_code',
        'phone',
        'state',
        'city',
        'zip_code',
        'address',
        'referral_id',
        'referral_node',
        'language_id',
        'admin_update_badge',
        'last_lavel',
        'last_login',
        'fcm_token',
        'email_key',
        'sms_key',
        'push_key',
        'in_app_key',
        'github_id',
        'google_id',
        'facebook_id',
        'prepaid_remaning_words',
        'prepaid_remaning_images',
        'prepaid_remaning_characters',
        'subs_remaning_words',
        'subs_remaning_images',
        'subs_remaning_characters',
        'subs_expired_at',
        'rgp_l',
        'rgp_r',
        'rgp_pair_matching',
        'dashboard_label',
        'dashboard_value',
        'freeze_daily_credit_show',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('userRecord');
        });
    }

    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getMobileAttribute()
    {
        return $this->phone_code . $this->phone;
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class,'user_id')->latest()->where('status', '!=', 0);
    }


    public function transaction()
    {
        return $this->hasOne(Transaction::class)->latest();
    }

    public function payout()
    {
        return $this->hasMany(Payout::class, 'user_id');
    }


    public function getLastSeenActivityAttribute()
    {
        if (Cache::has('user-is-online-' . $this->id) == true) {
            return true;
        } else {
            return false;
        }
    }


    public function inAppNotification()
    {
        return $this->morphOne(InAppNotification::class, 'inAppNotificationable', 'in_app_notificationable_type', 'in_app_notificationable_id');
    }

    public function fireBaseToken()
    {
        return $this->morphMany(FireBaseToken::class, 'tokenable');
    }

    public function profilePicture()
    {
        $activeStatus = $this->LastSeenActivity === false ? 'warning' : 'success';
        $firstName = $this->firstname;
        $firstLetter = $this->firstLetter($firstName);
        if (!$this->image) {
            return $this->getInitialsAvatar($firstLetter, $activeStatus);
        } else {
            $url = getFile($this->image_driver, $this->image);
            return $this->getImageAvatar($url, $activeStatus);
        }
    }

    public function firstLetter($firstName)
    {
        if (is_string($firstName)) {
            $firstName = mb_convert_encoding($firstName, 'UTF-8', 'auto');
        } else {
            $firstName = '';
        }
        $firstLetter = !empty($firstName) ? substr($firstName, 0, 1) : '';

        if (!mb_check_encoding($firstLetter, 'UTF-8')) {
            $firstLetter = '';
        }
        return $firstLetter;
    }

    private function getInitialsAvatar($initial, $activeStatus)
    {
        return <<<HTML
                <div class="avatar avatar-sm avatar-soft-primary avatar-circle">
                    <span class="avatar-initials">{$initial}</span>
                    <span class="avatar-status avatar-sm-status avatar-status-{$activeStatus}"></span>
                </div>
                HTML;
    }

    private function getImageAvatar($url, $activeStatus)
    {
        return <<<HTML
            <div class="avatar avatar-sm avatar-circle">
                <img class="avatar-img" src="{$url}" alt="Image Description">
                <span class="avatar-status avatar-sm-status avatar-status-{$activeStatus}"></span>
            </div>
            HTML;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->mail($this, 'PASSWORD_RESET_NOTIFICATION', $params = [
            'message' => '<a href="' . url('password/reset', $token) . '?email=' . $this->email . '" target="_blank">'.trans('Click To Reset Password').'</a>'
        ]);
    }



    public function referral()
    {
        return $this->belongsTo(User::class, 'referral_id');
    }

    public function getReferralLinkAttribute()
    {
        return $this->referral_link = route('register', ['ref' => $this->username]);
    }

    public function referralBonusLog()
    {
        return $this->hasMany(ReferralBonus::class, 'from_user_id', 'id');
    }


    public function invests()
    {
        return $this->hasMany(Investment::class)->latest();
    }

    /**
     * Get the plans purchased by the user
     */
    public function userPlans()
    {
        return $this->hasMany(UserPlan::class);
    }

    /**
     * Check if user has an active plan
     *
     * @param int $planId
     * @return bool
     */
    public function hasActivePlan($planId)
    {
        return $this->userPlans()
            ->where('plan_id', $planId)
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->exists();
    }

    /**
     * Check if user has purchased a base plan required for a given plan
     *
     * @param int $basePlanId
     * @return bool
     */
    public function hasBasePlan($basePlanId)
    {
        if (!$basePlanId) {
            return true; // No base plan required
        }
        
        return $this->hasActivePlan($basePlanId);
    }

    public function rank()
    {
        return $this->hasOne(Ranking::class, 'rank_lavel', 'last_lavel');
    }

    public function scopeLevel()
    {
        $count = 0;
        $user_id = $this->id;
        while ($user_id != null) {
            $user = User::where('referral_id', $user_id)->first();
            if (!$user) {
                break;
            } else {
                $user_id = $user->id;
                $count++;
            }
        }
        return $count;
    }

    public function referralUsers($id, $currentLevel = 1)
    {
        $users = $this->getUsers($id);
        if ($users['status']) {
            $this->allusers[$currentLevel] = $users['user'];
            $currentLevel++;
            $this->referralUsers($users['ids'], $currentLevel);
        }
        return $this->allusers;
    }

    public function getUsers($id)
    {
        if (isset($id)) {
            $data['user'] = User::whereIn('referral_id', $id)->get(['id', 'firstname', 'lastname', 'username', 'email', 'phone_code', 'phone', 'referral_id', 'created_at']);
            if (count($data['user']) > 0) {
                $data['status'] = true;
                $data['ids'] = $data['user']->pluck('id');
                return $data;
            }
        }
        $data['status'] = false;
        return $data;
    }

    /**
     * Calculate and get RGP pair matching value
     * 
     * @return float
     */
    public function getRgpPairMatchingValueAttribute()
    {
        // Calculate the matching value (minimum of left and right)
        return min(floatval($this->rgp_l ?? 0), floatval($this->rgp_r ?? 0));
    }

    /**
     * Update RGP pair matching value whenever rgp_l or rgp_r changes
     */
    public function updateRgpPairMatching()
    {
        $this->rgp_pair_matching = $this->getRgpPairMatchingValueAttribute();
        return $this;
    }

    /**
     * Find the leftmost available node in the RGP tree
     * 
     * @return User|null
     */
    public function findLeftmostRgpNode()
    {
        $currentUser = $this;
        
        // Keep going left until we find a node without a left child
        while ($currentUser) {
            $leftChild = User::where('rgp_parent_id', $currentUser->id)
                            ->where('referral_node', 'left')
                            ->first();
            
            if (!$leftChild) {
                return $currentUser;
            }
            
            $currentUser = $leftChild;
        }
        
        return null;
    }

    /**
     * Find the rightmost available node in the RGP tree
     * 
     * @return User|null
     */
    public function findRightmostRgpNode()
    {
        $currentUser = $this;
        
        // Keep going right until we find a node without a right child
        while ($currentUser) {
            $rightChild = User::where('rgp_parent_id', $currentUser->id)
                             ->where('referral_node', 'right')
                             ->first();
            
            if (!$rightChild) {
                return $currentUser;
            }
            
            $currentUser = $rightChild;
        }
        
        return null;
    }

    /**
     * Get the RGP parent user
     */
    public function rgpParent()
    {
        return $this->belongsTo(User::class, 'rgp_parent_id');
    }

    /**
     * Get the RGP child users
     */
    public function rgpChildren()
    {
        return $this->hasMany(User::class, 'rgp_parent_id');
    }
    
    public function bankDetails()
    {
        return $this->hasOne(UserBankDetail::class);
    }

    public function userKyc()
    {
        return $this->hasOne(UserKyc::class)->latest();
    }

    /**
     * Get the RGP transactions for the user.
     */
    public function rgpTransactions()
    {
        return $this->hasMany(RgpTransaction::class);
    }

}

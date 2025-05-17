<?php

namespace App\Http\Middleware;

use App\Traits\Notify;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PayoutOtpVerification
{
    use Notify;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $basicControl = basicControl();
        
        // Check if OTP verification is required in settings
        if (!$basicControl->require_payout_otp) {
            return $next($request);
        }
        
        // Check if user has already verified for this session
        if (Session::has('payout_otp_verified') && Session::get('payout_otp_verified')) {
            return $next($request);
        }
        
        // Redirect to OTP verification page with the correct route name
        return redirect()->route('user.payout.otp.verification');
    }
    
    /**
     * Check if OTP code is valid
     * 
     * @param $user
     * @param $code
     * @param int $add_min
     * @return bool
     */
    public function checkValidCode($user, $code, $add_min = 10)
    {
        if (!$code) return false;
        if (!$user->sent_at) return false;
        if (Carbon::parse($user->sent_at)->addMinutes($add_min) < Carbon::now()) return false;
        if ($user->verify_code !== $code) return false;
        return true;
    }
} 
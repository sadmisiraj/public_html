<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class PayoutOtpController extends Controller
{
    use Notify;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    /**
     * Show OTP verification page
     */
    public function showVerification()
    {
        $user = $this->user;
        
        // Always generate a new OTP code when accessing the page
        $user->verify_code = code(6);
        $user->sent_at = Carbon::now();
        $user->save();
        
        // Send OTP via SMS
        $this->verifyToSms($user, 'TWO_FACTOR_AUTH', [
            'code' => $user->verify_code
        ]);
        
        session()->flash('success', 'SMS verification code has been sent to your phone');
        
        $page_title = 'Payout Verification';
        return view($this->theme . 'user.payout.otp_verification', compact('user', 'page_title'));
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $rules = [
            'code' => 'required',
        ];
        $msg = [
            'code.required' => 'Verification code is required',
        ];
        $validate = $this->validate($request, $rules, $msg);
        
        $user = $this->user;
        
        if ($this->checkValidCode($user, $request->code)) {
            // Mark session as verified
            Session::put('payout_otp_verified', true);
            
            return redirect()->route('user.payout');
        }
        
        throw ValidationException::withMessages(['error' => 'Verification code didn\'t match!']);
    }

    /**
     * Resend OTP code
     */
    public function resendOtp()
    {
        $user = $this->user;
        
        // Check if user is trying to resend too quickly
        if ($this->checkValidCode($user, $user->verify_code, 2)) {
            $target_time = Carbon::parse($user->sent_at)->addMinutes(2)->timestamp;
            $delay = $target_time - time();
            throw ValidationException::withMessages(['resend' => 'Thanks']);
        }
        
        // Generate new code
        $user->verify_code = code(6);
        $user->sent_at = Carbon::now();
        $user->save();
        
        // Send OTP via SMS
        $this->verifyToSms($user, 'TWO_FACTOR_AUTH', [
            'code' => $user->verify_code
        ]);
        
        return back()->with('success', 'Verification code has been sent to your phone');
    }

    /**
     * Send OTP code via email as a fallback
     */
    public function sendOtpViaEmail()
    {
        $user = $this->user;
        
        // Generate new code
        $user->verify_code = code(6);
        $user->sent_at = Carbon::now();
        $user->save();
        
        // Send OTP via Email
        $this->verifyToMail($user, 'TWO_FACTOR_AUTH', [
            'code' => $user->verify_code
        ], 'Payout Verification Code');
        
        return back()->with('success', 'Verification code has been sent to your email: ' . $user->email);
    }

    
    /**
     * Check if OTP code is valid
     */
    private function checkValidCode($user, $code, $add_min = 10)
    {
        if (!$code) return false;
        if (!$user->sent_at) return false;
        if (Carbon::parse($user->sent_at)->addMinutes($add_min) < Carbon::now()) return false;
        if ($user->verify_code !== $code) return false;
        return true;
    }
} 
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
     * Show OTP verification page with contact options
     */
    public function showVerification()
    {
        $user = $this->user;
        
        // Mask phone number and email for display
        $maskedPhone = $this->maskPhone($user->phone);
        $maskedEmail = $this->maskEmail($user->email);
        
        $page_title = 'Payout Verification';
        return view($this->theme . 'user.payout.otp_verification', compact('user', 'page_title', 'maskedPhone', 'maskedEmail'));
    }

    /**
     * Send OTP via SMS
     */
    public function sendOtpViaSms()
    {
        $user = $this->user;
        
        // Get current resend count or initialize to 0
        $resendCount = Session::get('otp_resend_count', 0);
        
        // Calculate cooldown time based on resend count
        $cooldownSeconds = $this->getCooldownTime($resendCount);
        
        // Convert to minutes for database check (minimum 1 minute)
        $cooldownMinutes = max(1, ceil($cooldownSeconds / 60));
        
        // Check if user is trying to send too quickly
        if ($user->sent_at && Carbon::parse($user->sent_at)->addSeconds($cooldownSeconds) > Carbon::now()) {
            $target_time = Carbon::parse($user->sent_at)->addSeconds($cooldownSeconds)->timestamp;
            $delay = $target_time - time();
            $waitTime = $this->formatWaitTime($delay);
            throw ValidationException::withMessages(['resend' => "Please wait {$waitTime} before requesting another code"]);
        }
        
        // Generate new code only if none exists or it's expired
        if (!$user->verify_code || !$user->sent_at || Carbon::parse($user->sent_at)->addMinutes(10) < Carbon::now()) {
            $user->verify_code = code(6);
        }
        
        $user->sent_at = Carbon::now();
        $user->save();
        
        // Increment resend count
        Session::put('otp_resend_count', $resendCount + 1);
        
        // Send OTP via SMS
        $this->verifyToSms($user, 'TWO_FACTOR_AUTH', [
            'code' => $user->verify_code
        ]);
        
        return back()->with('success', 'Verification code has been sent to your phone');
    }

    /**
     * Send OTP code via email
     */
    public function sendOtpViaEmail()
    {
        $user = $this->user;
        
        // Get current resend count or initialize to 0
        $resendCount = Session::get('otp_resend_count', 0);
        
        // Calculate cooldown time based on resend count
        $cooldownSeconds = $this->getCooldownTime($resendCount);
        
        // Convert to minutes for database check (minimum 1 minute)
        $cooldownMinutes = max(1, ceil($cooldownSeconds / 60));
        
        // Check if user is trying to send too quickly
        if ($user->sent_at && Carbon::parse($user->sent_at)->addSeconds($cooldownSeconds) > Carbon::now()) {
            $target_time = Carbon::parse($user->sent_at)->addSeconds($cooldownSeconds)->timestamp;
            $delay = $target_time - time();
            $waitTime = $this->formatWaitTime($delay);
            throw ValidationException::withMessages(['resend' => "Please wait {$waitTime} before requesting another code"]);
        }
        
        // Generate new code only if none exists or it's expired
        if (!$user->verify_code || !$user->sent_at || Carbon::parse($user->sent_at)->addMinutes(10) < Carbon::now()) {
            $user->verify_code = code(6);
        }
        
        $user->sent_at = Carbon::now();
        $user->save();
        
        // Increment resend count
        Session::put('otp_resend_count', $resendCount + 1);
        
        // Send OTP via Email
        $this->verifyToMail($user, 'TWO_FACTOR_AUTH', [
            'code' => $user->verify_code
        ], 'Payout Verification Code');
        
        return back()->with('success', 'Verification code has been sent to your email: ' . $this->maskEmail($user->email));
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
            // Reset resend counter on successful verification
            Session::forget('otp_resend_count');
            
            // Mark session as verified
            Session::put('payout_otp_verified', true);
            
            return redirect()->route('user.payout');
        }
        
        throw ValidationException::withMessages(['error' => 'Verification code didn\'t match!']);
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
    
    /**
     * Calculate cooldown time based on resend count
     * 0 attempts = no cooldown (initial send)
     * 1 attempt = 10 seconds
     * 2 attempts = 30 seconds
     * 3 attempts = 60 seconds (1 minute)
     * 4+ attempts = 120 seconds (2 minutes)
     */
    private function getCooldownTime($resendCount)
    {
        switch ($resendCount) {
            case 0:
                return 0; // No cooldown for first send
            case 1:
                return 10; // 10 seconds for first resend
            case 2:
                return 30; // 30 seconds for second resend
            case 3:
                return 60; // 1 minute for third resend
            default:
                return 120; // 2 minutes for fourth and subsequent resends
        }
    }
    
    /**
     * Format wait time in user-friendly format
     */
    private function formatWaitTime($seconds)
    {
        if ($seconds < 60) {
            return $seconds . ' seconds';
        } else {
            $minutes = floor($seconds / 60);
            $remainingSeconds = $seconds % 60;
            if ($remainingSeconds > 0) {
                return $minutes . ' minutes and ' . $remainingSeconds . ' seconds';
            } else {
                return $minutes . ' minutes';
            }
        }
    }
    
    /**
     * Mask phone number to show only last 4 digits
     */
    private function maskPhone($phone)
    {
        if (!$phone) return '';
        
        $length = strlen($phone);
        $visibleCount = 4;
        $hiddenCount = $length - $visibleCount;
        
        return str_repeat('*', $hiddenCount) . substr($phone, -$visibleCount);
    }
    
    /**
     * Mask email to show only first character and domain
     */
    private function maskEmail($email)
    {
        if (!$email) return '';
        
        $parts = explode('@', $email);
        if (count($parts) != 2) return $email;
        
        $name = $parts[0];
        $domain = $parts[1];
        
        $nameLength = strlen($name);
        if ($nameLength <= 1) return $email;
        
        $maskedName = substr($name, 0, 1) . str_repeat('*', $nameLength - 1);
        return $maskedName . '@' . $domain;
    }
} 
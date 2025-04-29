<?php

namespace App\Http\Middleware;

use App\Traits\Notify;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatusApi
{
    use Notify;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ((Auth::user()->sms_verification == 1) && (Auth::user()->email_verification == 1) && (Auth::user()->status == 1) && (Auth::user()->two_fa_verify == 1)) {
            return $next($request);
        } else {
            if (Auth::user()->email_verification == 0) {

                $user->verify_code = code(6);
                $user->sent_at = Carbon::now();
                $user->save();
                $this->verifyToMail($user, 'VERIFICATION_CODE', [
                    'code' => $user->verify_code
                ]);

                $result['status'] = 'failed';
                $result['message'] = 'Email Verification Required';
                return response($result);
            } elseif (Auth::user()->sms_verification == 0) {

                $user->verify_code = code(6);
                $user->sent_at = Carbon::now();
                $user->save();

                $this->verifyToSms($user, 'VERIFICATION_CODE', [
                    'code' => $user->verify_code
                ]);


                $result['status'] = 'failed';
                $result['message'] = 'Mobile Verification Required';
                return response($result);
            } elseif (Auth::user()->status == 0) {
                $result['status'] = 'failed';
                $result['message'] = 'Your account has been suspend';
                return response($result);
            } elseif (Auth::user()->two_fa_verify == 0) {
                $result['status'] = 'failed';
                $result['message'] = 'Two FA Verification Required';
                return response($result);
            }
        }
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Helpers\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FA\Google2FA;

class VerificationController extends Controller
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

    public function checkValidCode($user, $code, $add_min = 10000)
    {
        if (!$code) return false;
        if (!$user->sent_at) return false;
        if (Carbon::parse($user->sent_at)->addMinutes($add_min) < Carbon::now()) return false;
        if ($user->verify_code !== $code) return false;
        return true;
    }

    public function check()
    {
        $user = $this->user;
        $data = getData();
        if (!$user->status) {
            Auth::guard('web')->logout();
        } elseif (!$user->email_verification) {
            if (!$this->checkValidCode($user, $user->verify_code)) {
                $user->verify_code = code(6);
                $user->sent_at = Carbon::now();
                $user->save();
                $this->verifyToMail($user, 'VERIFICATION_CODE', [
                    'code' => $user->verify_code
                ]);
                session()->flash('success', 'Email verification code has been sent');
            }
            $seo = Page::where(['slug' =>  'email-verification','template_name' => getTheme()])->firstOrFail();
            $pageSeo = [
                'page_title' => $seo->page_title,
                'meta_title' => $seo->meta_title,
                'meta_keywords' => implode(',', $seo->meta_keywords ?? []),
                'meta_description' => $seo->meta_description,
                'og_description' => $seo->og_description,
                'meta_robots' => $seo->meta_robots,
                'meta_image' => getFile($seo->meta_image_driver, $seo->meta_image),
                'breadcrumb_image' => $seo->breadcrumb_status ?
                    getFile($seo->breadcrumb_image_driver, $seo->breadcrumb_image) : null,
            ];

            $page_title = 'Email Verification';
            return view(template() . 'auth.verification.email',$data, compact('user', 'page_title','pageSeo'));
        } elseif (!$user->sms_verification) {
            if (!$this->checkValidCode($user, $user->verify_code)) {
                $user->verify_code = code(6);
                $user->sent_at = Carbon::now();
                $user->save();

                $this->verifyToSms($user, 'VERIFICATION_CODE', [
                    'code' => $user->verify_code
                ]);
                session()->flash('success', 'SMS verification code has been sent');
            }
            $seo = Page::where(['slug' =>  'sms-verification','template_name' => getTheme()])->firstOrFail();
            $pageSeo = [
                'page_title' => $seo->page_title,
                'meta_title' => $seo->meta_title,
                'meta_keywords' => implode(',', $seo->meta_keywords ?? []),
                'meta_description' => $seo->meta_description,
                'og_description' => $seo->og_description,
                'meta_robots' => $seo->meta_robots,
                'meta_image' => getFile($seo->meta_image_driver, $seo->meta_image),
                'breadcrumb_image' => $seo->breadcrumb_status ?
                    getFile($seo->breadcrumb_image_driver, $seo->breadcrumb_image) : null,
            ];
            $page_title = 'SMS Verification';
            return view(template() . 'auth.verification.sms',$data, compact('user', 'page_title','pageSeo'));
        } elseif (!$user->two_fa_verify) {

            $seo = Page::where(['slug' =>  'two-fa-verification','template_name' => getTheme()])->firstOrFail();
            $pageSeo = [
                'page_title' => $seo->page_title,
                'meta_title' => $seo->meta_title,
                'meta_keywords' => implode(',', $seo->meta_keywords ?? []),
                'meta_description' => $seo->meta_description,
                'og_description' => $seo->og_description,
                'meta_robots' => $seo->meta_robots,
                'meta_image' => getFile($seo->meta_image_driver, $seo->meta_image),
                'breadcrumb_image' => $seo->breadcrumb_status ?
                    getFile($seo->breadcrumb_image_driver, $seo->breadcrumb_image) : null,
            ];
            $page_title = '2FA Code';
            return view(template() . 'auth.verification.2stepSecurity',$data, compact('user', 'page_title','pageSeo'));

        }
        return redirect()->route('user.dashboard');
    }


    public function resendCode()
    {
        $type = request()->type;
        $user = $this->user;
        if ($this->checkValidCode($user, $user->verify_code, 2)) {
            $target_time = Carbon::parse($user->sent_at)->addMinutes(2)->timestamp;
            $delay = $target_time - time();
            throw ValidationException::withMessages(['resend' => 'Thanks']);
        }
        if (!$this->checkValidCode($user, $user->verify_code)) {
            $user->verify_code = code(6);
            $user->sent_at = Carbon::now();
            $user->save();
        } else {
            $user->sent_at = Carbon::now();
            $user->save();
        }

        if ($type === 'email') {
            $this->verifyToMail($user, 'VERIFICATION_CODE', [
                'code' => $user->verify_code
            ]);
            return back()->with('success', 'Email verification code has been sent.');
        } elseif ($type === 'mobile') {
            $this->verifyToSms($user, 'VERIFICATION_CODE', [
                'code' => $user->verify_code
            ]);
            return back()->with('success', 'SMS verification code has been sent');
        } else {
            throw ValidationException::withMessages(['error' => 'Sending Failed']);
        }
    }

    public function mailVerify(Request $request)
    {
        $rules = [
            'code' => 'required',
        ];
        $msg = [
            'code.required' => 'Email verification code is required',
        ];
        $validate = $this->validate($request, $rules, $msg);
        $user = $this->user;
        if ($this->checkValidCode($user, $request->code)) {
            $user->email_verification = 1;
            $user->verify_code = null;
            $user->sent_at = null;
            $user->save();
            return redirect()->intended(route('user.dashboard'));
        }
        throw ValidationException::withMessages(['error' => 'Verification code didn\'t match!']);
    }

    public function smsVerify(Request $request)
    {
        $rules = [
            'code' => 'required',
        ];
        $msg = [
            'code.required' => 'Email verification code is required',
        ];
        $validate = $this->validate($request, $rules, $msg);
        $user = Auth::user();

        if ($this->checkValidCode($user, $request->code)) {
            $user->sms_verification = 1;
            $user->verify_code = null;
            $user->sent_at = null;
            $user->save();

            return redirect()->intended(route('user.dashboard'));
        }
        throw ValidationException::withMessages(['error' => 'Verification code didn\'t match!']);
    }

    public function twoFAverify(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ], [
            'code.required' => 'Email verification code is required',
        ]);

        $user = Auth::user();
        $secret = auth()->user()->two_fa_code;


        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secret,$request->code);


        if ($valid) {
            $user->two_fa_verify = 1;
            $user->save();
            return redirect()->intended(route('user.home'));
        }
        throw ValidationException::withMessages(['error' => 'Wrong Verification Code']);

    }


}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendResetPasswordMail;
use App\Models\Page;
use App\Models\User;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    use Notify;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {

        $seo = Page::where(['slug' =>  'password-reset','template_name' => getTheme()])->firstOrFail();

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
        $data = getData();


        return view(template().'auth.passwords.email',$data,compact('pageSeo'));
    }

    public function submitForgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        try {
            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            $userEmail = $request->email;
            $user = User::where('email', $userEmail)->first();

            $params = [
                'message' => '<a href="' . url('password/reset', $token) . '?email=' . $userEmail . '" target="_blank">Click To Reset Password</a>'
            ];

            $this->mail($user, 'PASSWORD_RESET_NOTIFICATION', $params);

            return back()->with('success', 'We have e-mailed your password reset link!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}

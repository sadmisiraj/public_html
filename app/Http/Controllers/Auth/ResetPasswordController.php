<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request, $token = null)
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

        return view(template().'auth.passwords.reset',$data,compact('pageSeo'))->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

}

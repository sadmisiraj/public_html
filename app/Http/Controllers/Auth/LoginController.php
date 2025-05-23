<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\UserSystemInfo;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Ranking;
use App\Models\UserLogin;
use App\Providers\RouteServiceProvider;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Facades\App\Services\Google\GoogleRecaptchaService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers , Notify;

    protected $maxAttempts = 3; // Change this to 4 if you want 4 tries
    protected $decayMinutes = 5; // Change this according to your

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->theme = template();
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request)
    {
        $seo = Page::where(['slug' =>  'login','template_name' => getTheme()])->firstOrFail();
        $data = getData();
        $data['pageSeo'] = [
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
        $data['siteKey'] = env('GOOGLE_RECAPTCHA_SITE_KEY');
        return view(template() . 'auth/login', $data);
    }

    protected function validateLogin(Request $request)
    {
        //
    }

    public function username()
    {
        $login = request()->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);
        return $field;
    }

    public function login(Request $request)
    {
        $basicControl = basicControl();
        $rules[$this->username()] = 'required';
        $rules ['password'] = 'required';
        if ($basicControl->manual_recaptcha == 1 && $basicControl->manual_recaptcha_user_login == 1) {
            $rules['captcha'] = ['required',
                Rule::when((!empty($request->captcha) && strcasecmp(session()->get('captcha'), $_POST['captcha']) != 0), ['confirmed']),
            ];
        }

        if ($basicControl->google_reCaptcha_user_login == 1 && $basicControl->google_recaptcha == 1) {
            GoogleRecaptchaService::responseRecaptcha($request['g-recaptcha-response']);
            $rules['g-recaptcha-response'] = 'sometimes|required';
        }

        $message['captcha.confirmed'] = "The captcha does not match.";
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->guard()->validate($this->credentials($request))) {
            if (Auth::attempt([$this->username() => $request->username, 'password' => $request->password])) {
                return $this->sendLoginResponse($request);
            } else {
                return back()->with('error', 'You are banned from this application. Please contact with system Administrator.');
            }
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }


    public function loginModal(Request $request)
    {
        $basicControl = basicControl();
        $rules[$this->username()] = 'required';
        $rules ['password'] = 'required';
        if ($basicControl->manual_recaptcha == 1 && $basicControl->manual_recaptcha_user_login == 1) {
            $rules['captcha'] = ['required',
                Rule::when((!empty($request->captcha) && strcasecmp(session()->get('captcha'), $_POST['captcha']) != 0), ['confirmed']),
            ];
        }

        if ($basicControl->google_reCaptcha_user_login == 1 && $basicControl->google_recaptcha == 1) {
            GoogleRecaptchaService::responseRecaptcha($request['g-recaptcha-response']);
            $rules['g-recaptcha-response'] = 'sometimes|required';
        }

        $message['captcha.confirmed'] = "The captcha does not match.";
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY); // HTTP 422
        }
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if($this->guard()->validate($this->credentials($request))){
            if(Auth::attempt([$this->username() => $request->username, 'password' =>  $request->password, 'status' =>  1])){
                $user = Auth::user();
                $user->last_login = Carbon::now();
                $user->save();
                $request->session()->regenerate();
                return route('user.dashboard');
            }else{
                return response()->json('You are banned from this application. Please contact with system Adminstrator.',401);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }


    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard('admin')->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->last_login = Carbon::now();
        $user->last_seen = Carbon::now();
        $user->two_fa_verify = ($user->two_fa == 1) ? 0 : 1;
        $user->save();



        $interestBalance = (float)$user->total_interest_balance; //5
        $investBalance = (float)$user->total_invest; //50
        $depositBalance = (float)$user->total_deposit; //5.0
        $profitBalance = (float)$user->profit_balance; //5.0
        $teamInvest = teamInvest($user);

        $badges = Ranking::where('min_invest', '<=', $investBalance)
            ->where('min_deposit', '<=', $depositBalance)
            ->where('min_earning', '<=', $interestBalance)
            ->where('status', 1)
            ->get();



        if ($badges) {
            foreach ($badges as $badge) {
                if (($user->total_invest >= $badge->min_invest) && ($user->total_deposit >= $badge->min_deposit) && ($user->total_interest_balance >= $badge->min_earning) && $teamInvest >= $badge->min_team_invest) {
                    $user->last_lavel = $badge->rank_lavel;
                    $user->ranking_id = $badge->id;
                    $user->save();
                    $userBadge = $badge;
                }
            }



            if (isset($userBadge) && ($user->last_lavel == NULL ||  $userBadge->rank_lavel != $user->last_lavel) ) {
                $user->last_lavel = $userBadge->rank_lavel;
                $user->ranking_id = $userBadge->id;
                $user->save();

                $msg = [
                    'user' => $user->fullname,
                    'badge' => $userBadge->rank_lavel,
                ];

                $adminAction = [
                    "name" => $user->firstname . ' ' . $user->lastname,
                    "image" => getFile($user->image_driver, $user->image),
                    "link" => route('admin.users'),
                    "icon" => "fas fa-ticket-alt text-white",
                ];

                $userAction = [
                    "link" => route('user.profile'),
                    "icon" => "fa fa-money-bill-alt text-white"
                ];



                $this->userPushNotification($user, 'BADGE_NOTIFY_TO_USER', $msg, $userAction);
                $this->userFirebasePushNotification($user,'BADGE_NOTIFY_TO_USER', $msg,route('user.profile'));
                $this->sendMailSms($user,'BADGE_MAIL_TO_USER', [
                    'user' => $user->fullname,
                    'badge' => $userBadge->rank_lavel,
                    'date' => Carbon::now()
                ]);

                $this->adminPushNotification('BADGE_NOTIFY_TO_ADMIN', $msg, $adminAction);
                $this->adminFirebasePushNotification( 'BADGE_NOTIFY_TO_ADMIN', $msg,route('admin.users'));
                $this->adminMail('BADGE_MAIL_TO_USER', [
                    'user' => $user->fullname,
                    'badge' => $userBadge->rank_lavel,
                    'date' => Carbon::now()
                ]);
            }

        }

        $info = @json_decode(json_encode(getIpInfo()), true);
        $ul['user_id'] = $user->id;

        $ul['longitude'] = (!empty(@$info['long'])) ? implode(',', $info['long']) : null;
        $ul['latitude'] = (!empty(@$info['lat'])) ? implode(',', $info['lat']) : null;
        $ul['country_code'] = (!empty(@$info['code'])) ? implode(',', $info['code']) : null;
        $ul['location'] = (!empty(@$info['city'])) ? implode(',', $info['city']) . (" - " . @implode(',', @$info['area']) . "- ") . @implode(',', $info['country']) . (" - " . @implode(',', $info['code']) . " ") : null;
        $ul['country'] = (!empty(@$info['country'])) ? @implode(',', @$info['country']) : null;

        $ul['ip_address'] = UserSystemInfo::get_ip();
        $ul['browser'] = UserSystemInfo::get_browsers();
        $ul['os'] = UserSystemInfo::get_os();
        $ul['get_device'] = UserSystemInfo::get_device();
        UserLogin::create($ul);

        $msg = [
            'name' => $user->fullname,
        ];

        $action = [
            "link" => "#",
            "icon" => "fa fa-money-bill-alt text-white"
        ];
        $this->userPushNotification($user, 'LOGIN_NOTIFY_TO_USER', $msg, $action);
        $this->userFirebasePushNotification($user, 'LOGIN_NOTIFY_TO_USER', $msg,'#');

        $this->sendMailSms($user,  'LOGIN_MAIL_TO_USER', [
            'name'          => $user->fullname,
            'last_login_time' => Carbon::now()
        ]);

    }


}

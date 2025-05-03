<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\UserSystemInfo;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use App\Models\UserLogin;
use App\Traits\Notify;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Rules\PhoneLength;
use Facades\App\Services\Google\GoogleRecaptchaService;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers,Notify;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    protected $maxAttempts = 3; // Change this to 4 if you want 4 tries
    protected $decayMinutes = 5; // Change this according to your
    protected $redirectTo = '/user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->theme = template();
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm($sponsor=null, $position=null)
    {
        $basic = basicControl();
        if ($basic->registration == 0) {
            return redirect('/')->with('warning', 'Registration Has Been Disabled.');
        }

        // Store sponsor in session if provided in URL and it exists
        $validSponsor = false;
        $sponsorUser = null;
        $invalidSponsorLink = false;
        $referralNode = null;
        $needPlacementSelection = false;
        
        if ($sponsor != null) {
            $sponsorUser = User::where('username', $sponsor)->first();
            if ($sponsorUser) {
                session()->put('sponsor', $sponsor);
                if ($position && in_array($position, ['left', 'right'])) {
                    session()->put('referral_node', $position);
                    $referralNode = $position;
                } else {
                    // Sponsor is valid but no position specified
                    $needPlacementSelection = true;
                }
                $validSponsor = true;
            } else {
                // If sponsor from URL is invalid, remove it from session
                session()->forget('sponsor');
                session()->forget('referral_node');
                $sponsor = null;
                $referralNode = null;
                $invalidSponsorLink = true;
            }
        }

        $seo = Page::where(['slug' => 'registration','template_name' => getTheme()])->firstOrFail();
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

        return view(template() . 'auth.register', $data, compact('sponsor', 'validSponsor', 'sponsorUser', 'invalidSponsorLink', 'referralNode', 'needPlacementSelection'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $basicControl = basicControl();
        $phoneCode = isset($data['phone_code']) ? $data['phone_code'] : null;
        if ($basicControl->strong_password == 0) {
            $rules['password'] = ['required', 'min:6', 'confirmed'];
        } else {
            $rules['password'] = ["required", 'confirmed',
                Password::min(6)->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()];
        }

        //GoogleRecaptchaService::responseRecaptcha($data['g-recaptcha-response']);
        if ($basicControl->google_recaptcha == 1 && $basicControl->google_recaptcha_user_registration == 1) {
            $rules['g-recaptcha-response'] = ['sometimes', 'required'];
        }

        if ($basicControl->manual_recaptcha == 1 && $basicControl->manual_recaptcha_user_registration == 1) {
            $rules['captcha'] = ['required',
                Rule::when((!empty($data['captcha']) && strcasecmp(session()->get('captcha'), $_POST['captcha']) != 0), ['confirmed']),
            ];
        }

        $rules['email'] = ['required', 'string', 'email', 'max:255',  'unique:users,email'];
        $rules['phone'] = ['required', 'string', 'unique:users,phone', new PhoneLength($phoneCode)];
        $rules['phone_code'] = ['required', 'string', 'max:15'];
        $rules['country'] = ['nullable', 'string', 'max:80'];
        $rules['country_code'] = ['nullable', 'string', 'max:80'];
        $rules['sponsor'] = ['required'];
        
        return Validator::make($data, $rules, [
            'g-recaptcha-response.required' => 'The reCAPTCHA field is required.',
            'sponsor.required' => 'Referral code is required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $basic = basicControl();
        $sponsorId = null;
        
        // Find referrer by username
        $sponsor = User::where('username', $data['sponsor'])->first();
        if ($sponsor) {
            $sponsorId = $sponsor->id;
        }
        
        // Generate a unique username from email
        $emailParts = explode('@', $data['email']);
        $username = strtolower($emailParts[0] . rand(100, 999));
        // Remove spaces and special characters
        $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);
        
        // Check if username already exists and make it unique
        while (User::where('username', $username)->exists()) {
            $username = strtolower($emailParts[0] . rand(100, 9999));
            $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);
        }
        
        // Get referral position (node) from session
        $referralNode = session()->get('referral_node');
        
        return User::create([
            'firstname' => null,
            'lastname' => null,
            'username' => $username,
            'email' => $data['email'],
            'referral_id' => $sponsorId,
            'referral_node' => $referralNode,
            'password' => Hash::make($data['password']),
            'phone_code' => $data['phone_code'],
            'phone' => $data['phone'],
            'country_code' => strtoupper($data['country_code']??''),
            'country' => $data['country']??'',
            'email_verification' => ($basic->email_verification) ? 0 : 1,
            'sms_verification' => ($basic->sms_verification) ? 0 : 1,
        ]);
    }

    public function register(Request $request)
    {


        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $msg = [
            'fullname' => $user->fullname,
        ];
        $action = [
            "link" => route('admin.user.edit', $user->id),
            "icon" => "fas fa-user text-white",
            'image' => getFile($user->image_driver,$user->image),
            'name' => $user->fullname,
        ];
        $userAction = [
            "link" => route('user.profile'),
            "icon" => "fas fa-user text-white"
        ];

        $currentDate = dateTime(Carbon::now());
        $userMsg = [
            'name' => $user->fullname,
            'email' => $user->email,
            'date' => $currentDate,
        ];

        $this->adminPushNotification('REGISTER_NEW_USER_NOTIFY_TO_ADMIN', $msg, $action);
        $this->adminFirebasePushNotification('REGISTER_NEW_USER_NOTIFY_TO_ADMIN', $msg, route('admin.user.edit', $user->id));
        $this->adminMail('REGISTER_NEW_USER_NOTIFY_TO_ADMIN',$msg);

        $this->userPushNotification($user, 'REGISTER_CONFIRMATION', $userMsg, $userAction);
        $this->userFirebasePushNotification($user, 'REGISTER_CONFIRMATION', $userMsg, route('user.profile'));
        $this->sendMailSms($user,'REGISTER_CONFIRMATION',$userMsg);

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        if ($request->ajax()) {
            return route('user.home');
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        $user->last_login = Carbon::now();
        $user->last_seen = Carbon::now();
        $user->two_fa_verify = ($user->two_fa == 1) ? 0 : 1;
        $user->save();

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

    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function checkReferralCode(Request $request)
    {
        $sponsor = $request->sponsor;
        
        $user = User::where('username', $sponsor)->first();
        
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Valid referral code',
                'data' => [
                    'name' => $user->fullname
                ]
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Invalid referral code'
        ]);
    }

}

<!-- MODAL-LOGIN -->
<div id="modal-login">
    <div class="modal-wrapper">
        <div class="modal-login-body">
            <div class="btn-close">&times;</div>
            <div class="form-block">
                <form class="login-form" id="login-form" action="{{route('loginModal')}}" method="post">
                    @csrf
                    <div class="signin">
                        <h3 class="title mb-30">@lang('Login')</h3>

                        <div class="form-group mb-30">
                            <input  autocomplete="off" class="form-control" type="text" name="username" placeholder="@lang('Username')">
                            <span class="text-danger emailError"></span>
                            <span class="text-danger usernameError"></span>
                        </div>

                        <div class="form-group mb-20">
                            <input  autocomplete="off" class="form-control" type="password" name="password" placeholder="@lang('Password')">
                            <span class="text-danger passwordError"></span>
                        </div>

                        @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_login === 1)
                            <div class="mb-4">
                                <input type="text" tabindex="2"
                                       class="form-control form-control-lg @error('captcha') is-invalid @enderror"
                                       name="captcha" id="captcha1" autocomplete="off"
                                       placeholder="Enter Captcha" required>
                                <span class="text-danger captchaError1"></span>
                            </div>

                            <div class="mt-0">
                                <div class="input-group captcha input-group-merge" data-hs-validation-validate-class>
                                    <img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image1'>
                                    <a class="input-group-append input-group-text"
                                       href='javascript: refreshCaptcha1();'>
                                        <i class="fas fa-sync"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if($basicControl->google_recaptcha == 1 && $basicControl->google_reCaptcha_user_login == 1)
                            <div class="row ml-1 mt-4 mb-4">
                                <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                @error('g-recaptcha-response')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <span class="text-danger gCaptchaError1"></span>
                            </div>
                        @endif

                        <div
                            class="remember-me d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-between mb-30">
                            <div class="checkbox custom-control custom-checkbox mt-10">
                                <input  autocomplete="off" id="remember" type="checkbox" class="custom-control-input"
                                        name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">@lang('Remember Me')</label>
                            </div>
                            <a class="btn-forget mt-10" href="javascript:void(0)">@lang("Forgot password?")</a>
                        </div>

                        <div class="btn-area">
                            <button class="btn-login login-auth-btn" type="submit"><span>@lang('Login')</span></button>
                        </div>

                        <div class="login-query mt-30 text-center">
                            <a class="btn-signup" href="javascript:void(0)">@lang("Don't have any account? Sign Up")</a>
                        </div>
                    </div>
                </form>


                <form class="login-form" id="reset-form" method="post" action="{{route('password.email')}}">
                    @csrf
                    <div class="reset-password">
                        <h3 class="title mb-30">@lang("Reset Password")</h3>
                        <div class="form-group mb-30">
                            <input  autocomplete="off" class="form-control" type="email" name="email" value="{{old('email')}}"
                                    placeholder="@lang('Enter your Email Address')">
                            <span class="text-danger emailError"></span>
                        </div>

                        <div class="btn-area">
                            <button class="btn-login login-recover-auth-btn" type="submit">
                                <span>@lang('Send Password Reset Link')</span></button>
                        </div>
                        <div class="login-query mt-30 text-center">
                            <a class="btn-login-back "
                               href="javascript:void(0)">@lang("Already have any account? Login")</a>
                        </div>
                    </div>
                </form>


                <form class="login-form" id="signup-form" action="{{route('register')}}" method="post">
                    @csrf
                    <div class="register">
                        <h3 class="title mb-30">@lang('SIGN UP FORM')</h3>

                        <div class="form-group mb-30">
                            <input  autocomplete="off" class="form-control" type="text" name="first_name" value="{{old('first_name')}}"
                                    placeholder="@lang('First Name')">
                            <span class="text-danger firstnameError"></span>
                        </div>

                        <div class="form-group mb-30">
                            <input  autocomplete="off" class="form-control " type="text" name="last_name" value="{{old('last_name')}}"
                                    placeholder="@lang('Last Name')">
                            <span class="text-danger lastnameError"></span>
                        </div>

                        <div class="form-group mb-30">
                            <input  autocomplete="off" class="form-control " type="text" name="username" value="{{old('username')}}"
                                    placeholder="@lang('Username')">
                            <span class="text-danger usernameError"></span>
                        </div>

                        <div class="form-group mb-30">
                            <input  autocomplete="off" class="form-control" type="text" name="email" value="{{old('email')}}"
                                    placeholder="@lang('Email Address')">
                            <span class="text-danger emailError"></span>
                        </div>


                        <div class="form-group mb-30">
                            @php
                                $country_code = (string) @getIpInfo()['code'] ?: null;
                                $myCollection = collect(config('country'))->map(function($row) {
                                    return collect($row);
                                });
                                $countries = $myCollection->sortBy('code');
                            @endphp


                            <div class="input-group ">
                                <div class="input-group-prepend w-50">
                                    <select name="phone_code" class="form-control country_code dialCode-change">
                                        @foreach($countries as $value)
                                            <option value="{{$value['phone_code']}}"
                                                    data-name="{{$value['name']}}"
                                                    data-code="{{$value['code']}}"
                                                {{$country_code == $value['code'] ? 'selected' : ''}}
                                            > {{$value['name']}} ({{$value['phone_code']}})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input  autocomplete="off" type="text" name="phone" class="form-control dialcode-set" value="{{old('phone')}}"
                                        placeholder="@lang('Your Phone Number')">
                            </div>

                            <span class="text-danger phoneError"></span>

                            <input  autocomplete="off" type="hidden" name="country_code" value="{{old('country_code')}}" class="text-dark">
                        </div>


                        <div class="form-group mb-30">
                            <input  autocomplete="off" class="form-control" type="password" name="password" value="{{old('password')}}"
                                    placeholder="@lang('Password')">
                            <span class="text-danger passwordError"></span>
                        </div>

                        <div class="form-group mb-30">
                            <input  autocomplete="off" class="form-control" type="password" name="password_confirmation"
                                    placeholder="@lang('Confirm Password')">
                        </div>

                        @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_registration === 1)
                            <div class="form-group mb-30">
                                <input type="text" tabindex="2"
                                       class="form-control form-control-lg @error('captcha') is-invalid @enderror"
                                       name="captcha" id="captcha" autocomplete="off"
                                       placeholder="Enter Captcha" required>

                                <span class="text-danger captchaError"></span>
                            </div>

                            <div class="form-group mb-30 ps-3 pe-3 mt-0">
                                <div class="input-group captcha input-group-merge" data-hs-validation-validate-class>
                                    <img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image2'>
                                    <a class="input-group-append input-group-text"
                                       href='javascript: refreshCaptcha2();'>
                                        <i class="fas fa-sync"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if($basicControl->google_recaptcha == 1 && $basicControl->google_recaptcha_user_registration == 1)
                            <div class="row ml-2 mt-2 mb-4">
                                <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                <span class="text-danger gCaptchaError"></span>
                            </div>
                        @endif

                        <div class="btn-area">
                            <button class="btn-login login-signup-auth-btn" type="submit"><span>@lang('Sign Up')</span>
                            </button>
                        </div>
                        <div class="login-query mt-30 text-center">
                            <a class="btn-login-back"
                               href="javascript:void(0)">@lang("Already have an account? Login")</a>
                        </div>
                    </div>

                </form>
            </div>

            <div class="connectivity wow fadeIn" data-wow-duration="1s" data-wow-delay="0.35s">

            </div>
        </div>
    </div>
</div>


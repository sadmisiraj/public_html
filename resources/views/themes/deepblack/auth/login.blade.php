@extends(template().'layouts.app')
@section('title',__('Login'))

@section('content')

    <!-- login -->
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="login-box">
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="box mb-4">
                                <h4 class="golden-text">@lang('your email or username')</h4>
                                <div class="input-group">
                                    <div class="img">
                                        <img src="{{asset(template(true).'img/icon/email2.png')}}" alt="@lang('email img')" />
                                    </div>
                                    <input
                                        type="text"
                                        name="username"
                                        value="{{old('username',request()->username)}}"
                                        class="form-control"
                                        placeholder="@lang('Email Or Username')"
                                    />
                                </div>
                                @error('username')<span class="text-danger float-left">@lang($message)</span>@enderror
                                @error('email')<span class="text-danger float-left">@lang($message)</span>@enderror
                            </div>

                            <div class="box mb-4">
                                <h4 class="golden-text">@lang('Your Password')</h4>
                                <div class="input-group">
                                    <div class="img">
                                        <img src="{{asset(template(true).'img/icon/padlock.png')}}" alt="@lang('password img')" />
                                    </div>
                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        value="{{old('password',request()->password)}}"
                                        placeholder="@lang('Password')"
                                    />
                                </div>
                                @error('password')
                                <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_login === 1)
                                <div class="box mb-4">
                                    <h4 class="golden-text">@lang('Captcha')</h4>
                                   <div class="input-group">
                                       <div class="img">
                                           <img src="{{asset(template(true).'img/icon/chevron.png')}}" alt="@lang('password img')" />
                                       </div>
                                       <input type="text"
                                              class="form-control @error('captcha') is-invalid @enderror"
                                              name="captcha" id="captcha" autocomplete="off"
                                              placeholder="Enter Captcha" required>
                                   </div>
                                    @error('captcha')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group captcha input-group-merge" data-hs-validation-validate-class>
                                    <img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image'>
                                    <a class="input-group-append input-group-text manual-recaptcha-icon"
                                       href='javascript: refreshCaptcha();'>
                                        <i class="fa-thin fa-rotate-right"></i>
                                    </a>
                                </div>
                            @endif
                            @if($basicControl->google_recaptcha == 1 && $basicControl->google_reCaptcha_user_login == 1)
                                <div class="row mt-4 mb-4">
                                    <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                    @error('g-recaptcha-response')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                            <div class="row mt-4 mb-4">
                                <h4 class="golden-text">
                                    <a href="{{ route('password.request') }}" class="golden-text"
                                    >@lang('Forget password?')</a>
                                </h4>
                            </div>

                            <div class="mb-4 bottom">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="remember"
                                        {{ old('remember') ? 'checked' : '' }}
                                        id="flexCheckDefault"
                                    />
                                    <label
                                        class="form-check-label"
                                        for="flexCheckDefault"
                                    >
                                        @lang('Remember me')
                                    </label>
                                </div>
                                <span class="text-end">
                                <p>
                                @lang('New User?')
                                <a href="{{ route('register') }}" class="golden-text">@lang('Register')</a>
                                </p>
                            </span>
                            </div>
                            <button class="gold-btn-block" type="submit">@lang('Sign in')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js-lib')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush

@push('script')
    <script>
        'use strict';
        function refreshCaptcha(){
            let img = document.images['captcha_image'];
            img.src = img.src.substring(
                0,img.src.lastIndexOf("?")
            )+"?rand="+Math.random()*1000;
        }
    </script>
@endpush


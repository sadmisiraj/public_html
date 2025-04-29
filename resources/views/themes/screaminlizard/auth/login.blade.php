@extends(template().'layouts.app')
@section('title',__('Login'))

@section('content')

    <!-- login section -->
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center align-items-end">
                <div class="col-lg-5 col-md-8">
                    <div class="form-wrapper">
                        <div class="form-box">
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-12">
                                        <h4>@lang('Login To Your Account')</h4>
                                    </div>
                                    <div class="input-box col-12">
                                        <input type="text" name="username" value="{{old('username',request()->username)}}"   class="form-control" placeholder="@lang('Email Or Username')" autocomplete="off"/>
                                        @error('username')<span class="text-danger float-left">@lang($message)</span>@enderror
                                        @error('email')<span class="text-danger float-left">@lang($message)</span>@enderror
                                    </div>
                                    <div class="input-box col-12">
                                        <input type="password" name="password"  value="{{old('password',request()->password)}}" class="form-control" placeholder="@lang('Password')" autocomplete="off"/>
                                        @error('password')
                                        <span class="text-danger mt-1">@lang($message)</span>
                                        @enderror
                                    </div>

                                    @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_login === 1)
                                        <div class="input-box col-12">
                                            <input type="text" tabindex="2"
                                                   class="form-control form-control-lg @error('captcha') is-invalid @enderror"
                                                   name="captcha" id="captcha" autocomplete="off"
                                                   placeholder="Enter Captcha" required>
                                            @error('captcha')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="input-box col-12">
                                            <div class="input-group captcha input-group-merge" data-hs-validation-validate-class>
                                                <img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image'>
                                                <a class="input-group-append input-group-text"
                                                   href='javascript: refreshCaptcha();'>
                                                    <i class="fal fa-sync"></i>
                                                </a>
                                            </div>
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

                                    <div class="col-12">
                                        <div class="links">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="remember"
                                                       {{ old('remember') ? 'checked' : '' }}
                                                       id="flexCheckDefault" />
                                                <label class="form-check-label" for="flexCheckDefault"> @lang('Remember me') </label>
                                            </div>
                                            <a href="{{ route('password.request') }}">@lang('Forgot password?')</a>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn-custom w-100">@lang('sign in')</button>
                                <div class="bottom">
                                    @lang(" Don't have an account?")
                                    <a href="{{ route('register') }}">@lang('Create account')</a>
                                </div>
                            </form>
                        </div>
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

@push('style')
    <style>
        .captcha{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 0;
        }

        .captcha img{
            width: 120px;
            padding: 10px;
        }

        .captcha .input-group-append{
            width: 55px;
            height: 59px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: transparent;
            color: #FFFFFF;
        }

        .captcha .input-group-append i{
            position: absolute;
            top: 18px;
            right: 21px;
        }
    </style>
@endpush


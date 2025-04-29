@extends(template().'layouts.app')
@section('title',trans('Login'))
@section('content')



    <!-- login section -->
    <section class="login-section">
        <div class="container">
            <div class="login-wrapper">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6">
                        <div class="form-wrapper">
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-12">
                                        <h4>@lang('Login To Your Account')</h4>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" name="username" value="{{old('username',request()->username)}}" class="form-control"  placeholder="@lang('Email Or Username')" autocomplete="off" required/>
                                        <label for="floatingInput">@lang('Email Address')</label>
                                        @error('username')<span class="text-danger float-left">@lang($message)</span>@enderror
                                        @error('email')<span class="text-danger float-left">@lang($message)</span>@enderror
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" name="password" value="{{old('password',request()->password)}}" class="form-control" id="id_password"  placeholder="@lang('Password')" autocomplete="off" required/>
                                        <label for="id_password">@lang('Password')</label>
                                        @error('password')
                                        <span class="text-danger mt-1">@lang($message)</span>
                                        @enderror
                                    </div>
                                    @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_login === 1)
                                        <div class="mb-4">
                                            <input type="text" tabindex="2"
                                                   class="form-control form-control-lg @error('captcha') is-invalid @enderror"
                                                   name="captcha" id="captcha" autocomplete="off"
                                                   placeholder="@lang('Enter Captcha')" required>
                                            @error('captcha')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="ps-3 pe-3 mt-0">
                                            <div class="input-group captcha input-group-merge" data-hs-validation-validate-class>
                                                <img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image'>
                                                <a class="input-group-append input-group-text"
                                                   href='javascript: refreshCaptcha();'>
                                                    <i class="fa-light fa-rotate-right"></i>
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
                                            <a href="{{ route('password.request') }}">@lang('Forgot password')?</a>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn-custom w-100">@lang('sign in')</button>
                                <div class="bottom">
                                    @lang("Don't have an account?")
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


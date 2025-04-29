@extends(template().'layouts.app')
@section('title',__('Login'))


@section('content')
    <section id="about-us" class="about-page secbg-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-block py-5">
                        <form class="login-form" action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="signin">
                                <h3 class="title mb-30">@lang('Login Form')</h3>

                                <div class="form-group mb-30">
                                    <input class="form-control" value="{{old('username',request()->username)}}"  type="text" name="username"  placeholder="@lang('Email Or Username')">
                                    @error('username')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                    @error('email')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                </div>

                                <div class="form-group mb-20">
                                    <input class="form-control" type="password" value="{{old('password',request()->password)}}" name="password"  placeholder="@lang('Password')">
                                    @error('password')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_login === 1)
                                    <div class="mb-4">
                                        <input type="text" tabindex="2"
                                               class="form-control form-control-lg @error('captcha') is-invalid @enderror"
                                               name="captcha" id="captcha" autocomplete="off"
                                               placeholder="Enter Captcha" required>
                                        @error('captcha')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mt-0">
                                        <div class="input-group captcha input-group-merge" data-hs-validation-validate-class>
                                            <img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image'>
                                            <a class="input-group-append input-group-text"
                                               href='javascript: refreshCaptcha();'>
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
                                    </div>
                                @endif

                                <div
                                    class="remember-me d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-between mb-30">
                                    <div class="checkbox custom-control custom-checkbox mt-10">
                                        <input id="remember" type="checkbox" class="custom-control-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="remember">@lang('Remember Me')</label>
                                    </div>
                                    <a class="text-white mt-10"  href="{{ route('password.request') }}">@lang("Forgot password?")</a>
                                </div>

                                <div class="btn-area">
                                    <button class="btn-login login-auth-btn" type="submit"><span>@lang('Login')</span></button>
                                </div>

                                <div class="login-query mt-30 text-center">
                                    <a  href="{{ route('register') }}">@lang("Don't have any account? Sign Up")</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="connectivity wow fadeIn" data-wow-duration="1s" data-wow-delay="0.35s">
                        <div class="d-flex align-items-center justify-content-center">
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

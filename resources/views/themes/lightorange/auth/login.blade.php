@extends(template().'layouts.app')
@section('title',__('Login'))


@section('content')
    <!-- login start -->
    <section id="login-section">
        <img class="img img-4 zoomInOutInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-4.png')}}" alt="@lang('ellipse-4-image')">
        <img class="img img-3 zoomInOut2sInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-3.png')}}" alt="@lang('ellipse-5-image')">
        <img class="img img-6 zoomInOut2sInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-6.png')}}" alt="@lang('ellipse-6-image')">
        <img class="img img-7 zoomInOutInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-7.png')}}" alt="@lang('ellipse-7-image')">

        <div class="overlay pt-150 pb-150">
            <div class="container">
                <div class="row d-flex justify-content-center ">
                    <div class="col-lg-6">
                        <div class="card-area">
                            <h2 class="mb-30 color-one font-weight-bolder">@lang('Sign Your Account')</h2>
                            <form class="login-form wow fadeInUp" action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-30">
                                            <input type="text" class="username" value="{{old('username',request()->username)}}" name="username"  placeholder="@lang('Email Or Username')">
                                            @error('username')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                            @error('email')<span class="text-danger mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-30">
                                            <input type="password" name="password" value="{{old('password',request()->password)}}" placeholder="@lang('Password')">
                                            @error('password')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_login === 1)
                                        <div class="col-lg-12">
                                           <div class="form-group mb-30">
                                               <input type="text" tabindex="2"
                                                      name="captcha" id="captcha" autocomplete="off"
                                                      placeholder="Enter Captcha" required>
                                               @error('captcha')
                                               <span class="invalid-feedback">{{ $message }}</span>
                                               @enderror
                                           </div>
                                        </div>

                                        <div class="col-lg-12">
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
                                        <div class="col-lg-12 mt-4 mb-4">
                                            <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                            @error('g-recaptcha-response')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                    <div class="col-lg-12">
                                        <div class="form-group d-flex justify-content-between d-none">
                                            <div class="input-checkbox d-flex justify-content-between">
                                                <label class="box-area">@lang('Remember me')
                                                    <input id="remember" type="checkbox" class="custom-control-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="forgot-area">
                                                <a class="forgot" href="{{ route('password.request') }}">@lang("Forgot password?")</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group d-flex justify-content-between d-none" >
                                            <div class="forgot-area">
                                                <a class="forgot" href="{{ route('register') }}">@lang("Don’t have an account? Register")</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 btn-area">
                                        <button type="submit" class="cmn-btn">@lang('Login')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login end -->
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

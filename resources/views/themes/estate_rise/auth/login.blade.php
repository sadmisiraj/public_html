@extends(template().'layouts.app')
@section('title',trans('Login'))
@section('content')
    <!-- login-signup section start -->
    <section class="login-signup-page">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 col-lg-12 col-md-10 mx-auto">
                    <div class="login-signup-box">
                        <div class="row g-0 justify-content-center">
                            <div class="col-lg-6">
                                <div class="login-signup-form">
                                    <form action="{{ route('login') }}" method="post">
                                        @csrf
                                        <div class="section-header">
                                            <h3>{!! $login_registration['single']['login_title'] !!}</h3>
                                            <div class="description">
                                                {!! $login_registration['single']['login_sub_title'] !!}
                                            </div>
                                        </div>

                                        <div class="row g-4">
                                            <div class="col-12">
                                                <input type="text" name="username" value="{{old('username',request()->username)}}" class="form-control" id="exampleInputEmail1"
                                                       placeholder="@lang('UserID or Email')">
                                                @error('username')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="password-box">
                                                    <input type="password" value="{{old('password',request()->password)}}" name="password" class="form-control password"
                                                           id="exampleInputPassword1" placeholder="@lang('Password')">
                                                    <i class="password-icon fa-regular fa-eye"></i>
                                                </div>
                                                @error('password')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_login === 1)
                                                <div class="col-12">
                                                    <input type="text" tabindex="2"
                                                           class="form-control  @error('captcha') is-invalid @enderror"
                                                           name="captcha" id="captcha" autocomplete="off"
                                                           placeholder="@lang('Enter Captcha')" required>
                                                    @error('captcha')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-12">
                                                    <div class="input-group captcha input-group-merge" data-hs-validation-validate-class>
                                                        <img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image'>
                                                        <a class="input-group-append input-group-text"
                                                           href='javascript: refreshCaptcha();'>
                                                            <i class="fal fa-undo"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($basicControl->google_recaptcha == 1 && $basicControl->google_reCaptcha_user_login == 1)
                                                <div class="col-12">
                                                    <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                                    @error('g-recaptcha-response')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            @endif
                                            <div class="col-12">
                                                <div class="form-check d-flex justify-content-between flex-wrap gap-2">
                                                    <div class="check">
                                                        <input type="checkbox" class="form-check-input"
                                                               id="exampleCheck1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="exampleCheck1">
                                                            @lang('Remember me')
                                                        </label>
                                                    </div>
                                                    <div class="forgot highlight">
                                                        <a href="{{ route('password.request') }}">@lang('Forgot password')?</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="cmn-btn mt-30 w-100"><span>@lang('Log In')</span></button>

                                       
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="img-box">
                                    <img src="{{ isset($login_registration['single']['media']->image)?getFile($login_registration['single']['media']->image->driver,$login_registration['single']['media']->image->path):'' }}" alt="login page image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- login-signup section end -->
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

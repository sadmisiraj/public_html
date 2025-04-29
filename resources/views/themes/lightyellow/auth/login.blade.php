@extends(template().'layouts.app')
@section('title',__('Login'))

@section('content')

    <!-- login_area_start -->
    <section class="contact_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 col-md-6 ms-auto order-2 order-md-1">
                    <div class="form_area p-4 shadow1 ">
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="form_title pb-2">
                                <h3>{!! $login_registration['single']['login_title'] !!}</h3>
                            </div>
                            <div class="mb-4">
                                <input
                                    type="text"
                                    name="username"
                                    value="{{old('username',request()->username)}}"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="@lang('Username or Email')">
                                @error('username')<span class="text-danger float-left">@lang($message)</span>@enderror
                                @error('email')<span class="text-danger float-left">@lang($message)</span>@enderror
                            </div>


                            <div class="mb-3">
                                <input type="password" name="password"  value="{{old('password',request()->password)}}"  class="form-control" id="exampleInputPassword1"
                                       placeholder="@lang('Password')">
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

                                <div class="mt-0">
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
                                <div class="row mt-4 mb-4">
                                    <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                    @error('g-recaptcha-response')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <div class="mb-3 form-check d-flex justify-content-between">
                                <div class="check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">@lang('Remember me')</label>
                                </div>
                                <div class="forgot">
                                    <a href="{{ route('password.request') }}">@lang('Forgot password?')</a>

                                </div>
                            </div>
                            <button type="submit" class="btn custom_btn mt-30">@lang('Log In')</button>
                            <div class="pt-5 d-flex">
                                @lang("Don't have an account?")
                                <br>
                                <h6 class="ms-2"><a href="{{ route('register') }}">@lang('Register')</a></h6>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 order-1 order-md-2">
                    <div class="image_area">
                        <img src="{{ isset($login_registration['single']['media']->image)?getFile($login_registration['single']['media']->image->driver,$login_registration['single']['media']->image->path):'' }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login_area_end -->
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


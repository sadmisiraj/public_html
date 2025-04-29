@extends(template().'layouts.app')
@section('title',__('Login'))

@section('content')

    <!-- login section -->
    <section class="login-section">
        <div class="container h-100">
            <div class="row h-100 justify-content-center">
                <div class="col-lg-6">
                    <div class="form-wrapper d-flex align-items-center h-100">
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <h4>@lang('Login here')</h4>
                                </div>
                                <div class="input-box col-12">
                                    <input type="text"
                                           name="username"
                                           value="{{old('username',request()->username)}}" 
                                           class="form-control"
                                           id="exampleInputEmail1"
                                           aria-describedby="emailHelp" placeholder="@lang('Username or Email')" />
                                    @error('username')<span class="text-danger float-left">@lang($message)</span>@enderror
                                    @error('email')<span class="text-danger float-left">@lang($message)</span>@enderror
                                </div>
                                <div class="input-box col-12">
                                    <input type="password" name="password" value="{{old('password',request()->password)}}"   class="form-control" id="exampleInputPassword1"
                                           placeholder="@lang('Password')" />
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

                                    <div class="ps-3 pe-3 mt-4">
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
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember" {{ old('remember') ? 'checked' : '' }} />
                                            <label class="form-check-label" for="flexCheckDefault"> @lang('Remember me') </label>
                                        </div>
                                        <a href="{{ route('password.request') }}">@lang('Forgot password?')</a>
                                    </div>
                                </div>
                            </div>

                            <button class="btn-custom">@lang('Log In')</button>
                            <div class="bottom">
                                @lang("Don't have an account?")

                                <a href="{{ route('register') }}">@lang('Create account')</a>
                            </div>
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


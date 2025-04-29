@extends(template().'layouts.app')
@section('title',__('Register'))
@section('content')
    <!-- login-signup section start -->
    <section class="login-signup-page">
        <div class="container">
            <div class="row">
                <div class="col-xxl-10 col-lg-12 col-md-10 mx-auto">
                    <div class="login-signup-box">
                        <div class="row g-0 justify-content-center">
                            <div class="col-xl-6 col-lg-7">
                                <div class="login-signup-form">
                                    <form action="{{ route('register') }}" method="post">
                                        @csrf
                                        <div class="section-header">
                                            <h3>{!! $login_registration['single']['registration_title'] !!}</h3>
                                            <div class="description">
                                                {!! $login_registration['single']['registration_sub_title'] !!}
                                            </div>
                                        </div>

                                        <div class="row g-4">
                                            @if(session()->get('sponsor') != null)
                                                <div class="col-md-12">
                                                    <input type="text" name="sponsor" class="form-control" id="sponsor"
                                                           placeholder="{{trans('Sponsor By') }}" value="{{session()->get('sponsor')}}" readonly autocomplete="off">
                                                    @error('sponsor')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                                </div>
                                            @endif
                                            <div class="col-md-6">
                                                <input type="text" name="first_name" class="form-control" id="exampleInputEmail0"
                                                       placeholder="@lang('First Name')">
                                                @error('first_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="last_name" class="form-control" id="exampleInputEmail0"
                                                       placeholder="@lang('Last Name')">
                                                @error('last_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="username" class="form-control" id="exampleInputEmail3"
                                                       placeholder="@lang('User Name')">
                                                @error('username')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="email" name="email" class="form-control" id="exampleInputEmail4"
                                                       placeholder="@lang('Email')">
                                                @error('email')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                @php
                                                    $country_code = (string) @getIpInfo()['code'] ?: null;
                                                    $myCollection = collect(config('country'))->map(function($row) {
                                                        return collect($row);
                                                    });
                                                    $countries = $myCollection->sortBy('code');
                                                @endphp
                                                <select name="phone_code" class="form-control country_code dialCode-change">
                                                    @foreach(config('country') as $value)
                                                        <option value="{{$value['phone_code']}}"
                                                                data-name="{{$value['name']}}"
                                                                data-code="{{$value['code']}}"
                                                            {{$country_code == $value['code'] ? 'selected' : ''}}
                                                        > {{$value['name']}} ({{$value['phone_code']}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="telephone" class="form-control" name="phone" type="text" placeholder="@lang('Phone Number')">
                                                @error('phone')
                                                <span class="text-danger mt-1">@lang($message)</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="password-box">
                                                    <input type="password" name="password" class="form-control password"
                                                           id="exampleInputPassword1" placeholder="@lang('Password')">
                                                    <i class="password-icon fa-regular fa-eye"></i>
                                                </div>
                                                @error('password')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="password-box">
                                                    <input type="password" name="password_confirmation" class="form-control password"
                                                           id="exampleInputPassword2" placeholder="@lang('Confirm Password')">
                                                    <i class="password-icon fa-regular fa-eye"></i>
                                                </div>
                                            </div>
                                            @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_registration === 1)
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
                                            @if($basicControl->google_recaptcha == 1 && $basicControl->google_recaptcha_user_registration == 1)
                                                <div class="col-12">
                                                    <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                                    @error('g-recaptcha-response')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>
                                        <button type="submit" class="cmn-btn mt-30 w-100"><span>@lang('signup')</span></button>
                                        <div class="pt-20 text-center">
                                            @lang('Already have an account')?
                                            <p class="mb-0 highlight mt-1"><a href="{{route('login')}}">@lang('Login Here')</a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-5 d-none d-lg-block">
                                <div class="img-box">
                                    <img src="{{ isset($login_registration['single']['media']->image)?getFile($login_registration['single']['media']->image->driver,$login_registration['single']['media']->image->path):'' }}" alt="registration image">
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

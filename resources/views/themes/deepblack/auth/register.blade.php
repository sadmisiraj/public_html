@extends(template().'layouts.app')
@section('title',__('Register'))


@section('content')
    <!-- register start -->
    <section class="login-section register-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="login-box">
                        <form action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="row">
                                @if(session()->get('sponsor') != null)
                                    <div class="col-md-12">
                                        <div class="box sponsorboxwidth">
                                            <h4 class="golden-text">@lang('Sponsor Name')</h4>
                                            <div class="input-group mb-4">
                                                <div class="img">
                                                    <img src="{{asset(template(true).'img/icon/bonus.png')}}" alt="@lang('sponsor img')" />
                                                </div>
                                                <input type="text" name="sponsor" id="sponsor" class="form-control" placeholder="{{trans('Sponsor By') }}" value="{{session()->get('sponsor')}}" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="box mb-4">
                                        <h4 class="golden-text">@lang('First Name')</h4>
                                        <div class="input-group">
                                            <div class="img">
                                                <img src="{{asset(template(true).'img/icon/edit.png')}}" alt="@lang('first name img')" />
                                            </div>
                                            <input type="text" name="first_name" class="form-control" value="{{old('firstname')}}" placeholder="@lang('First Name')"/>
                                        </div>
                                        @error('first_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box mb-4">
                                        <h4 class="golden-text">@lang('Last Name')</h4>
                                        <div class="input-group">
                                            <div class="img">
                                                <img src="{{asset(template(true).'img/icon/edit.png')}}" alt="@lang('lastname img')" />
                                            </div>
                                            <input type="text" name="last_name" class="form-control" value="{{old('lastname')}}" placeholder="@lang('Last Name')"/>
                                        </div>
                                        @error('last_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box mb-4">
                                        <h4 class="golden-text">@lang('Username')</h4>
                                        <div class="input-group">
                                            <div class="img">
                                                <img src="{{asset(template(true).'img/icon/edit.png')}}" alt="@lang('username img')" />
                                            </div>
                                            <input type="text" name="username" class="form-control" value="{{old('username')}}" placeholder="@lang('Username')"/>
                                        </div>
                                        @error('username')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box mb-4">
                                        <h4 class="golden-text">@lang('Email Address')</h4>
                                        <div class="input-group">
                                            <div class="img">
                                                <img src="{{asset(template(true).'img/icon/email2.png')}}" alt="@lang('email img')" />
                                            </div>
                                            <input type="text" name="email" class="form-control" value="{{old('email')}}" placeholder="@lang('Email Address')"/>
                                        </div>
                                        @error('email')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                    </div>
                                </div>

                                <div class="col-md-12 phonenumber">
                                    <h4 class="golden-text">@lang('Phone Number')</h4>
                                    <div class="box mb-4">
                                        <input type="hidden" name="phone_code" id="phoneCode" >
                                        <input type="hidden" name="country_code" id="countryCode" >
                                        <input type="hidden" name="country" id="countryName" >
                                        <input type="tel" id="telephone" name="phone" value="{{old('phone')}}"  class="form-control">
                                    </div>
                                    @error('phone')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="box mb-4">
                                        <h4 class="golden-text">@lang('Password')</h4>
                                        <div class="input-group">
                                            <div class="img">
                                                <img src="{{asset(template(true).'img/icon/padlock.png')}}" alt="@lang('password img')" />
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="@lang('Password')"/>
                                        </div>
                                        @error('password')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box mb-4">
                                        <h4 class="golden-text">@lang('Confirm Password')</h4>
                                        <div class="input-group">
                                            <div class="img">
                                                <img src="{{asset(template(true).'img/icon/padlock.png')}}" alt="@lang('Confirm Password img')" />
                                            </div>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Confirm Password')"/>
                                        </div>
                                    </div>
                                </div>

                                    @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_registration === 1)
                                        <div class="col-md-6">
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
                                        </div>

                                        <div class="col-md-6">
                                            <h4 class="golden-text">@lang('Captcha Image')</h4>
                                            <div class="input-group captcha input-group-merge" data-hs-validation-validate-class>
                                                <img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image'>
                                                <a class="input-group-append input-group-text manual-recaptcha-icon"
                                                   href='javascript: refreshCaptcha();'>
                                                    <i class="fa-thin fa-rotate-right"></i>
                                                </a>
                                            </div>
                                        </div>

                                    @endif
                                    @if($basicControl->google_recaptcha == 1 && $basicControl->google_recaptcha_user_registration == 1)
                                        <div class="row mt-4 mb-4">
                                            <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                            @error('g-recaptcha-response')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif

                                <div class="mb-4 col-md-12 logindiv">
                                    <p>
                                        @lang('already User?')
                                        <a href="{{ route('login') }}" class="golden-text">@lang('login')</a>
                                    </p>
                                    <button type="submit" class="gold-btn">@lang('Sign Up')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- register end -->
@endsection


@push('css-lib')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/css/intlTelInput.css">
@endpush

@push('js-lib')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/intlTelInput.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush

@push('script')
    <script>
        'use strict';

        $(document).ready(function (){

            // International Telephone Input start
            const input = document.querySelector("#telephone");
            const iti = window.intlTelInput(input, {
                initialCountry: "bd",
                separateDialCode: true,
            });
            input.addEventListener("countrychange", updateCountryInfo);
            updateCountryInfo();
            function updateCountryInfo() {
                const selectedCountryData = iti.getSelectedCountryData();
                const phoneCode = '+' + selectedCountryData.dialCode;
                const countryCode = selectedCountryData.iso2;
                const countryName = selectedCountryData.name;
                $('#phoneCode').val(phoneCode);
                $('#countryCode').val(countryCode);
                $('#countryName').val(countryName);
            }

            const initialPhone = "{{$user->phone??null}}";
            const initialPhoneCode = "{{$user->phone_code??null}}";
            const initialCountryCode = "{{$user->country_code??null}}";
            const initialCountry = "{{$user->country??null}}";
            if (initialPhoneCode) {
                iti.setNumber(initialPhoneCode);
            }
            if (initialCountryCode) {
                iti.setNumber(initialCountryCode);
            }
            if (initialCountry) {
                iti.setNumber(initialCountry);
            }
            if (initialPhone) {
                iti.setNumber(initialPhone);
            }
        })
        function refreshCaptcha(){
            let img = document.images['captcha_image'];
            img.src = img.src.substring(
                0,img.src.lastIndexOf("?")
            )+"?rand="+Math.random()*1000;
        }
    </script>
@endpush

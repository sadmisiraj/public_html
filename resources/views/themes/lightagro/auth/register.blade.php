@extends(template().'layouts.app')
@section('title',__('Register'))
@section('content')

    <!-- login section -->
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7">
                    <div class="register-form-wrapper">
                        <form action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <h4>@lang('Create An Account')</h4>
                                </div>

                                @if(session()->get('sponsor') != null)
                                    <div class="col-md-12 form-floating">
                                        <input type="text" name="sponsor" id="sponsor" class="form-control" placeholder="{{trans('Sponsor By') }}" value="{{session()->get('sponsor')}}" readonly autocomplete="off"/>
                                        <label for="fname">@lang('Sponsor')</label>
                                    </div>
                                @endif

                                <div class="col-md-6 form-floating">
                                    <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}" placeholder="@lang('First Name')" autocomplete="off"/>
                                    <label for="lname">@lang('First Name')</label>
                                    @error('first_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                </div>

                                <div class="col-md-6 form-floating">
                                    <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}" placeholder="@lang('Last Name')" autocomplete="off"/>
                                    <label for="lname">@lang('Last Name')</label>
                                    @error('last_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                </div>


                                <div class="col-md-12 form-floating">
                                    <label for="organization" class="form-label">@lang('Phone Number')</label>
                                    <div class="phone-input">
                                        <input type="hidden" name="phone_code" id="phoneCode" >
                                        <input type="hidden" name="country_code" id="countryCode" >
                                        <input type="hidden" name="country" id="countryName" >
                                        <input type="tel" id="telephone" name="phone" value="{{old('phone')}}"  class="sign-in-input">
                                    </div>
                                    @error('phone')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-floating">
                                    <input type="text" name="username" class="form-control" value="{{old('username')}}" placeholder="@lang('Username')" autocomplete="off"/>
                                    <label for="username">@lang('Username')</label>
                                    @error('username')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                </div>


                                <div class="col-md-6 form-floating">
                                    <input type="text" name="email" class="form-control" value="{{old('email')}}" placeholder="@lang('Email Address')" autocomplete="off"/>
                                    <label for="email">@lang('Email Address')</label>
                                    @error('email')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                </div>

                                <div class="col-md-6 form-floating">
                                    <input type="password" name="password" id="id_password" class="form-control" placeholder="@lang('Password')"/>
                                    <label for="id_password">@lang('Password')</label>
                                    @error('password')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                </div>

                                <div class="col-md-6 form-floating">
                                    <input type="password" name="password_confirmation" id="id_password" class="form-control" placeholder="@lang('Confirm Password')"/>
                                    <label for="id_password">@lang('Confirm Password')</label>
                                </div>

                                @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_registration === 1)
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
                                @if($basicControl->google_recaptcha == 1 && $basicControl->google_recaptcha_user_registration == 1)
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
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                value=""
                                                id="flexCheckDefault"
                                            />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                @lang('I Agree with the Terms & conditions')
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn-custom w-100" type="submit">@lang('Create Account')</button>
                            <div class="bottom">
                                @lang('Already have an account')?
                                <a href="{{ route('login') }}">@lang('Login here')</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


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

        function refreshCaptcha() {
            let img = document.images['captcha_image'];
            img.src = img.src.substring(
                0, img.src.lastIndexOf("?")
            ) + "?rand=" + Math.random() * 1000;
        }

    </script>
@endpush


@extends(template().'layouts.app')
@section('title',__('Register'))


@section('content')
    <!-- signup_area_start -->
    <section class="contact_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 col-md-6 ms-auto order-2 order-md-1">
                    <div class="form_area p-4 shadow1 ">
                        <form action="{{ route('register') }}" method="post">
                            @csrf

                            @if(session()->get('sponsor') != null)
                                <div class="col-md-12">
                                    <div class="form-group mb-30">
                                        <label>@lang('Sponsor Name')</label>
                                        <input type="text" name="sponsor" class="form-control" id="sponsor"
                                               placeholder="{{trans('Sponsor By') }}"
                                               value="{{session()->get('sponsor')}}" readonly>
                                    </div>
                                </div>
                            @endif

                            <div class="form_title pb-2">
                                <h3>{!! $login_registration['single']['registration_title'] !!}</h3>
                            </div>

                            <div class="mb-4">
                                <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}" placeholder="@lang('First Name')">
                                @error('first_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                            </div>

                            <div class="mb-4">
                                <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}" placeholder="@lang('Last Name')">
                                @error('last_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                            </div>
                            <div class="mb-4">
                                <input type="text" name="username" class="form-control" value="{{old('username')}}" placeholder="@lang('Username')"/>
                                @error('username')<span class="text-danger mt-1">@lang($message)</span>@enderror
                            </div>
                            <div class="mb-4">
                                <input type="text" name="email" class="form-control" value="{{old('email')}}" placeholder="@lang('Email Address')"/>
                                @error('email')<span class="text-danger mt-1">@lang($message)</span>@enderror
                            </div>

                            <div class="mb-4">
                                <input type="hidden" name="phone_code" id="phoneCode" >
                                <input type="hidden" name="country_code" id="countryCode" >
                                <input type="hidden" name="country" id="countryName" >
                                <input type="tel" id="telephone" name="phone" value="{{old('phone')}}"  class="sign-in-input">
                                @error('phone')<span class="text-danger mt-1">@lang($message)</span>@enderror
                            </div>



                            <div class="mb-4">
                                <input type="password" name="password" class="form-control" placeholder="@lang('Password')"/>
                                @error('password')<span class="text-danger mt-1">@lang($message)</span>@enderror
                            </div>

                            <div class="mb-4">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Confirm Password')"/>
                                @error('password_confirmation')<span class="text-danger mt-1">@lang($message)</span>@enderror
                            </div>

                            @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_registration === 1)
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
                                            <i class="fal fa-undo"></i>
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

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">@lang('I agree to the terms and
                                    conditions.')</label>
                            </div>
                            <button type="submit" class="btn custom_btn mt-30">@lang('Register')</button>
                            <div class="pt-5 d-flex">
                                @lang('Already have an account?')
                                <br>
                                <h6 class="ms-2"><a href="{{ route('login') }}">@lang('Log In')</a></h6>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 order-1 order-md-2">
                    <div class="image_area">
                        <img src="{{ $login_registration['single']['media']->image?getFile($login_registration['single']['media']->image->driver,$login_registration['single']['media']->image->path):'' }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- signup_area_end -->
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

@push('style')
    <style>
        #telephone{
            width: 100%;
            border: none;
            border-radius: 5px;
        }

        #telephone:focus{
            border: 1px solid var(--btn-bg1);
            outline: 0;
            box-shadow: none;
        }

        .iti--show-flags{
            width: 100%;
        }
    </style>
@endpush


@extends(template().'layouts.app')
@section('title','Register')


@section('content')
    <section id="about-us" class="about-page secbg-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-block py-5">
                        <form class="login-form" action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="signin">
                                <h3 class="title mb-30">@lang('SIGN UP FORM')</h3>

                                <div class="row">
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

                                    <div class="col-md-6">
                                        <div class="form-group mb-30">
                                            <input class="form-control" type="text" name="first_name"
                                                   value="{{old('first_name')}}" placeholder="@lang('First Name')">
                                            @error('first_name')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-30">
                                            <input class="form-control " type="text" name="last_name"
                                                   value="{{old('last_name')}}" placeholder="@lang('Last Name')">
                                            @error('last_name')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-30">
                                            <input class="form-control " type="text" name="username"
                                                   value="{{old('username')}}" placeholder="@lang('Username')">
                                            @error('username')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group mb-30">
                                            <input class="form-control" type="text" name="email"
                                                   value="{{old('email')}}" placeholder="@lang('Email Address')">
                                            @error('email')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                        <div class="col-md-12 form-floating">
                                            <div class="phone-input mb-30">
                                                <input type="hidden" name="phone_code" id="phoneCode" >
                                                <input type="hidden" name="country_code" id="countryCode" >
                                                <input type="hidden" name="country" id="countryName" >
                                                <input type="tel" id="telephone" name="phone" value="{{old('phone')}}"  class="sign-in-input">
                                            </div>
                                            @error('phone')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>


                                    <div class="col-md-6">
                                        <div class="form-group mb-20">
                                            <input class="form-control" type="password" name="password"
                                                   placeholder="@lang('Password')">
                                            @error('password')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-20">
                                            <input class="form-control" type="password" name="password_confirmation"
                                                   placeholder="@lang('Confirm Password')">
                                        </div>
                                    </div>

                                        @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_registration === 1)
                                           <div class="col-md-6">
                                               <div class="mb-4">
                                                   <input type="text" tabindex="2"
                                                          class="form-control form-control-lg @error('captcha') is-invalid @enderror"
                                                          name="captcha" id="captcha" autocomplete="off"
                                                          placeholder="Enter Captcha" required>
                                                   @error('captcha')
                                                   <span class="invalid-feedback">{{ $message }}</span>
                                                   @enderror
                                               </div>
                                           </div>

                                            <div class="col-md-6">
                                                <div class="ps-3 pe-3 mt-0">
                                                    <div class="input-group captcha input-group-merge" data-hs-validation-validate-class>
                                                        <img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image'>
                                                        <a class="input-group-append input-group-text"
                                                           href='javascript: refreshCaptcha();'>
                                                            <i class="fas fa-sync"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($basicControl->google_recaptcha == 1 && $basicControl->google_recaptcha_user_registration == 1)
                                            <div class="row ml-3 mt-2 mb-4">
                                                <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                                @error('g-recaptcha-response')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif
                                </div>



                                <div class="btn-area">
                                    <button class="btn-login login-auth-btn" type="submit"><span>@lang('Sign Up')</span>
                                    </button>
                                </div>

                                <div class="login-query mt-30 text-center">
                                    <a href="{{ route('login') }}">@lang("Already have an account? Login")</a>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection

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

    </script>
@endpush


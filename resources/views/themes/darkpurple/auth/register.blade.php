@extends(template().'layouts.app')
@section('title',__('Register'))


@section('content')
    <!-- Register section -->
    <section class="login-section">
        <div class="container h-100">
            <div class="row h-100 justify-content-center">
                <div class="col-lg-6">
                    <div class="form-wrapper d-flex align-items-center h-100">
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

                            <div class="row g-4">
                                <div class="col-12">
                                    <h4>@lang('Register Here')</h4>
                                </div>
                                <div class="input-box col-12">
                                    <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}" placeholder="@lang('First Name')">
                                    @error('first_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                </div>

                                <div class="input-box col-12">
                                    <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}" placeholder="@lang('Last Name')">
                                    @error('last_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                </div>

                                <div class="input-box col-12">
                                    <input type="text" name="username" class="form-control" value="{{old('username')}}" placeholder="@lang('Username')"/>
                                    @error('username')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                </div>

                                <div class="input-box col-12">
                                    <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="@lang('Email Address')"/>
                                    @error('email')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                </div>

                                <div class="input-box col-12">
                                    @php
                                        $country_code = (string) @getIpInfo()['code'] ?: null;
                                        $myCollection = collect(config('country'))->map(function($row) {
                                            return collect($row);
                                        });
                                        $countries = $myCollection->sortBy('code');
                                    @endphp
                                    <div class="form-group mb-1">
                                        <select name="phone_code" class="form-control country_code dialCode-change register_phone_select">
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

                                    <input type="text" name="phone" class="form-control dialcode-set" value="{{old('phone')}}" placeholder="@lang('Phone Number')">
                                    @error('phone')
                                    <span class="text-danger mt-1">@lang($message)</span>
                                    @enderror
                                </div>

                                <input type="hidden" name="country_code" value="{{old('country_code')}}" class="text-dark">

                                <div class="input-box col-12">
                                    <input type="password" name="password" class="form-control" placeholder="@lang('Password')"/>
                                    @error('password')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                </div>

                                <div class="input-box col-12">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Confirm Password')"/>
                                    @error('password_confirmation')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                </div>

                                @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_registration === 1)
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
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                @lang('I agree to the terms and conditions.')
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn-custom">@lang('Register')</button>
                            <div class="bottom">
                                @lang('Already have an account?')

                                <a href="{{ route('login') }}">@lang('Log In')</a>
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


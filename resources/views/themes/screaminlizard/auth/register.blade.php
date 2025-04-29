@extends(template().'layouts.app')
@section('title',__('Register'))


@section('content')
    <!-- register start -->
    <section class="login-section register">
        <div class="container">
            <div class="row justify-content-center align-items-end">
                <div class="col-lg-7 col-md-8">
                    <div class="form-wrapper">
                        <div class="form-box">
                            <div class="tab-content" id="pills-tabContent">
                                <div
                                    class="tab-pane fade show active"
                                    id="pills-influencer"
                                    role="tabpanel"
                                    aria-labelledby="pills-influencer-tab"
                                >
                                    <div class="mb-4">
                                        <h4>@lang('Create an account')</h4>
                                    </div>
                                    <form action="{{ route('register') }}" method="post">
                                        @csrf

                                        <div class="row g-4">
                                            @if(session()->get('sponsor') != null)
                                                <div class="input-box col-lg-12">
                                                    <input type="text" name="sponsor" id="sponsor" class="form-control" placeholder="{{trans('Sponsor By') }}" value="{{session()->get('sponsor')}}" readonly autocomplete="off"/>
                                                </div>
                                            @endif
                                            <div class="input-box col-lg-6">
                                                <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}" placeholder="@lang('First Name')" autocomplete="off"/>
                                                @error('first_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="input-box col-lg-6">
                                                <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}" placeholder="@lang('Last Name')" autocomplete="off"/>
                                                @error('last_name')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="input-box col-lg-6">
                                                <input type="text" name="username" class="form-control" value="{{old('username')}}" placeholder="@lang('Username')" autocomplete="off"/>
                                                @error('username')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="input-box col-lg-6">
                                                <input type="text" name="email" class="form-control" value="{{old('email')}}" placeholder="@lang('Email Address')" autocomplete="off"/>
                                                @error('email')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>

                                            <div class="input-box col-lg-6">
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
                                            <div class="input-box col-lg-6">
                                                <input type="text" name="phone" class="form-control dialcode-set" value="{{old('phone')}}" placeholder="@lang('Phone Number')"/>
                                                @error('phone')
                                                <span class="text-danger mt-1">@lang($message)</span>
                                                @enderror
                                            </div>
                                            <input type="hidden" name="country_code" value="{{old('country_code')}}" class="text-dark">

                                            <div class="input-box col-lg-6">
                                                <input type="password" name="password" class="form-control" placeholder="@lang('Password')"/>
                                                @error('password')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="input-box col-lg-6">
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Confirm Password')"/>
                                            </div>

                                                @if($basicControl->manual_recaptcha === 1 && $basicControl->manual_recaptcha_user_registration === 1)
                                                    <div class="input-box col-md-12">
                                                        <input type="text" tabindex="2"
                                                               class="form-control form-control-lg @error('captcha') is-invalid @enderror"
                                                               name="captcha" id="captcha" autocomplete="off"
                                                               placeholder="Enter Captcha" required>
                                                        @error('captcha')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="ps-3 pe-3 mt-0">
                                                        <div class="input-group captcha input-group-merge" data-hs-validation-validate-class>
                                                            <img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image'>
                                                            <a class="input-group-append input-group-text"
                                                               href='javascript: refreshCaptcha();'>
                                                                <i class="fal fa-sync"></i>
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
                                        <button class="btn-custom w-100" type="submit">@lang('sign up')</button>
                                        <div class="bottom">
                                            @lang('Already have an account?')
                                            <a href="{{ route('login') }}">@lang('Login here')</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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



@push('style')
    <style>
        .captcha{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 0;
        }

        .captcha img{
            width: 120px;
            padding: 10px;
        }

        .captcha .input-group-append{
            width: 55px;
            height: 59px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: transparent;
            color: #FFFFFF;
        }

        .captcha .input-group-append i{
            position: absolute;
            top: 18px;
            right: 21px;
        }
    </style>
@endpush


@extends(template().'layouts.app')
@section('title',__('Register'))


@section('content')
    <!-- Register Section -->
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7">
                    <div class="register-form-wrapper">
                        <form action="{{ route('register') }}" method="post">
                            @csrf

                            <div class="row g-4">
                                <div class="col-12">
                                    <h4>Create An Account</h4>
                                </div>
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

                                @if(basicControl()->reCaptcha_status_registration)
                                    <div class="col-md-6 box mb-4 form-group">
                                        {!! NoCaptcha::renderJs(session()->get('trans')) !!}
                                        {!! NoCaptcha::display($basic->theme == 'deepblack' ? ['data-theme' => 'dark'] : []) !!}
                                        @error('g-recaptcha-response')
                                        <span class="text-danger mt-1">@lang($message)</span>
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
    </section>
@endsection


@push('script')
    <script>
        "use strict";
        $(document).ready(function () {
            setDialCode();
            $(document).on('change', '.dialCode-change', function () {
                setDialCode();
            });

            function setDialCode() {
                let currency = $('.dialCode-change').val();
                $('.dialcode-set').val(currency);
            }
        });
    </script>
@endpush

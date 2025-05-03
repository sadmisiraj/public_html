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
                                    <form action="{{ route('register') }}" method="post" id="registration-form" novalidate>
                                        @csrf
                                        <div class="section-header">
                                            <h3>{!! $login_registration['single']['registration_title'] !!}</h3>
                                            <div class="description">
                                                {!! $login_registration['single']['registration_sub_title'] !!}
                                            </div>
                                            
                                            @if(isset($invalidSponsorLink) && $invalidSponsorLink)
                                                <div class="alert alert-warning mt-3">
                                                    <small>@lang('The referral link you clicked contains an invalid code. Please enter a valid referral code below.')</small>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="row g-4">
                                            <!-- Sponsor Field -->
                                            <div class="col-md-12 form-floating">
                                                <div class="input-group">
                                                    <input type="text" name="sponsor" class="form-control" id="sponsor"
                                                          placeholder="{{trans('Sponsor By') }}"
                                                          value="{{ $sponsor ?? '' }}" {{ isset($validSponsor) && $validSponsor ? 'readonly' : '' }} autocomplete="off" required/>
                                                    @if(!isset($validSponsor) || !$validSponsor)
                                                        <button type="button" class="btn btn-info" id="validate-sponsor">@lang('Validate')</button>
                                                    @endif
                                                </div>
                                                <div id="sponsor-name" class="mt-2">
                                                    @if(isset($validSponsor) && $validSponsor && isset($sponsorUser))
                                                        <span class="text-success">Referrer: {{ $sponsorUser->fullname }}</span>
                                                    @endif
                                                </div>
                                                <div id="sponsor-feedback" class="invalid-feedback">@lang('A valid referral code is required')</div>
                                                @error('sponsor')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            
                                            <!-- Email Field -->
                                            <div class="col-md-12">
                                                <input type="email" name="email" class="form-control" id="email"
                                                      placeholder="@lang('Email Address')" value="{{ old('email') }}" required>
                                                <div class="invalid-feedback">@lang('Please enter a valid email address')</div>
                                                @error('email')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            
                                            <!-- Phone Field -->
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <select name="phone_code" id="phone_code" class="form-select" style="max-width: 150px;" required>
                                                        @php
                                                            $country_code = (string) @getIpInfo()['code'] ?: null;
                                                            $myCollection = collect(config('country'))->map(function($row) {
                                                                return collect($row);
                                                            });
                                                            $countries = $myCollection->sortBy('code');
                                                        @endphp
                                                        @foreach(config('country') as $value)
                                                            <option value="{{$value['phone_code']}}"
                                                                    data-name="{{$value['name']}}"
                                                                    data-code="{{$value['code']}}"
                                                                {{$country_code == $value['code'] ? 'selected' : ''}}
                                                            > {{$value['name']}} ({{$value['phone_code']}})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" class="form-control" id="phone" name="phone" 
                                                           placeholder="@lang('Phone Number')" value="{{ old('phone') }}" required>
                                                    <input type="hidden" name="country_code" id="country_code" value="{{ old('country_code') }}">
                                                    <input type="hidden" name="country" id="country" value="{{ old('country') }}">
                                                </div>
                                                <div class="invalid-feedback">@lang('Phone number is required')</div>
                                                @error('phone')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            
                                            <!-- Password Fields -->
                                            <div class="col-md-12">
                                                <input type="password" name="password" class="form-control" id="password" placeholder="@lang('Password')" required>
                                                <div class="invalid-feedback">@lang('Password is required (minimum 6 characters)')</div>
                                                @error('password')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="@lang('Confirm Password')" required>
                                                <div class="invalid-feedback">@lang('Passwords do not match')</div>
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
                                        <button type="submit" class="cmn-btn mt-30 w-100" id="register-btn" {{ isset($validSponsor) && $validSponsor ? '' : 'disabled' }}><span>@lang('signup')</span></button>
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
<script>
    $(document).ready(function(){
        // Update country code and country name when phone code changes
        $('#phone_code').change(function() {
            var selectedOption = $(this).find('option:selected');
            $('#country_code').val(selectedOption.data('code'));
            $('#country').val(selectedOption.data('name'));
        });
        
        // Trigger change to set initial values
        $('#phone_code').trigger('change');
        
        // Enable/disable register button based on sponsor validation
        function updateRegisterButton() {
            if ($('#sponsor-name').hasClass('text-success') || $('#sponsor-name').find('.text-success').length > 0) {
                $('#register-btn').prop('disabled', false);
            } else {
                $('#register-btn').prop('disabled', true);
            }
        }
        
        // If sponsor is already set from URL and is valid, enable registration
        if ($('#sponsor').val() && $('#sponsor').prop('readonly') && $('#sponsor-name').find('.text-success').length > 0) {
            updateRegisterButton();
        }
        
        // If invalid sponsor link was provided, show error state
        @if(isset($invalidSponsorLink) && $invalidSponsorLink)
        $('#sponsor-name').html('<span class="text-danger">Invalid referral code</span>');
        $('#sponsor').addClass('is-invalid');
        @endif
        
        // Validate sponsor on button click
        $('#validate-sponsor').on('click', function() {
            validateSponsor();
        });
        
        // Also validate on input change
        $('#sponsor').on('change', function() {
            if ($(this).val()) {
                validateSponsor();
            } else {
                $('#sponsor-name').html('<span class="text-danger">Referral code is required</span>');
                updateRegisterButton();
            }
        });
        
        function validateSponsor() {
            let sponsor = $('#sponsor').val();
            if (!sponsor) {
                $('#sponsor-name').html('<span class="text-danger">Referral code is required</span>');
                $('#sponsor').addClass('is-invalid').removeClass('is-valid');
                updateRegisterButton();
                return;
            }
            
            // Show loading indicator
            $('#sponsor-name').html('<span class="text-info">Validating...</span>');
            $('#validate-sponsor').prop('disabled', true);
            
            $.ajax({
                url: '{{ route("check.referral.code") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    sponsor: sponsor
                },
                success: function(response) {
                    if (response.success) {
                        $('#sponsor-name').html('<span class="text-success">Referrer: ' + response.data.name + '</span>');
                        $('#sponsor').removeClass('is-invalid').addClass('is-valid');
                    } else {
                        $('#sponsor-name').html('<span class="text-danger">Invalid referral code</span>');
                        $('#sponsor').removeClass('is-valid').addClass('is-invalid');
                    }
                    $('#validate-sponsor').prop('disabled', false);
                    updateRegisterButton();
                },
                error: function() {
                    $('#sponsor-name').html('<span class="text-danger">Error validating referral code</span>');
                    $('#sponsor').removeClass('is-valid').addClass('is-invalid');
                    $('#validate-sponsor').prop('disabled', false);
                    updateRegisterButton();
                }
            });
        }

        // Form validation
        $('#registration-form').on('submit', function(e) {
            let isValid = true;
            
            // Check email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!$('#email').val() || !emailRegex.test($('#email').val())) {
                $('#email').addClass('is-invalid');
                isValid = false;
            } else {
                $('#email').removeClass('is-invalid').addClass('is-valid');
            }
            
            // Check phone
            if (!$('#phone').val()) {
                $('#phone').addClass('is-invalid');
                isValid = false;
            } else {
                $('#phone').removeClass('is-invalid').addClass('is-valid');
            }
            
            // Check password
            if (!$('#password').val() || $('#password').val().length < 6) {
                $('#password').addClass('is-invalid');
                isValid = false;
            } else {
                $('#password').removeClass('is-invalid').addClass('is-valid');
            }
            
            // Check password confirmation
            if (!$('#password_confirmation').val() || $('#password_confirmation').val() !== $('#password').val()) {
                $('#password_confirmation').addClass('is-invalid');
                isValid = false;
            } else {
                $('#password_confirmation').removeClass('is-invalid').addClass('is-valid');
            }
            
            // Check sponsor validation
            if (!$('#sponsor-name').find('.text-success').length && !$('#sponsor-name').hasClass('text-success')) {
                $('#sponsor').addClass('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }
            
            return true;
        });
        
        // Real-time validation of password match
        $('#password, #password_confirmation').on('keyup', function() {
            if ($('#password_confirmation').val()) {
                if ($('#password').val() !== $('#password_confirmation').val()) {
                    $('#password_confirmation').addClass('is-invalid').removeClass('is-valid');
                } else {
                    $('#password_confirmation').removeClass('is-invalid').addClass('is-valid');
                }
            }
        });
        
        // Real-time email validation
        $('#email').on('keyup', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if ($(this).val() && emailRegex.test($(this).val())) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid');
                if ($(this).val()) {
                    $(this).addClass('is-invalid');
                }
            }
        });
    });
</script>
@endpush

@push('style')
<style>
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .is-valid {
        border-color: #28a745 !important;
    }
    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #dc3545;
    }
    .is-invalid ~ .invalid-feedback {
        display: block;
    }
</style>
@endpush

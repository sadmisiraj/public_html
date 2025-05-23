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
                                                        <span class="text-success">Guide:</span>
                                                        <!-- <span class="text-success">Referrer: {{ $sponsorUser->fullname }}</span>
                                                        @if(isset($referralNode) && $referralNode)
                                                            <span class="text-success ms-2">({{ ucfirst($referralNode) }} Placement)</span>
                                                            <input type="hidden" name="referral_node" value="{{ $referralNode }}">
                                                        @endif -->
                                                    @endif
                                                </div>
                                                
                                                <!-- Placement Selection - will show after sponsor validation or when sponsor is from URL but without position -->
                                                <div id="placement-selection" class="mt-3" style="display: {{ (isset($needPlacementSelection) && $needPlacementSelection) ? 'block' : 'none' }};">
                                                    <label class="form-label fw-bold">@lang('Select Placement Position')</label>
                                                    <div class="btn-group w-100" role="group">
                                                        <input type="radio" class="btn-check" name="referral_node" id="leftPlacement" value="left" autocomplete="off">
                                                        <label class="btn btn-outline-primary" for="leftPlacement">
                                                            <i class="bi bi-arrow-left-circle me-1"></i> @lang('Left')
                                                        </label>
                                                        
                                                        <input type="radio" class="btn-check" name="referral_node" id="rightPlacement" value="right" autocomplete="off">
                                                        <label class="btn btn-outline-primary" for="rightPlacement">
                                                            @lang('Right') <i class="bi bi-arrow-right-circle ms-1"></i>
                                                        </label>
                                                    </div>
                                                    @if(isset($needPlacementSelection) && $needPlacementSelection)
                                                    <div class="form-text text-danger">Please select a placement position</div>
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
                                                    <select name="phone_code" id="phone_code" class="form-select" style="max-width: 150px; display: none;" required>
                                                        <option value="+91" data-name="India" data-code="IN" selected> India (+91)</option>
                                                    </select>
                                                    <input type="text" class="form-control" id="phone" name="phone" 
                                                           placeholder="@lang('Phone Number')" value="{{ old('phone') }}" required>
                                                    <input type="hidden" name="country_code" id="country_code" value="{{ old('country_code') }}">
                                                    <input type="hidden" name="country" id="country" value="{{ old('country') }}">
                                                </div>
                                                <div class="invalid-feedback">@lang('Phone number is required')</div>
                                                @error('phone')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            
                                            <!-- State Field -->
                                            <div class="col-md-12">
                                                <select name="state" class="form-select select2-states" id="state" required>
                                                    <option value="" selected disabled>@lang('Select State')</option>
                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                    <option value="Assam">Assam</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                                    <option value="Goa">Goa</option>
                                                    <option value="Gujarat">Gujarat</option>
                                                    <option value="Haryana">Haryana</option>
                                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="Karnataka">Karnataka</option>
                                                    <option value="Kerala">Kerala</option>
                                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                    <option value="Maharashtra">Maharashtra</option>
                                                    <option value="Manipur">Manipur</option>
                                                    <option value="Meghalaya">Meghalaya</option>
                                                    <option value="Mizoram">Mizoram</option>
                                                    <option value="Nagaland">Nagaland</option>
                                                    <option value="Odisha">Odisha</option>
                                                    <option value="Punjab">Punjab</option>
                                                    <option value="Rajasthan">Rajasthan</option>
                                                    <option value="Sikkim">Sikkim</option>
                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                    <option value="Telangana">Telangana</option>
                                                    <option value="Tripura">Tripura</option>
                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                    <option value="Uttarakhand">Uttarakhand</option>
                                                    <option value="West Bengal">West Bengal</option>
                                                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                    <option value="Chandigarh">Chandigarh</option>
                                                    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                                    <option value="Delhi">Delhi</option>
                                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                    <option value="Ladakh">Ladakh</option>
                                                    <option value="Lakshadweep">Lakshadweep</option>
                                                    <option value="Puducherry">Puducherry</option>
                                                </select>
                                                <div class="invalid-feedback">@lang('Please select a state')</div>
                                                @error('state')<span class="text-danger mt-1">@lang($message)</span>@enderror
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
        // Initialize select2 for state dropdown with search
        $('.select2-states').select2({
            placeholder: "Select State",
            allowClear: true,
            width: '100%'
        });
        
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
                // If placement selection is visible (manually entered referral code), 
                // check if placement has been selected
                if ($('#placement-selection').is(':visible')) {
                    if ($('input[name="referral_node"]:checked').length > 0) {
                        $('#register-btn').prop('disabled', false);
                    } else {
                        $('#register-btn').prop('disabled', true);
                    }
                } else {
                    // If hidden input for referral node exists or placement selection is not required
                    $('#register-btn').prop('disabled', false);
                }
            } else {
                $('#register-btn').prop('disabled', true);
            }
        }
        
        // If sponsor is already set from URL and is valid, enable registration
        if ($('#sponsor').val() && $('#sponsor').prop('readonly') && $('#sponsor-name').find('.text-success').length > 0) {
            // Check if placement is needed
            if ($('#placement-selection').is(':visible')) {
                // Disable register button until placement is selected
                $('#register-btn').prop('disabled', true);
                
                // Add event listeners for placement selection
                $('#leftPlacement, #rightPlacement').on('change', function() {
                    if ($('input[name="referral_node"]:checked').length) {
                        $('#register-btn').prop('disabled', false);
                        $('#placement-selection .form-text').removeClass('text-danger').addClass('text-success').text('Placement selected');
                    }
                });
            } else {
                // If placement is already set or not needed, enable register button
                $('#register-btn').prop('disabled', false);
            }
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
                        
                        // If user manually entered the referral code, show placement selection
                        // Only show if not already coming from a referral link with position
                        if (!$('input[name="referral_node"][type="hidden"]').length) {
                            $('#placement-selection').show();
                            $('#placement-selection').append('<div class="form-text text-danger">Please select a placement position</div>');
                            // Initially disable register button until placement is selected
                            $('#register-btn').prop('disabled', true);
                            
                            // Enable button only when placement is selected
                            $('#leftPlacement, #rightPlacement').on('change', function() {
                                if ($('input[name="referral_node"]:checked').length) {
                                    $('#register-btn').prop('disabled', false);
                                    $('#placement-selection .form-text').removeClass('text-danger').addClass('text-success').text('Placement selected');
                                }
                            });
                        } else {
                            // If coming from a referral link with position already set, enable the button
                            $('#register-btn').prop('disabled', false);
                        }
                    } else {
                        $('#sponsor-name').html('<span class="text-danger">Invalid referral code</span>');
                        $('#sponsor').removeClass('is-valid').addClass('is-invalid');
                        $('#placement-selection').hide();
                    }
                    $('#validate-sponsor').prop('disabled', false);
                    updateRegisterButton();
                },
                error: function() {
                    $('#sponsor-name').html('<span class="text-danger">Error validating referral code</span>');
                    $('#sponsor').removeClass('is-valid').addClass('is-invalid');
                    $('#validate-sponsor').prop('disabled', false);
                    $('#placement-selection').hide();
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
            
            // Check state
            if (!$('#state').val()) {
                $('#state').addClass('is-invalid');
                isValid = false;
            } else {
                $('#state').removeClass('is-invalid').addClass('is-valid');
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
            
            // Check if placement selection is required and selected
            if ($('#placement-selection').is(':visible') && !$('input[name="referral_node"]:checked').length) {
                $('#placement-selection').addClass('is-invalid');
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
        
        // Real-time state validation
        $('#state').on('change', function() {
            if ($(this).val()) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
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
    
    /* Select2 styling */
    .select2-container--default .select2-selection--single {
        height: 45px;
        border-radius: 4px;
        padding: 8px 12px;
        border: 1px solid #ced4da;
        background-color: #fff;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 43px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
        color: #212529;
    }
    
    .select2-container--default .select2-search--dropdown .select2-search__field {
        padding: 8px;
        border-radius: 4px;
    }
    
    .select2-dropdown {
        border: 1px solid #ced4da;
        border-radius: 4px;
    }
</style>
@endpush

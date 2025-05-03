{{-- 
    This is a clean, standalone registration form template that can be used if there are issues with theme templates.
    It handles sponsor validation correctly and includes all required fields.
    
    To use this template:
    1. In a controller, return view('instruction-page', compact('sponsor', 'validSponsor', 'sponsorUser'));
    2. Make sure to pass the variables: sponsor, validSponsor, and sponsorUser
--}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        .btn-custom {
            background-color: #b68c5a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
        }
        .btn-custom:hover {
            background-color: #9a784c;
            color: white;
        }
        .btn-info {
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <div class="text-center mb-4">
                        <h2>Welcome Back!</h2>
                        <p class="text-muted">Hey Enter your details to get sign in to your account</p>
                    </div>
                    
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="sponsor" class="form-label">Sponsor By</label>
                            <div class="input-group">
                                <input type="text" name="sponsor" id="sponsor" class="form-control" 
                                       placeholder="Enter referral code" 
                                       value="{{ $sponsor ?? '' }}" 
                                       {{ isset($validSponsor) && $validSponsor ? 'readonly' : '' }}>
                                @if(!isset($validSponsor) || !$validSponsor)
                                    <button type="button" class="btn btn-info" id="validate-sponsor">Validate</button>
                                @endif
                            </div>
                            <div id="sponsor-name" class="mt-2">
                                @if(isset($validSponsor) && $validSponsor && isset($sponsorUser))
                                    <span class="text-success">Referrer: {{ $sponsorUser->fullname }}</span>
                                @endif
                            </div>
                            @error('sponsor')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First Name">
                                @error('first_name')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">
                                @error('last_name')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email Address">
                            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <select name="phone_code" id="phone_code" class="form-select" style="max-width: 150px;">
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
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                                <input type="hidden" name="country_code" id="country_code" value="{{ old('country_code') }}">
                                <input type="hidden" name="country" id="country" value="{{ old('country') }}">
                            </div>
                            @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                @error('password')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms">
                            <label class="form-check-label" for="terms">I agree with the Terms & conditions</label>
                        </div>
                        
                        <button type="submit" class="btn btn-custom w-100 mb-3" id="register-btn" {{ isset($validSponsor) && $validSponsor ? '' : 'disabled' }}>Signup</button>
                        
                        <div class="text-center">
                            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
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
                    updateRegisterButton();
                    return;
                }
                
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
                        } else {
                            $('#sponsor-name').html('<span class="text-danger">Invalid referral code</span>');
                        }
                        updateRegisterButton();
                    },
                    error: function() {
                        $('#sponsor-name').html('<span class="text-danger">Error validating referral code</span>');
                        updateRegisterButton();
                    }
                });
            }
        });
    </script>
</body>
</html>

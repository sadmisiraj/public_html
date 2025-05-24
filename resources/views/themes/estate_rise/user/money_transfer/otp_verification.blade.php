@extends(template().'layouts.user')
@section('title', $page_title)

@push('css-lib')
    <style>
        .countdown-text {
            display: none;
            color: #dc3545;
            margin-top: 8px;
        }
        .resend-links {
            margin-top: 20px;
            text-align: center;
        }
        .resend-btn {
            display: inline-block;
            color: #007bff;
            cursor: pointer;
            text-decoration: underline;
        }
        .resend-btn.disabled {
            color: #6c757d;
            cursor: not-allowed;
            text-decoration: none;
        }
        .divider {
            margin: 0 10px;
            color: #6c757d;
        }
        .verification-methods {
            margin-bottom: 30px;
        }
        .verification-method {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .method-info {
            display: flex;
            align-items: center;
        }
        .method-icon {
            font-size: 24px;
            margin-right: 15px;
        }
        .method-details h5 {
            margin: 0;
            font-size: 16px;
        }
        .method-details p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #6c757d;
        }
        .otp-form {
            display: none;
        }
        .otp-form.active {
            display: block;
        }
    </style>
@endpush

@section('content')
<div class="main-wrapper">
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Money Transfer Security Verification')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Money Transfer Security Verification')</li>
            </ol>
        </nav>
    </div>
    
    <div class="row g-4 justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-15">@lang('Identity Verification Required')</h4>
                    
                    <div class="alert alert-info">
                        <p class="mb-0">@lang('For security reasons, please verify your identity before accessing the money transfer page.')</p>
                    </div>
                    
                    <div class="verification-methods" id="verification-methods">
                        <div class="verification-method">
                            <div class="method-info">
                                <div class="method-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                                <div class="method-details">
                                    <h5>@lang('SMS Verification')</h5>
                                    <p>@lang('Send code to') {{ $maskedPhone }}</p>
                                </div>
                            </div>
                            <button type="button" class="cmn-btn btn-sm" id="send-sms-btn" data-method="sms">@lang('Send Code')</button>
                        </div>
                        
                        <div class="verification-method">
                            <div class="method-info">
                                <div class="method-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div class="method-details">
                                    <h5>@lang('Email Verification')</h5>
                                    <p>@lang('Send code to') {{ $maskedEmail }}</p>
                                </div>
                            </div>
                            <button type="button" class="cmn-btn btn-sm" id="send-email-btn" data-method="email">@lang('Send Code')</button>
                        </div>
                    </div>
                    
                    <div class="otp-form" id="otp-form">
                        <div class="alert alert-success mb-3" id="sent-success-message" style="display: none;">
                        </div>
                        
                        <form action="{{ route('user.money.transfer.otp.verify') }}" method="post">
                            @csrf
                            <div class="profile-form-section">
                                <div class="row g-3">
                                    <div class="col-md-12 input-box">
                                        <label for="code" class="form-label">@lang('Verification Code')</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('code') is-invalid @enderror @error('error') is-invalid @enderror" 
                                                   name="code" value="{{ old('code') }}"
                                                   placeholder="@lang('Enter Verification Code')" autocomplete="off">
                                            <div class="invalid-feedback">
                                                @error('code') @lang($message) @enderror
                                                @error('error') @lang($message) @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="btn-area d-flex g-3 mt-4">
                                    <button type="submit" class="cmn-btn">@lang('Verify')</button>
                                </div>
                                
                                <div class="resend-links">
                                    <span class="countdown-text" id="countdown-timer"></span>
                                    <p id="sms-resend-options" style="display: none;">
                                        @lang('Didn\'t get Code?') 
                                        <a href="javascript:void(0)" id="resend-sms-btn" class="resend-btn" data-method="sms">@lang('Resend via SMS')</a> 
                                        <span class="divider">|</span> 
                                        <a href="javascript:void(0)" id="email-instead-btn" class="resend-btn" data-method="email">@lang('Send via Email instead')</a>
                                    </p>
                                    <p id="email-resend-options" style="display: none;">
                                        @lang('Didn\'t get Code?') 
                                        <a href="javascript:void(0)" id="resend-email-btn" class="resend-btn" data-method="email">@lang('Resend via Email')</a> 
                                        <span class="divider">|</span> 
                                        <a href="javascript:void(0)" id="sms-instead-btn" class="resend-btn" data-method="sms">@lang('Send via SMS instead')</a>
                                    </p>
                                    @error('resend')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    // Global variables
    let resendCount = 0;
    let countdownTime = 0;
    let countdownInterval;
    let timerRunning = false;
    let currentMethod = null;
    
    const verificationMethods = document.getElementById('verification-methods');
    const smsResendBtn = document.getElementById('resend-sms-btn');
    const emailResendBtn = document.getElementById('resend-email-btn');
    const emailInsteadBtn = document.getElementById('email-instead-btn');
    const smsInsteadBtn = document.getElementById('sms-instead-btn');
    const sendSmsBtn = document.getElementById('send-sms-btn');
    const sendEmailBtn = document.getElementById('send-email-btn');
    const countdownTimer = document.getElementById('countdown-timer');
    const otpForm = document.getElementById('otp-form');
    const sentSuccessMessage = document.getElementById('sent-success-message');
    const smsResendOptions = document.getElementById('sms-resend-options');
    const emailResendOptions = document.getElementById('email-resend-options');
    
    // Get cooldown time based on resend count
    function getCooldownTime(count) {
        switch (count) {
            case 0:
                return 0; // No cooldown for first send
            case 1:
                return 10; // 10 seconds for first resend
            case 2:
                return 30; // 30 seconds for second resend
            case 3:
                return 60; // 1 minute for third resend
            default:
                return 120; // 2 minutes for fourth and subsequent resends
        }
    }
    
    function startCountdown() {
        if (timerRunning) return;
        
        // Calculate cooldown time based on resend count
        countdownTime = getCooldownTime(resendCount);
        
        // If it's the initial send, don't show countdown
        if (countdownTime === 0) {
            resendCount++;
            return;
        }
        
        timerRunning = true;
        countdownTimer.style.display = 'block';
        
        // Disable resend buttons during countdown
        smsResendBtn.classList.add('disabled');
        emailResendBtn.classList.add('disabled');
        emailInsteadBtn.classList.add('disabled');
        smsInsteadBtn.classList.add('disabled');
        
        updateCountdownDisplay();
        
        countdownInterval = setInterval(function() {
            countdownTime--;
            updateCountdownDisplay();
            
            if (countdownTime <= 0) {
                clearInterval(countdownInterval);
                timerRunning = false;
                countdownTimer.style.display = 'none';
                
                // Re-enable resend buttons
                smsResendBtn.classList.remove('disabled');
                emailResendBtn.classList.remove('disabled');
                emailInsteadBtn.classList.remove('disabled');
                smsInsteadBtn.classList.remove('disabled');
            }
        }, 1000);
    }
    
    function updateCountdownDisplay() {
        const minutes = Math.floor(countdownTime / 60);
        const seconds = countdownTime % 60;
        
        if (minutes > 0) {
            countdownTimer.innerHTML = `@lang('Please wait') ${minutes}:${seconds < 10 ? '0' : ''}${seconds} @lang('before requesting another code')`;
        } else {
            countdownTimer.innerHTML = `@lang('Please wait') ${seconds} @lang('seconds before requesting another code')`;
        }
    }
    
    function showOtpForm(method, message) {
        // Hide verification methods
        verificationMethods.style.display = 'none';
        
        // Show OTP form
        otpForm.style.display = 'block';
        
        // Set success message
        sentSuccessMessage.textContent = message;
        sentSuccessMessage.style.display = 'block';
        
        // Show appropriate resend options
        if (method === 'sms') {
            smsResendOptions.style.display = 'block';
            emailResendOptions.style.display = 'none';
            currentMethod = 'sms';
        } else {
            smsResendOptions.style.display = 'none';
            emailResendOptions.style.display = 'block';
            currentMethod = 'email';
        }
        
        // Start countdown only if it's a resend (not first send)
        if (resendCount > 0) {
            startCountdown();
        } else {
            resendCount = 1; // Mark as first send completed
        }
    }
    
    function sendOtp(method) {
        if (timerRunning) return;
        
        // Show loading state
        const btn = method === 'sms' ? sendSmsBtn : sendEmailBtn;
        const originalText = btn.textContent;
        btn.textContent = '@lang("Sending...")';
        btn.disabled = true;
        
        // Make AJAX request to send OTP
        fetch(`{{ route('user.money.transfer.otp.sms') }}`.replace('sms', method))
            .then(response => {
                if (!response.ok) {
                    // Check if response contains validation error about waiting
                    return response.text().then(text => {
                        if (text.includes('Please wait')) {
                            const matches = text.match(/Please wait ([0-9]+ [a-z\s]+) before/);
                            if (matches && matches[1]) {
                                throw new Error(`Please wait ${matches[1]} before requesting another code`);
                            }
                        }
                        throw new Error('Error sending verification code');
                    });
                }
                return response.text();
            })
            .then(() => {
                // Increment resend count only if we're resending (not first send)
                if (otpForm.style.display === 'block') {
                    resendCount++;
                }
                
                // Show the OTP form with success message
                const message = method === 'sms' 
                    ? '@lang("Verification code has been sent to your phone")'
                    : '@lang("Verification code has been sent to your email")';
                    
                showOtpForm(method, message);
                
                // Reset button state
                btn.textContent = originalText;
                btn.disabled = false;
            })
            .catch(error => {
                console.error('Error sending OTP:', error);
                btn.textContent = originalText;
                btn.disabled = false;
                
                // Display error message to user
                alert(error.message || '@lang("Error sending verification code. Please try again.")');
                
                // If it's a cooldown error, resend count was already incremented server-side
                if (error.message && error.message.includes('Please wait')) {
                    resendCount++;
                    countdownTime = getCooldownTime(resendCount);
                    startCountdown();
                }
            });
    }
    
    // Handle initial OTP send button clicks
    sendSmsBtn.addEventListener('click', function() {
        sendOtp('sms');
    });
    
    sendEmailBtn.addEventListener('click', function() {
        sendOtp('email');
    });
    
    // Handle resend button clicks
    document.querySelectorAll('.resend-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (timerRunning || this.classList.contains('disabled')) return;
            
            const method = this.getAttribute('data-method');
            sendOtp(method);
        });
    });
    
    // Check for flash messages to show the OTP form
    @if(session('success'))
        // Initialize resend count to 1 since we've already sent the first code
        resendCount = 1;
        
        verificationMethods.style.display = 'none';
        otpForm.style.display = 'block';
        
        @if(strpos(session('success'), 'email') !== false)
            currentMethod = 'email';
            smsResendOptions.style.display = 'none';
            emailResendOptions.style.display = 'block';
            sentSuccessMessage.textContent = '{{ session('success') }}';
            sentSuccessMessage.style.display = 'block';
        @else
            currentMethod = 'sms';
            smsResendOptions.style.display = 'block';
            emailResendOptions.style.display = 'none';
            sentSuccessMessage.textContent = '{{ session('success') }}';
            sentSuccessMessage.style.display = 'block';
        @endif
    @endif
    
    // Check if there was a recent resend error
    @if($errors->has('resend'))
        // Initialize resend count to at least 1 (will be incremented if needed)
        resendCount = Math.max(1, resendCount);
        
        verificationMethods.style.display = 'none';
        otpForm.style.display = 'block';
        
        const errorMessage = '{{ $errors->first('resend') }}';
        
        // Check if error contains cooldown information
        if (errorMessage.includes('Please wait')) {
            // Extract the wait time and show countdown
            sentSuccessMessage.textContent = errorMessage;
            sentSuccessMessage.style.display = 'block';
            
            // Try to parse the wait time from the error message
            const matches = errorMessage.match(/Please wait ([0-9]+) ([a-z]+)/);
            if (matches && matches[1] && matches[2]) {
                const timeValue = parseInt(matches[1]);
                const timeUnit = matches[2];
                
                if (timeUnit === 'seconds') {
                    countdownTime = timeValue;
                } else if (timeUnit === 'minutes') {
                    countdownTime = timeValue * 60;
                }
                
                // Estimate the resend count based on cooldown time
                if (countdownTime <= 10) resendCount = 1;
                else if (countdownTime <= 30) resendCount = 2;
                else if (countdownTime <= 60) resendCount = 3;
                else resendCount = 4;
                
                startCountdown();
            }
        }
    @endif
    
    // Check if there are validation errors to keep the form visible
    @if($errors->any())
        verificationMethods.style.display = 'none';
        otpForm.style.display = 'block';
    @endif
</script>
@endpush 
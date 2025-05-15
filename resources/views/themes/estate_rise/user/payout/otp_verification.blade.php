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
    </style>
@endpush

@section('content')
<div class="main-wrapper">
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Payout Security Verification')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Payout Security Verification')</li>
            </ol>
        </nav>
    </div>
    
    <div class="row g-4 justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-15">@lang('OTP Verification')</h4>
                    
                    <div class="alert alert-info">
                        <p class="mb-0">@lang('An OTP has been sent to your registered phone number:') <strong>{{ $user->phone_code }}{{ $user->phone }}</strong></p>
                    </div>
                    
                    <form action="{{ route('user.payout.otp.verify') }}" method="post">
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
                                <p>
                                    @lang('Didn\'t get Code?') 
                                    <a href="javascript:void(0)" id="resend-sms-btn" class="resend-btn" onclick="resendCode('sms')">@lang('Resend via SMS')</a> 
                                    <span class="divider">|</span> 
                                    <a href="javascript:void(0)" id="resend-email-btn" class="resend-btn" onclick="resendCode('email')">@lang('Send via Email instead')</a>
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
@endsection

@push('script')
<script>
    let countdownTime = 120; // 2 minutes in seconds
    let countdownInterval;
    let timerRunning = false;
    const smsResendBtn = document.getElementById('resend-sms-btn');
    const emailResendBtn = document.getElementById('resend-email-btn');
    const countdownTimer = document.getElementById('countdown-timer');
    
    function startCountdown() {
        if (timerRunning) return;
        
        countdownTime = 120;
        timerRunning = true;
        countdownTimer.style.display = 'block';
        
        // Disable both buttons during countdown
        smsResendBtn.classList.add('disabled');
        emailResendBtn.classList.add('disabled');
        
        updateCountdownDisplay();
        
        countdownInterval = setInterval(function() {
            countdownTime--;
            updateCountdownDisplay();
            
            if (countdownTime <= 0) {
                clearInterval(countdownInterval);
                timerRunning = false;
                countdownTimer.style.display = 'none';
                
                // Re-enable both buttons
                smsResendBtn.classList.remove('disabled');
                emailResendBtn.classList.remove('disabled');
            }
        }, 1000);
    }
    
    function updateCountdownDisplay() {
        const minutes = Math.floor(countdownTime / 60);
        const seconds = countdownTime % 60;
        countdownTimer.innerHTML = `@lang('Please wait') ${minutes}:${seconds < 10 ? '0' : ''}${seconds} @lang('before requesting another code')`;
    }
    
    function resendCode(method) {
        if (timerRunning) return;
        
        startCountdown();
        
        // Navigate to the appropriate URL
        if (method === 'sms') {
            window.location.href = "{{ route('user.payout.otp.resend') }}";
        } else {
            window.location.href = "{{ route('user.payout.otp.email') }}";
        }
    }
    
    // Check if there was a recent resend error
    @if($errors->has('resend'))
        startCountdown();
    @endif
</script>
@endpush 
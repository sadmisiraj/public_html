@extends(template().'layouts.user')
@section('title', $page_title)

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
                            
                            <div class="text-center mt-4">
                                <p>@lang('Didn\'t get Code? Click to') <a href="{{ route('user.payout.otp.resend') }}" class="text-primary">@lang('Resend code')</a></p>
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
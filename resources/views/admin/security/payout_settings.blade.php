@extends('admin.layouts.app')
@section('page_title', __('Payout OTP Settings'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.dashboard') }}">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Payout Security Settings')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Payout OTP Settings')</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Payout Security Options')</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.security.payout.update') }}" method="post">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-grow-1">
                                                <h5 class="mb-0">@lang('Require OTP Verification for Payout')</h5>
                                                <span class="d-block small text-muted">
                                                    @lang('When enabled, users will need to verify via OTP before accessing the payout page.')
                                                </span>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" name="require_payout_otp" id="requirePayoutOTP" 
                                                    {{ $basicControl->require_payout_otp ? 'checked' : '' }}>
                                                <label class="form-check-label" for="requirePayoutOTP"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">@lang('Save Changes')</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Information')</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <p class="mb-0">
                                @lang('These settings control the security measures for user payouts. Enabling OTP verification provides an added layer of security before users can access the payout page.')
                            </p>
                        </div>
                        <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                @lang('OTP verification helps prevent unauthorized payouts')
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                @lang('Users receive a verification code via email')
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                @lang('The session remains verified until the user logs out')
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
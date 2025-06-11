@extends('admin.layouts.app')
@section('page_title', __('Security Settings'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.dashboard') }}">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Security Settings')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Security Settings')</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Security Options')</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.security.payout.update') }}" method="post">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="d-flex align-items-center mb-4">
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
                                        
                                        <div class="d-flex align-items-center mb-4">
                                            <div class="flex-grow-1">
                                                <h5 class="mb-0">@lang('Require OTP Verification for Money Transfer')</h5>
                                                <span class="d-block small text-muted">
                                                    @lang('When enabled, users will need to verify via OTP before accessing the money transfer page.')
                                                </span>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" name="require_money_transfer_otp" id="requireMoneyTransferOTP" 
                                                    {{ $basicControl->require_money_transfer_otp ? 'checked' : '' }}>
                                                <label class="form-check-label" for="requireMoneyTransferOTP"></label>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-4">
                                            <div class="flex-grow-1">
                                                <h5 class="mb-0">@lang('Enable Money Transfer Limits')</h5>
                                                <span class="d-block small text-muted">
                                                    @lang('When enabled, users will have limits on how frequently they can transfer money.')
                                                </span>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" name="money_transfer_limit_enabled" id="moneyTransferLimitEnabled" 
                                                    {{ $basicControl->money_transfer_limit_enabled ? 'checked' : '' }}>
                                                <label class="form-check-label" for="moneyTransferLimitEnabled"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Money Transfer Limit Settings -->
                            <div id="moneyTransferLimitSettings" class="row mb-4" style="display: {{ $basicControl->money_transfer_limit_enabled ? 'block' : 'none' }};">
                                <div class="col-md-12">
                                    <div class="card border-light">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title mb-0">@lang('Money Transfer Limit Configuration')</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="limitType" class="form-label">@lang('Limit Type')</label>
                                                    <select name="money_transfer_limit_type" id="limitType" class="form-select">
                                                        <option value="daily" {{ $basicControl->money_transfer_limit_type === 'daily' ? 'selected' : '' }}>@lang('Daily')</option>
                                                        <option value="weekly" {{ $basicControl->money_transfer_limit_type === 'weekly' ? 'selected' : '' }}>@lang('Weekly')</option>
                                                        <option value="custom_days" {{ $basicControl->money_transfer_limit_type === 'custom_days' ? 'selected' : '' }}>@lang('Custom Days')</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label for="limitCount" class="form-label">@lang('Number of Transfers Allowed')</label>
                                                    <input type="number" class="form-control" name="money_transfer_limit_count" id="limitCount" 
                                                        value="{{ $basicControl->money_transfer_limit_count ?? 1 }}" min="1" max="100">
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-3" id="customDaysRow" style="display: {{ $basicControl->money_transfer_limit_type === 'custom_days' ? 'block' : 'none' }};">
                                                <div class="col-md-6">
                                                    <label for="limitDays" class="form-label">@lang('Number of Days')</label>
                                                    <input type="number" class="form-control" name="money_transfer_limit_days" id="limitDays" 
                                                        value="{{ $basicControl->money_transfer_limit_days ?? 1 }}" min="1" max="365">
                                                    <small class="text-muted">@lang('For custom days limit type only')</small>
                                                </div>
                                            </div>

                                            <div class="alert alert-info">
                                                <strong>@lang('Examples:')</strong>
                                                <ul class="mb-0 mt-2">
                                                    <li><strong>@lang('Daily'):</strong> @lang('Users can transfer X times per day')</li>
                                                    <li><strong>@lang('Weekly'):</strong> @lang('Users can transfer X times per week')</li>
                                                    <li><strong>@lang('Custom Days'):</strong> @lang('Users can transfer X times every Y days')</li>
                                                </ul>
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
                                @lang('These settings control the security measures for user payouts and money transfers. Enabling OTP verification provides an added layer of security before users can access these features.')
                            </p>
                        </div>
                        <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                @lang('OTP verification helps prevent unauthorized transactions')
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                @lang('Users receive a verification code via email or SMS')
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                @lang('Transfer limits help control transaction frequency')
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                @lang('Limits reset automatically based on the configured period')
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const limitEnabledCheckbox = document.getElementById('moneyTransferLimitEnabled');
            const limitSettings = document.getElementById('moneyTransferLimitSettings');
            const limitTypeSelect = document.getElementById('limitType');
            const customDaysRow = document.getElementById('customDaysRow');

            // Toggle limit settings visibility
            limitEnabledCheckbox.addEventListener('change', function() {
                limitSettings.style.display = this.checked ? 'block' : 'none';
            });

            // Toggle custom days row visibility
            limitTypeSelect.addEventListener('change', function() {
                customDaysRow.style.display = this.value === 'custom_days' ? 'block' : 'none';
            });
        });
    </script>
    @endpush
@endsection 
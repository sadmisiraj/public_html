@extends('admin.layouts.app')
@section('page_title', __('Renew Laravel Nova Subscription'))
@section('content')
    <div class="content container-fluid" id="setting-section">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.dashboard') }}">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.security.index') }}">@lang('Security Settings')</a>
                            </li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.security.laravel-nova') }}">@lang('Laravel Nova Subscription')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Renew Subscription')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Renew Laravel Nova Subscription')</h1>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Current Subscription Status -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Current Subscription Status')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong>@lang('Status'):</strong>
                                    <span class="badge bg-{{ $subscription->status_color }} ms-2">{{ $subscription->status_text }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>@lang('Next Renewal'):</strong><br>
                                    <span class="text-muted">{{ $subscription->next_renewal_date->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong>@lang('Days Remaining'):</strong><br>
                                    @if($subscription->days_until_renewal > 0)
                                        <span class="text-success fs-5 fw-bold">{{ $subscription->days_until_renewal }}</span>
                                    @elseif($subscription->days_until_renewal == 0)
                                        <span class="text-warning fs-5 fw-bold">@lang('Today!')</span>
                                    @else
                                        <span class="text-danger fs-5 fw-bold">@lang('Expired')</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <strong>@lang('Monthly Price'):</strong><br>
                                    <span class="text-success fs-5 fw-bold">₹{{ number_format($subscription->monthly_price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Renewal Form -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Renew Subscription')</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>@lang('Important'):</strong> @lang('Enter your renewal code below to extend your subscription for one month. The subscription will be renewed from the current renewal date.')
                        </div>

                        <form action="{{ route('admin.security.laravel-nova.renew') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="renewal_code" class="form-label">@lang('Renewal Code') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg @error('renewal_code') is-invalid @enderror" 
                                       id="renewal_code" name="renewal_code" 
                                       placeholder="@lang('Enter your renewal code here')" 
                                       value="{{ old('renewal_code') }}" required>
                                @error('renewal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">@lang('Enter the renewal code provided to you for extending the subscription.')</div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="confirm_renewal" required>
                                                                    <label class="form-check-label" for="confirm_renewal">
                                    @lang('I confirm that I want to renew my Laravel Nova subscription for one month at ₹:price/month', ['price' => number_format($subscription->monthly_price, 2)])
                                </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('admin.security.laravel-nova') }}" class="btn btn-secondary me-md-2">
                                    <i class="bi bi-arrow-left"></i> @lang('Cancel')
                                </a>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-arrow-clockwise"></i> @lang('Renew Subscription')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Renewal Information -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Renewal Information')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>@lang('What happens after renewal?')</h6>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-check-circle text-success me-2"></i>@lang('Subscription extended by 1 month')</li>
                                    <li><i class="bi bi-check-circle text-success me-2"></i>@lang('Next renewal date updated')</li>
                                    <li><i class="bi bi-check-circle text-success me-2"></i>@lang('Status set to active')</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>@lang('Renewal Details')</h6>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-info-circle text-info me-2"></i>@lang('Monthly billing cycle')</li>
                                    <li><i class="bi bi-info-circle text-info me-2"></i>@lang('Renewal on 15th of each month')</li>
                                    <li><i class="bi bi-info-circle text-info me-2"></i>@lang('Price: ₹:price/month', ['price' => number_format($subscription->monthly_price, 2)])</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

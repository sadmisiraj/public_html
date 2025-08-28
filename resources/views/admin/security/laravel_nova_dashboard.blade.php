@extends('admin.layouts.app')
@section('page_title', __('Laravel Nova Subscription Dashboard'))
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
                            <li class="breadcrumb-item active" aria-current="page">@lang('Laravel Nova Subscription')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Laravel Nova Subscription Dashboard')</h1>
                </div>
                <div class="col-sm-auto">
                    <a href="{{ route('admin.security.laravel-nova.renewal') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-clockwise"></i> @lang('Renew Subscription')
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Subscription Status Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-shield-check text-{{ $subscription->status_color }}" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">@lang('Subscription Status')</h5>
                        <span class="badge bg-{{ $subscription->status_color }} fs-6">{{ $subscription->status_text }}</span>
                        <p class="card-text mt-2">
                            @if($subscription->isActive())
                                @lang('Your subscription is active and working properly')
                            @elseif($subscription->isExpired())
                                @lang('Your subscription has expired. Please renew to continue.')
                            @else
                                @lang('Your subscription is cancelled')
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Renewal Countdown Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-calendar-event text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">@lang('Next Renewal')</h5>
                        <div class="mb-2">
                            <span class="fs-4 fw-bold text-primary">{{ $subscription->next_renewal_date->format('M d, Y') }}</span>
                        </div>
                        <p class="card-text">
                            @if($subscription->days_until_renewal > 0)
                                <span class="text-success">@lang(':days days remaining', ['days' => $subscription->days_until_renewal])</span>
                            @elseif($subscription->days_until_renewal == 0)
                                <span class="text-warning">@lang('Renews today!')</span>
                            @else
                                <span class="text-danger">@lang('Expired :days days ago', ['days' => abs($subscription->days_until_renewal)])</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Pricing Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-currency-dollar text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">@lang('Monthly Pricing')</h5>
                        <div class="mb-2">
                            <span class="fs-2 fw-bold text-success">₹{{ number_format($subscription->monthly_price, 2) }}</span>
                            <span class="text-muted">@lang('/month')</span>
                        </div>
                        <p class="card-text">@lang('Billed monthly on the 15th of each month')</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Subscription History Card -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Subscription History')</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>@lang('Start Date'):</strong><br>
                            <span class="text-muted">{{ $subscription->start_date->format('M d, Y') }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>@lang('Last Renewed'):</strong><br>
                            <span class="text-muted">
                                @if($subscription->last_renewed_date)
                                    {{ $subscription->last_renewed_date->format('M d, Y') }}
                                @else
                                    @lang('Not renewed yet')
                                @endif
                            </span>
                        </div>
                        <div class="mb-3">
                            <strong>@lang('Last Renewal Code'):</strong><br>
                            <span class="text-muted">
                                @if($subscription->renewal_code)
                                    <code>{{ $subscription->renewal_code }}</code>
                                @else
                                    @lang('No code used')
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription Information Card -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Subscription Information')</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>@lang('Plan Name'):</strong><br>
                            <span class="text-muted">{{ $subscription->subscription_name }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>@lang('Monthly Price'):</strong><br>
                            <span class="text-success fw-bold">₹{{ number_format($subscription->monthly_price, 2) }}</span>
                        </div>
                        @if($subscription->notes)
                        <div class="mb-3">
                            <strong>@lang('Notes'):</strong><br>
                            <span class="text-muted">{{ $subscription->notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Quick Actions')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('admin.security.laravel-nova.renewal') }}" class="btn btn-success w-100">
                                    <i class="bi bi-arrow-clockwise"></i> @lang('Renew Subscription')
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('admin.security.index') }}" class="btn btn-secondary w-100">
                                    <i class="bi bi-arrow-left"></i> @lang('Back to Security')
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-info w-100">
                                    <i class="bi bi-house"></i> @lang('Go to Dashboard')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')
@section('page_title', __('Security Settings'))
@section('content')
    <div class="content container-fluid" id="setting-section">
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
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="d-flex flex-row p-4 gap-4 justify-items-center">
                        <span class="card-icon">
                            <i class="text-primary bi bi-shield-lock"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <h5>@lang('Payout Settings')</h5>
                            <span>@lang('Configure security settings for user payouts')</span>
                            <span class="mt-1 link-text">
                                <a href="{{ route('admin.security.payout') }}">@lang('Change Setting')
                                    <i class="fa-sharp fa-light fa-chevron-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="d-flex flex-row p-4 gap-4 justify-items-center">
                        <span class="card-icon">
                            <i class="text-primary bi bi-cash-stack"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <h5>@lang('Money Transfer Settings')</h5>
                            <span>@lang('Configure security settings for money transfers')</span>
                            <span class="mt-1 link-text">
                                <a href="{{ route('admin.security.payout') }}">@lang('Change Setting')
                                    <i class="fa-sharp fa-light fa-chevron-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="d-flex flex-row p-4 gap-4 justify-items-center">
                        <span class="card-icon">
                            <i class="text-primary bi bi-image"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <h5>@lang('Dashboard Popup')</h5>
                            <span>@lang('Configure popup image shown to users when they first login')</span>
                            <span class="mt-1 link-text">
                                <a href="{{ route('admin.security.dashboard.popup') }}">@lang('Change Setting')
                                    <i class="fa-sharp fa-light fa-chevron-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="d-flex flex-row p-4 gap-4 justify-items-center">
                        <span class="card-icon">
                            <i class="text-primary bi bi-images"></i>
                        </span>
                        <div class="d-flex flex-column">
                            <h5>@lang('Offer Images')</h5>
                            <span>@lang('Manage offer images displayed in user dashboard')</span>
                            <span class="mt-1 link-text">
                                <a href="{{ route('admin.security.offer-images') }}">@lang('Manage Images')
                                    <i class="fa-sharp fa-light fa-chevron-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- This can be expanded later with more security settings -->
        </div>
    </div>
@endsection 
@extends('admin.layouts.app')
@section('page_title', __('Offer Images Settings'))
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
                            <li class="breadcrumb-item active" aria-current="page">@lang('Offer Images')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Offer Images Settings')</h1>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-3">@lang('Offer images are displayed in the user dashboard as a slider, replacing the Total Earnings tile. You can manage these images here.')</p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>@lang('Redirecting to Offer Images Management...')</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Redirect to offer images index page
        window.location.href = "{{ route('admin.offer-images.index') }}";
    </script>
@endsection 
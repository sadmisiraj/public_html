@extends(template().'layouts.user')
@section('title', trans($pageTitle))
@section('content')
<!-- Page title start -->
<div style="margin-top: 100px;">
    <div class="pagetitle">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="mb-1">@lang('Purchase Gold')</h3>
            <a href="{{ route('user.goldcoin.orders') }}" class="btn cmn-btn">
                <i class="fa fa-history"></i> @lang('View My Orders')
            </a>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Dashboard')</a></li>
                <li class="breadcrumb-item active">@lang('Purchase Gold')</li>
            </ol>
        </nav>
    </div>
    <!-- Page title end -->

    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                        @if(isset($goldPurchaseLimitInfo) && $goldPurchaseLimitInfo['enabled'])
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-info-circle me-2"></i>
                                    <span>{{ $goldPurchaseLimitInfo['message'] }}</span>
                                </div>
                                @if($goldPurchaseLimitInfo['reset_date'])
                                    <div class="small text-muted mt-1">
                                        @lang('Resets on:') {{ showDateTime($goldPurchaseLimitInfo['reset_date']) }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    <div class="row g-4">
                        @forelse($coins as $coin)
                            <div class="col-lg-4 col-md-6">
                                <div class="card mb-4 h-100">
                                    <div class="card-header text-center">
                                        <h5 class="mb-0">{{ $coin->name }} ({{ $coin->karat }})</h5>
                                    </div>
                                    @if($coin->image)
                                        <div class="text-center mt-3">
                                            <img src="{{ $coin->getImageUrl() }}" alt="{{ $coin->name }}" class="img-fluid" style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-3">
                                            <span>@lang('Price Per Gram'):</span>
                                            <span class="fw-bold">{{ currencyPosition($coin->price_per_gram) }}</span>
                                        </div>
                                        @if(!is_null($coin->delivery_days) && (int)$coin->delivery_days > 0)
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>@lang('Expected Delivery'):</span>
                                                <span class="fw-bold">{{ showDateTime(\Carbon\Carbon::now()->addDays((int)$coin->delivery_days), 'd M, Y') }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($coin->description)
                                            <div class="mb-3">
                                                <p>{{ $coin->description }}</p>
                                            </div>
                                        @endif
                                        
                                        <div class="text-center mt-3">
                                            <a href="{{ route('user.goldcoin.details', $coin->id) }}" class="btn cmn-btn w-100">
                                                @lang('Purchase Now')
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4>@lang('No gold coins available for purchase at the moment')</h4>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
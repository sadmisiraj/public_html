@extends(template().'layouts.user')
@section('title', 'Badges')

@section('content')
    <section class="payment-gateway mt-5 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="header-text-full">
                        <h2>@lang('badges')</h2>
                    </div>
                </div>
            </div>
            @if($allBadges)
                <div class="badge-box-wrapper">
                    <div class="row g-4 mb-4">
                        @foreach($allBadges as $key => $badge)
                            <div class="col-xl-4 col-lg-4 col-md-6 box">
                                <div class="badge-box">
                                    <img src="{{ getFile($badge->driver,$badge->rank_icon) }}" alt="" />
                                    <h3>@lang($badge->rank_lavel)</h3>
                                    <p class="mb-3">@lang($badge->description)</p>
                                    <div class="text-start">
                                        <h5>@lang('Minimum Invest'): <span>{{ currencyPosition($badge->min_invest+0)}}</span></h5>
                                        <h5>@lang('Minimum Deposit'): <span>{{ currencyPosition($badge->min_deposit+0) }}</span></h5>
                                        <h5>@lang('Minimum Earning'): <span>{{ currencyPosition($badge->min_earning+0) }}</span></h5>
                                    </div>
                                    <div class="lock-icon">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection

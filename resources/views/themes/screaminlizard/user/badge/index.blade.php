@extends(template().'layouts.user')
@section('title', 'badges')

@section('content')

    <!-- main -->
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="header-text-full">
                    <h3 class="ms-2 mb-0 mt-2">{{trans('All Badges')}}</h3>
                </div>
            </div>
        </div>

        <section class="payment-gateway mt-4">
            <div class="container-fluid">
                <div class="row">
                    @if($allBadges)
                    @foreach($allBadges as $key => $badge)
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                            <div class="card-box badge-box-wrapper">
                                <div class="badge-box">
                                    <img src="{{ getFile($badge->driver,$badge->rank_icon) }}" alt="" />
                                    <h3>@lang($badge->rank_lavel)</h3>
                                    <p class="mb-3">@lang($badge->description)</p>
                                    <div class="text-start">
                                        <h5>@lang('Minimum Invest'): <span>{{ currencyPosition($badge->min_invest) }}</span></h5>
                                        <h5>@lang('Minimum Deposit'): <span>{{ currencyPosition($badge->min_deposit) }}</span></h5>
                                        <h5>@lang('Minimum Earning'): <span>{{ currencyPosition($badge->min_earning) }}</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <div class="text-center p-4">
                            <img class=" mb-3 w-25" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                            <p class="mb-0">@lang('No data to show')</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

@endsection

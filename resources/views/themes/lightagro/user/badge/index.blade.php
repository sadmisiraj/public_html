@extends(template().'layouts.user')
@section('title', trans('badges'))

@section('content')
    <div class="container-fluid">
        <div class="row main">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3"
                >
                    <h3 class="mb-0">@lang('All Badges')</h3>
                </div>
                @if($allBadges)
                    <div class="badge-box-wrapper">
                        <div class="row g-4 mb-4">
                            @foreach($allBadges as $key => $badge)
                                <div class="col-xl-4 col-lg-4 col-md-6 box">
                                    <div class="badge-box">
                                        <img src="{{ getFile($badge->driver,$badge->rank_icon) }}" alt="" />
                                        <h3>@lang(@$badge->rank_lavel)</h3>
                                        <p>@lang($badge->description)</p>
                                        <div class="text-start">
                                            <h5>@lang('Minimum Invest'): <span>{{ currencyPosition($badge->min_invest) }}</span></h5>
                                            <h5>@lang('Minimum Deposit'): <span>{{ currencyPosition($badge->min_deposit) }}</span></h5>
                                            <h5>@lang('Minimum Earning'): <span>{{ currencyPosition($badge->min_earning) }}</span></h5>
                                        </div>
                                        <div class="lock-icon">
                                            <i class="fa fa-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center p-4">
                        <img class=" mb-3 w-25" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                        <p class="mb-0">@lang('No data to show')</p>
                    </div>
                @endif



            </div>
        </div>
    </div>
@endsection

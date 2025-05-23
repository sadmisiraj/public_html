@extends(template().'layouts.user')
@section('title',trans('Badges'))
@section('content')
    @push('navigator')
        <!-- PAGE-NAVIGATOR -->
        <section id="page-navigator">
            <div class="container-fluid">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"
                                                       class="cursor-inherit">{{trans('Badges')}}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- /PAGE-NAVIGATOR -->
    @endpush

    <section id="dashboard">
        <div class="dashboard-wrapper add-fund pb-50">
            <div id="feature">
                <div class="row">
                    <div class="col-md-12">
                        <div class=" justify-content-between">
                            <h5 class="card-title mb-3">@lang('All Badges')</h5>
                        </div>
                        @if($allBadges)
                            <div class="badge-box-wrapper mb-4">
                                <div class="row g-4 mb-4">
                                    @foreach($allBadges as $key => $badge)
                                        <div class="col-xl-3 col-md-6 box">
                                            <div class="badge-box">
                                                <img src="{{ getFile($badge->driver,$badge->rank_icon) }}" alt="" />
                                                <h4 class="mb-2">@lang($badge->rank_lavel)</h4>
                                                <p class="mb-3">@lang($badge->description)</p>
                                                <div class="text-left">
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
                                <img class=" mb-3 w-25" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                <p class="mb-0">@lang('No data to show')</p>
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')

@endpush

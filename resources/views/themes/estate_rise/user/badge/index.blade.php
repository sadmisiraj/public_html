@extends(template().'layouts.user')
@section('title', 'badges')

@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Badges')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Badges')</li>
                </ol>
            </nav>
        </div>
    <div class="container-fluid">
        <div class="row main">
            <div class="col-12">
                @if($allBadges)
                    <div class="badge-box-wrapper">
                        <div class="row g-4 mb-4">
                            @foreach($allBadges as $key => $badge)
                                <div class="col-xl-4 col-lg-4 col-md-6 box">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="badge-box">
                                                <img src="{{ getFile($badge->driver,$badge->rank_icon) }}" alt="" />
                                                <h3>@lang(@$badge->rank_lavel)</h3>
                                                <p>@lang($badge->description)</p>
                                                <div class="text-start ">
                                                    <h5 class="d-flex justify-content-between">@lang('Minimum Purchase') <span>{{ currencyPosition($badge->min_invest) }}</span></h5>
                                                    <h5 class="d-flex justify-content-between">@lang('Minimum Deposit') <span>{{ currencyPosition($badge->min_deposit) }}</span></h5>
                                                    <h5 class="d-flex justify-content-between">@lang('Minimum Earning') <span>{{ currencyPosition($badge->min_earning) }}</span></h5>
                                                </div>
                                            </div>
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
    </div>
@endsection
@push('style')
    <style>
         .badge-box {
            background-color: var(--white);
            position: relative;
            border-radius: 10px;
            padding: 30px;
            z-index: 1;
            text-align: center;
        }
    </style>
@endpush

@extends(template().'layouts.user')
@section('title',trans('Dashboard'))
@section('content')

    @php
        $content = getContent();
        use App\Models\Announcement;
        $today = date('Y-m-d');
        $announcements = Announcement::where('status', 'active')
            ->where(function($q) use ($today) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $today);
            })
            ->where(function($q) use ($today) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $today);
            })
            ->pluck('text');
    @endphp
    <div class="main-wrapper">
        <!-- Page title start -->
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Dashboard')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Dashboard')</li>
                </ol>
            </nav>
        </div>
        <div class="profile-content">
                         
                          <h4>user<span>{{'@'.auth()->user()->username}}</span></h4> 
                        </div>
        <!-- Page title end -->
        <div class="dashboard-top">
            <div class="row g-4 align-items-center">
                <div class="col-lg-4">
                    <div class="text-box text-center text-lg-start">
                        <div
                            class="d-flex align-items-center gap-3 justify-content-center justify-content-lg-start">
                            <h2 class="title mb-1">@lang('Hi'), {{auth()->user()->fullname}}!</h2>
                            <div class="icon-box">
                                <i class="fa-regular fa-money-bill"></i>
                            </div>
                        </div>
                        <h2 class="title mb-1">
                            {!! styleSentence($content['single']['heading']??'',5) !!}
                        </h2>
                        <h5 class="sub-title ">
                            {!! $content['single']['sub_heading']??'' !!}
                        </h5>
                    </div>
                </div>
                <div class="col-lg-8">
                    @if($announcements->count())
                        <div class="mb-3">
                            <marquee behavior="scroll" direction="left" style="background: #fffbe6; color: #b38b00; padding: 10px; border-radius: 5px; font-weight: bold;">
                                {{ $announcements->implode(' | ') }}
                            </marquee>
                        </div>
                    @endif
                    <div class="desktop-view-card-section">
                        <div class="grid-container">
                            <div class="item">
                                <div class="deposit-invest-box">
                                    <div class="img-box">
                                        <img src="{{asset(template(true).'img/box-card/market-analysis-31.png')}}" alt="icon">
                                    </div>
                                    <div class="text-box">
                                        <a href="{{route('user.plan')}}" class="cmn-btn"><i class="fa-regular fa-usd-circle"></i>
                                            @lang('Purchase')</a>
                                        <a href="{{route('user.addFund')}}" class="cmn-btn"><i class="fa-regular fa-wallet"></i>
                                            @lang('Deposit')</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="box-card2">
                                    <div class="img-box">
                                        <img src="{{asset(template(true).'img/box-card/bitcoin-46.png')}}" alt="icon">
                                    </div>
                                    <div class="text-box">
                                        <h4 class="title mb-0">{{currencyPosition(auth()->user()->balance+0)}}</h4>
                                        <p class="mb-0">@lang('Deposit Balance')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="box-card2">
                                    <div class="img-box">
                                        <img src="{{asset(template(true).'img/box-card/money-50.png')}}" alt="icon">
                                    </div>
                                    <div class="text-box">
                                        <h5 class="mb-0">{{currencyPosition(auth()->user()->profit_balance+0)}}</h5>
                                        <p class="mtitle b-0">@lang('Performance Balance')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="box-card2">
                                    <div class="img-box">
                                        <img src="{{asset(template(true).'img/box-card/money-50.png')}}" alt="icon">
                                    </div>
                                    <div class="text-box">
                                        <h5 class="mb-0">{{currencyPosition(auth()->user()->interest_balance+0)}}</h5>
                                        <p class="mtitle b-0">@lang('Profit Balance')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="box-card2">
                                    <div class="img-box">
                                        <img src="{{asset(template(true).'img/box-card/money-jar-54.png')}}" alt="icon">
                                    </div>
                                    <div class="text-box">
                                        <h5 class="title mb-0">{{currencyPosition($totalDeposit+0)}} </h5>
                                        <p class="mb-0">@lang('Total Deposit')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="box-card2">
                                    <div class="img-box">
                                        <img src="{{asset(template(true).'img/box-card/money-motivation-90.png')}}" alt="icon">
                                    </div>
                                    <div class="text-box">
                                        <h5 class="title mb-0">{{currencyPosition($totalEarnings+0)}} </h5>
                                        <p class="mb-0">@lang('Total Earnings')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab mobile view carousel start -->
                    <div class="tab-mobile-view-carousel-section">
                        <div class="row">
                            <div class="col-12">
                                <div class="owl-carousel owl-theme carousel-1">
                                    <div class="item">
                                        <div class="deposit-invest-box">
                                            <div class="img-box">
                                                <img src="{{asset(template(true).'img/box-card/market-analysis-31.png')}}" alt="icon">
                                            </div>
                                            <div class="text-box">
                                                <a href="{{route('user.plan')}}" class="cmn-btn"><i
                                                        class="fa-regular fa-usd-circle"></i>
                                                    @lang('Purchase')</a>
                                                <a href="{{route('user.addFund')}}" class="cmn-btn"><i class="fa-regular fa-wallet"></i>
                                                    @lang('Deposit')</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="box-card2">
                                            <div class="img-box">
                                                <img src="{{asset(template(true).'img/box-card/bitcoin-46.png')}}" alt="icon">
                                            </div>
                                            <div class="text-box">
                                                <h4 class="title mb-0">{{currencyPosition(auth()->user()->balance+0)}}</h4>
                                                <p class="mb-0">@lang('Deposit Balance')</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="box-card2">
                                            <div class="img-box">
                                                <img src="{{asset(template(true).'img/box-card/money-50.png')}}" alt="interest balance icon image">
                                            </div>
                                            <div class="text-box">
                                                <h5 class="title mb-0">{{currencyPosition(auth()->user()->profit_balance+0)}}</h5>
                                                <p class="mb-0">@lang('Performance Balance')</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="box-card2">
                                            <div class="img-box">
                                                <img src="{{asset(template(true).'img/box-card/money-50.png')}}" alt="interest balance icon image">
                                            </div>
                                            <div class="text-box">
                                                <h5 class="title mb-0">{{currencyPosition(auth()->user()->interest_balance+0)}}</h5>
                                                <p class="mb-0">@lang('Profit Balance')</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="box-card2">
                                            <div class="img-box">
                                                <img src="{{asset(template(true).'img/box-card/savings-76.png')}}" alt="icon">
                                            </div>
                                            <div class="text-box">
                                                <h5 class="title mb-0">{{currencyPosition($totalDeposit+0)}} </h5>
                                                <p class="mb-0">@lang('Total Deposit')</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="box-card2">
                                            <div class="img-box">
                                                <img src="{{asset(template(true).'img/box-card/money-motivation-90.png')}}" alt="">
                                            </div>
                                            <div class="text-box">
                                                <h5 class="title mb-0">{{currencyPosition($totalEarnings+0)}} </h5>
                                                <p class="mb-0">@lang('Total Earnings')</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tab mobile view carousel end -->
                </div>
            </div>
        </div>




        <div class="mt-30">
            <div class="row g-4">
                <div class="col-lg-8">
                    <!-- Dashboard card start -->
                    <div>
                        <div class="row g-4 justify-content-center">
                            <div class="col-xxl-4 col-sm-6">
                                <div class="box-card box-card-color1">
                                    <div class="box-card-header">
                                        <div class="progress-box">
                                            <div class="first circle">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="text-box">
                                            <p class="sub-title">{{ isset($configs[0]) ? $configs[0]->display_name : 'Config 1' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-sm-6">
                                <div class="box-card box-card-color1">
                                    <div class="box-card-header">
                                        <div class="progress-box">
                                            <div class="second circle">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="text-box">
                                            <p class="sub-title">{{ isset($configs[1]) ? $configs[1]->display_name : 'Config 2' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-sm-6">
                                <div class="box-card box-card-color1">
                                    <div class="box-card-header">
                                        <div class="progress-box">
                                            <div class="third circle">
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="text-box">
                                            <p class="sub-title">{{ isset($configs[2]) ? $configs[2]->display_name : 'Config 3' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dashboard card end -->
                    <div class="card mt-25">
                        <div class="card-header pb-0 border-0">
                            <h4 class="mb-0">@lang('To do list')</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="box-card3">
                                        <div class="icon-box">
                                            <i class="fa-regular fa-funnel-dollar"></i>
                                        </div>

                                        <div class="text-box">
                                            <h5 class="title">{{currencyPosition($roi['totalInvestAmount']+0)}}</h5>
                                            <h6>@lang('Total Purchase')</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box-card3">
                                        <div class="icon-box">
                                            <i class="fa-regular fa-usd-circle"></i>
                                        </div>

                                        <div class="text-box">
                                            <h5 class="title">{{currencyPosition($totalPayout+0)}}</h5>
                                            <h6>@lang('Total Payout')</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box-card3">
                                        <div class="icon-box">
                                            <i class="fa-regular fa-lightbulb-dollar"></i>
                                        </div>

                                        <div class="text-box">
                                            <h5 class="title">{{currencyPosition($totalBonus+0)}}</h5>
                                            <h6>@lang('TRB')</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box-card3">
                                        <div class="icon-box">
                                            <i class="fa-regular fa-ticket"></i>
                                        </div>

                                        <div class="text-box">
                                            <h5 class="title">{{$ticket}}</h5>
                                            <h6>@lang('Total Ticket')</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card mt-25">
                        <div class="card-body">
                            <div class="card h-100">
                                <div class="card-body p-1">
                                    <div id="columnChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-lg-4">
                    <div class="row g-4">
                        <div class="col-lg-12 col-md-6">
                            <div id="datepicker" class=" h-100"></div>
                        </div>


                        @php
                            $user = auth()->user();
                            $user_rankings = getRanking();
                        @endphp
                        <div class="col-lg-12 col-md-6">
                            <div class="row g-4">
                                @if($user->last_lavel != null && $user_rankings)
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="box-card3">
                                                    <div class="icon-box">
                                                        <i class="fa-regular fa-box-open"></i>
                                                    </div>

                                                    <div class="text-box">
                                                        <h5 class="title">@lang(@$user_rankings->rank_name)</h5>
                                                        <h6>@lang(@$user_rankings->rank_lavel)</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="box-card3">
                                                <div class="icon-box">
                                                    <i class="fa-solid fa-sack-dollar"></i>
                                                </div>

                                                <div class="text-box">
                                                    <h5 class="title">{{currencyPosition($totalTeamInvest+0)}}</h5>
                                                    <h6>@lang('TRT')</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="box-card3">
                                        <div class="icon-box">
                                            <i class="fa-regular fa-handshake"></i>
                                        </div>

                                        <div class="text-box">
                                            <h6>{{currencyPosition($lastPayout)}}</h6>
                                            <h5 class="title">@lang('Last Payout')</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <h4 class="mb-20">Referral Link</h4> -->
                                    <h5 class="mb-3">@lang('TC LINKS')</h5>
                                    <div class="mb-3">
                                        <label class="form-label">@lang('ALPHA')</label>
                                        <div class="input-group">
                                            <input id="leftReferralURL" type="text" class="form-control"
                                                   value="{{route('register.sponsor',[Auth::user()->username, 'left'])}}"
                                                   aria-label="Left referral link" aria-describedby="copy-left-btn"
                                                   readonly>
                                            <div class="input-group-text" id="copyLeftBtn"><i
                                                    class="fa-regular fa-copy"></i>@lang('copy')
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label">@lang('BETA')</label>
                                        <div class="input-group">
                                            <input id="rightReferralURL" type="text" class="form-control"
                                                   value="{{route('register.sponsor',[Auth::user()->username, 'right'])}}"
                                                   aria-label="Right referral link" aria-describedby="copy-right-btn"
                                                   readonly>
                                            <div class="input-group-text" id="copyRightBtn"><i
                                                    class="fa-regular fa-copy"></i>@lang('copy')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <style>
        /* Ensure text is centered in the circle */
        .circle {
            position: relative;
        }
        .circle span {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
            font-weight: 500;
        }
        /* Special styling for percentage values */
        .circle span.percent i {
            font-style: normal;
            font-size: 10px;
        }
    </style>
    <script>
        $(document).ready(function (){
            // Circle progress start
            @php
                // Get configs
                $config1Raw = isset($configs[0]) ? $configs[0]->value : '0';
                $config2Raw = isset($configs[1]) ? $configs[1]->value : '0';
                $config3Raw = isset($configs[2]) ? $configs[2]->value : '0';
                
                // Check if values end with % to determine if they're percentages
                $isConfig1Percent = str_ends_with($config1Raw, '%');
                $isConfig2Percent = str_ends_with($config2Raw, '%');
                $isConfig3Percent = str_ends_with($config3Raw, '%');
                
                // Strip % for percentage values and convert to integer
                $config1Value = $isConfig1Percent ? (int)str_replace('%', '', $config1Raw) : $config1Raw;
                $config2Value = $isConfig2Percent ? (int)str_replace('%', '', $config2Raw) : $config2Raw;
                $config3Value = $isConfig3Percent ? (int)str_replace('%', '', $config3Raw) : $config3Raw;
            @endphp

            if ($('.circle').length) {
                $('.first.circle').circleProgress({
                    value: {{ $isConfig1Percent ? $config1Value/100 : 0 }},
                    size: 70,
                    fill: {
                        gradient: ["#ae8656"]
                    }
                }).on('circle-animation-progress', function (event, progress) {
                    @if($isConfig1Percent)
                        $(this).find('span').html(Math.round({{ $config1Value }} * progress) + '<i>%</i>');
                    @else
                        $(this).find('span').html('{{ $config1Raw }}');
                        // Show empty ring for non-percentage values
                    @endif
                    $(this).find('span').addClass('percent');
                });
            }

            if ($('.circle').length) {
                $('.second.circle').circleProgress({
                    value: {{ $isConfig2Percent ? $config2Value/100 : 0 }},
                    size: 70,
                    fill: {
                        gradient: ["#ae8656"]
                    }
                }).on('circle-animation-progress', function (event, progress) {
                    @if($isConfig2Percent)
                        $(this).find('span').html(Math.round({{ $config2Value }} * progress) + '<i>%</i>');
                    @else
                        $(this).find('span').html('{{ $config2Raw }}');
                        // Show empty ring for non-percentage values
                    @endif
                    $(this).find('span').addClass('percent');
                });
            }

            if ($('.circle').length) {
                $('.third.circle').circleProgress({
                    value: {{ $isConfig3Percent ? $config3Value/100 : 0 }},
                    size: 70,
                    fill: {
                        gradient: ["#ae8656"]
                    }
                }).on('circle-animation-progress', function (event, progress) {
                    @if($isConfig3Percent)
                        $(this).find('span').html(Math.round({{ $config3Value }} * progress) + '<i>%</i>');
                    @else
                        $(this).find('span').html('{{ $config3Raw }}');
                        // Show empty ring for non-percentage values
                    @endif
                    $(this).find('span').addClass('percent');
                });
            }

            // Circle progress end

            if ($('#columnChart').length) {
                var options = {
                    series: [{
                        name: 'Purchase',
                        color: '#567eae',
                        data: {!! $monthly['investment']->flatten() !!}
                    }, {
                        name: 'Payout',
                        color: 'rgb(174,134,86)',
                        data: {!! $monthly['payout']->flatten() !!}
                    },
                        {
                            name: 'Deposit',
                            color: '#5a56ae',
                            data: {!! $monthly['funding']->flatten() !!}
                        },
                        {
                            name: 'Deposit Bonus',
                            color: '#e7bb89',
                            data: {!! $monthly['referralFundBonus']->flatten() !!}
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],

                    },

                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "{{basicControl()->currency_symbol}}" + val
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#columnChart"), options);
                chart.render();

            }
        })

        document.getElementById("copyLeftBtn").addEventListener("click", () => {
            let leftReferralURL = document.getElementById("leftReferralURL");
            leftReferralURL.select();
            navigator.clipboard.writeText(leftReferralURL.value)
            if (leftReferralURL.value) {
                document.getElementById("copyLeftBtn").innerHTML = '<i class="fa-regular fa-circle-check"></i>'+"{{trans('Copied')}}";
                setTimeout(() => {
                    document.getElementById("copyLeftBtn").innerHTML = '<i class="fa-regular fa-copy"></i>'+"{{trans('copy')}}";
                }, 1000)
            }
        })

        document.getElementById("copyRightBtn").addEventListener("click", () => {
            let rightReferralURL = document.getElementById("rightReferralURL");
            rightReferralURL.select();
            navigator.clipboard.writeText(rightReferralURL.value)
            if (rightReferralURL.value) {
                document.getElementById("copyRightBtn").innerHTML = '<i class="fa-regular fa-circle-check"></i>'+"{{trans('Copied')}}";
                setTimeout(() => {
                    document.getElementById("copyRightBtn").innerHTML = '<i class="fa-regular fa-copy"></i>'+"{{trans('copy')}}";
                }, 1000)
            }
        })
    </script>
@endpush

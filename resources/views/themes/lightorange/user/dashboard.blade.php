@extends(template().'layouts.user')
@section('title',trans('Dashboard'))
@section('content')

    @push('navigator')
        <!-- PAGE-NAVIGATOR -->
        <section id="page-navigator">
            <div class="container-fluid">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"
                                                       class="cursor-inherit">{{trans('Dashboard')}}</a></li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- /PAGE-NAVIGATOR -->
    @endpush


    <!-- DASHBOARD -->
    <section id="dashboard">
        <div class="dashboard-wrapper wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.35s">
            <div class="audit-information">
                <div class="row" id="firebase-app">
                    <div class="col-12" v-if="notificationPermission == 'default' && !is_notification_skipped" v-cloak>
                        <div class="bd-callout bd-callout-primary alert d-flex justify-content-between align-items-start" role="alert">
                            <div class="d-flex align-items-center">
                                @lang('Do not miss any single important notification! Allow your browser to get instant push notification.')

                                <button class="btn btn-sm btn-primary mx-3" id="allow-notification">@lang('Allow me')</button>
                            </div>
                            <button class="close-btn pt-1 " @click.prevent="skipNotification"><i class="text-white fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-12" v-if="notificationPermission == 'denied' && !is_notification_skipped" v-cloak>
                        <div class="bd-callout bd-callout-warning alert d-flex justify-content-between align-items-start" role="alert">
                            <div class="d-flex align-items-center">
                                @lang(' Please allow your browser to get instant push notification. Allow it from notification setting.')
                            </div>
                            <button class="close-btn pt-1 " @click.prevent="skipNotification"><i class="text-white fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="content-wrapper">
                            <div class="content-container">
                                <div class="content-main-block d-flex h-fill">
                                    <div class="content-icon flex-fill">
                                        <img src="{{asset(template(true).'images/icon/dashboard_1.png')}}"
                                             alt="Icon Missing">
                                    </div>
                                    <div class="content-block flex-fill d-flex flex-column justify-content-center">
                                        <h6 class="h6 font-weight-medium">@lang('Main Balance')</h6>
                                        <h4 class="h4 mt-10">
                                            {{currencyPosition($walletBalance+0)}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="content-wrapper">
                            <div class="content-container">
                                <div class="content-main-block d-flex h-fill">
                                    <div class="content-icon flex-fill">
                                        <img src="{{asset(template(true).'images/icon/dashboard_2.png')}}"
                                             alt="Icon Missing">
                                    </div>
                                    <div class="content-block flex-fill d-flex flex-column justify-content-center">
                                        <h6 class="h6 font-weight-medium">@lang('Interest Balance')</h6>
                                        <h4 class="h4 mt-10">
                                            {{currencyPosition($interestBalance+0)}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="content-wrapper">
                            <div class="content-container">
                                <div class="content-main-block d-flex h-fill">
                                    <div class="content-icon flex-fill">
                                        <img src="{{asset(template(true).'images/icon/dashboard_3.png')}}"
                                             alt="Icon Missing">
                                    </div>
                                    <div class="content-block flex-fill d-flex flex-column justify-content-center">
                                        <h6 class="h6 font-weight-medium">@lang('Total Deposit')</h6>
                                        <h4 class="h4 mt-10">
                                            {{currencyPosition($totalDeposit+0)}}
                                        </h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="content-wrapper">
                            <div class="content-container">
                                <div class="content-main-block d-flex h-fill">
                                    <div class="content-icon flex-fill">
                                        <img src="{{asset(template(true).'images/icon/dashboard_4.png')}}"
                                             alt="Icon Missing">
                                    </div>
                                    <div class="content-block flex-fill d-flex flex-column justify-content-center">
                                        <h6 class="h6 font-weight-medium">@lang('Total Earn')</h6>
                                        <h4 class="h4 mt-10">
                                            {{currencyPosition($totalInterestProfit+0)}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chart-information mt-50 mb-50">
                <div class="row">
                    <div class="col-xl-6">
                        <div id="container" class="apexcharts-canvas"></div>
                    </div>

                    <div class="col-xl-6">
                        <div class="progress-wrapper">
                            <div class="progress-container d-flex flex-column flex-sm-row justify-content-start">

                                <div class="circular-progress cp_1">
                                    <svg class="radial-progress"
                                         data-percentage="{{getPercent($roi['totalInvest'], $roi['completed'])}}"
                                         viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35"
                                                style="stroke-dashoffset: 39.58406743523136;"></circle>
                                        <text class="percentage" x="50%" y="53%"
                                              transform="matrix(0, 1, -1, 0, 80, 0)">{{getPercent($roi['totalInvest'], $roi['completed'])}}
                                            %
                                        </text>
                                    </svg>
                                    <h6 class="h6 text-center">@lang('Invest Completed')</h6>
                                </div>


                                <div class="circular-progress cp_3">
                                    <svg class="radial-progress"
                                         data-percentage="{{100 - getPercent($roi['expectedProfit'], $roi['returnProfit'])}}"
                                         viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35"
                                                style="stroke-dashoffset: 39.58406743523136;"></circle>
                                        <text class="percentage" x="50%" y="53%"
                                              transform="matrix(0, 1, -1, 0, 80, 0)">{{100 - getPercent($roi['expectedProfit'], $roi['returnProfit'])}}
                                            %
                                        </text>
                                    </svg>

                                    <h6 class="h6 text-center">@lang('ROI Speed')</h6>
                                </div>

                                <div class="circular-progress cp_2">
                                    <svg class="radial-progress"
                                         data-percentage="{{getPercent($roi['expectedProfit'], $roi['returnProfit'])}}"
                                         viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35"
                                                style="stroke-dashoffset: 147.3406954533613;"></circle>
                                        <text class="percentage" x="50%" y="53%"
                                              transform="matrix(0, 1, -1, 0, 80, 0)">{{getPercent($roi['expectedProfit'], $roi['returnProfit'])}}
                                            %
                                        </text>
                                    </svg>

                                    <h6 class="h6 text-center">@lang('ROI Redeemed')</h6>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="h4 text-center mt-50 mb-50">@lang('Account Statistics')</h4>
            <div class="balance-information">
                <div class="row">
                    <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="content-wrapper">
                            <div class="content-container">
                                <div class="d-flex flex-column align-items-center h-fill">
                                    <div class="content-icon flex-fill">
                                        <img src="{{asset(template(true).'images/icon/dashboard_acc_1.png')}}"
                                             alt="Icon Missing">
                                    </div>
                                    <div
                                        class="content-block flex-fill d-flex flex-column justify-content-center text-center">
                                        <h6 class="h6 mt-15 mb-15 font-weight-medium">@lang('Total Invest')</h6>
                                        <h4 class="h4">
                                            {{currencyPosition($roi['totalInvestAmount']+0)}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="content-wrapper">
                            <div class="content-container">
                                <div class="d-flex flex-column align-items-center h-fill">
                                    <div class="content-icon flex-fill">
                                        <img src="{{asset(template(true).'images/icon/dashboard_acc_2.png')}}"
                                             alt="Icon Missing">
                                    </div>
                                    <div
                                        class="content-block flex-fill d-flex flex-column justify-content-center text-center">
                                        <h6 class="h6 mt-15 mb-15 font-weight-medium">@lang('Total Payout')</h6>
                                        <h4 class="h4">
                                            {{currencyPosition($totalPayout+0)}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="content-wrapper">
                            <div class="content-container">
                                <div class="d-flex flex-column align-items-center h-fill">
                                    <div class="content-icon flex-fill">
                                        <img src="{{asset(template(true).'images/icon/dashboard_acc_1.png')}}"
                                             alt="Icon Missing">
                                    </div>
                                    <div
                                        class="content-block flex-fill d-flex flex-column justify-content-center text-center">
                                        <h6 class="h6 mt-15 mb-15 font-weight-medium">@lang('Team Investment')</h6>
                                        <h4 class="h4">{{currencyPosition($totalTeamInvest+0)}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="content-wrapper">
                            <div class="content-container">
                                <div class="d-flex flex-column align-items-center h-fill">
                                    <div class="content-icon flex-fill">
                                        <img src="{{asset(template(true).'images/icon/dashboard_acc_4.png')}}"
                                             alt="Icon Missing">
                                    </div>
                                    <div
                                        class="content-block flex-fill d-flex flex-column justify-content-center text-center">
                                        <h6 class="h6 mt-15 mb-15 font-weight-medium">@lang('Total Referral Bonus')</h6>

                                        <h4 class="h4">
                                            {{currencyPosition($totalBonus+0)}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="refferal-information mt-50 mb-50">

                <div class="row mb-50">
                    <div class="col-xl-{{($latestRegisteredUser) ? '12':'6'}}">
                        <div class="form-group form-block mb-50 pr-15 pl-15">
                            <h5 class="mb-15">@lang('Referral Link')</h5>
                            <div class="input-group mb-50">
                                <input type="text" value="{{route('register.sponsor',[Auth::user()->username])}}"
                                       class="form-control form-control-lg bg-transparent" id="sponsorURL"
                                       readonly>
                                <div class="input-group-append">
                                            <span class="input-group-text copytext" id="copyBoard"
                                                  onclick="copyFunction()">
                                                <i class="fa fa-copy"></i>
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($latestRegisteredUser)
                        <div class="col-md-6 col-lg-6 col-xl-6">
                            <div class="content-wrapper bg-5">
                                <div class="img-container d-none d-sm-block">
                                    <img class="img-fill" src="{{asset(template(true).'images/shapes/shape-img-3.png')}}"
                                         alt="Shape Image">
                                </div>
                                <div class="content-container d-flex">
                                    <div class="media align-items-center">
                                        <div class="content-icon">
                                            <img src="{{asset(template(true).'images/icon/dashboard_ref_1.png')}}"
                                                 alt="Icon Missing">
                                        </div>
                                        <div class="media-body ml-20">
                                            <h5 class="mb-15">@lang('Latest Registered Partner')</h5>
                                            <h6>{{$latestRegisteredUser->username}} <span class="pl-2">@lang('Email')
                                                    : {{$latestRegisteredUser->email}}</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-6 col-lg-6 col-xl-6">
                        <div class="content-wrapper bg-5">
                            <div class="img-container d-none d-sm-block">
                                <img class="img-fill" src="{{asset(template(true).'images/shapes/shape-img-3.png')}}"
                                     alt="Shape Image">
                            </div>
                            <div class="content-container d-flex">
                                <div class="media align-items-center">
                                    <div class="content-icon">
                                        <img src="{{asset(template(true).'images/icon/dashboard_ref_2.png')}}"
                                             alt="Icon Missing">
                                    </div>
                                    <div class="media-body ml-20">
                                        <h5 class="mb-15">@lang('The last Referral Bonus')</h5>
                                        <h6 class="text-uppercase">
                                            {{currencyPosition($lastBonus+0)}}</h6>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </section>
    <!-- /DASHBOARD -->
@endsection

@push('script')
    <script src="{{asset(template(true).'js/apexcharts.js')}}"></script>

    <script>
        function copyFunction() {
            var copyText = document.getElementById("sponsorURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.success(`Copied: ${copyText.value}`);
        }

        $(document).ready(function (){
            var options = {
                series: [
                    {
                        name: "{{trans('Investment')}}",
                        color: 'rgba(247, 147, 26, 1)',
                        data: {!! $monthly['investment']->flatten() !!}
                    },
                    {
                        name: "{{trans('Payout')}}",
                        color: 'rgba(240, 16, 16, 1)',
                        data: {!! $monthly['payout']->flatten() !!}
                    },
                    {
                        name: "{{trans('Deposit')}}",
                        color: 'rgba(255, 72, 0, 1)',
                        data: {!! $monthly['funding']->flatten() !!}
                    },
                    {
                        name: "{{trans('Deposit Bonus')}}",
                        color: 'rgba(39, 144, 195, 1)',
                        data: {!! $monthly['referralFundBonus']->flatten() !!}
                    },
                    {
                        name: "{{trans('Investment Bonus')}}",
                        color: 'rgba(136, 203, 245, 1)',
                        data: {!! $monthly['referralInvestBonus']->flatten() !!}
                    }
                ],
                legend: {
                    labels: {
                        colors: ['#FFFFFF'], // Change colors for each series name
                        useSeriesColors: false // Make sure series colors aren't applied to the legend
                    }
                },
                chart: {
                    type: 'bar',
                    height: 410,
                    toolbar: {
                        show: false,

                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '50%', // Adjusted for equal spacing
                        borderRadius: 5,
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
                    categories: {!! $monthly['investment']->keys() !!},
                    labels: {
                        style: {
                            colors: '#FFFFFF'  // Set the same color for all category labels
                        }
                    }
                },

                yaxis: {
                    labels: {
                        style: {
                            colors: '#FFFFFF'  // Set the same color for all category labels
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "{{trans(basicControl()->currency_symbol)}}"+' ' + val + ""
                        }
                    },
                    theme: 'dark',
                },
                colors: ['#ff6600', '#fb8e09'],
            };
            var chart = new ApexCharts(document.querySelector("#container"), options);
            chart.render();

        })
    </script>
@endpush

@if($firebaseNotify)
    @push('script')
        <script type="module">

            import {initializeApp} from "https://www.gstatic.com/firebasejs/9.17.1/firebase-app.js";
            import {
                getMessaging,
                getToken,
                onMessage
            } from "https://www.gstatic.com/firebasejs/9.17.1/firebase-messaging.js";

            const firebaseConfig = {
                apiKey: "{{$firebaseNotify['apiKey']}}",
                authDomain: "{{$firebaseNotify['authDomain']}}",
                projectId: "{{$firebaseNotify['projectId']}}",
                storageBucket: "{{$firebaseNotify['storageBucket']}}",
                messagingSenderId: "{{$firebaseNotify['messagingSenderId']}}",
                appId: "{{$firebaseNotify['appId']}}",
                measurementId: "{{$firebaseNotify['measurementId']}}"
            };

            const app = initializeApp(firebaseConfig);
            const messaging = getMessaging(app);
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('{{ getProjectDirectory() }}' + `/firebase-messaging-sw.js`, {scope: './'}).then(function (registration) {
                        requestPermissionAndGenerateToken(registration);
                    }
                ).catch(function (error) {
                });
            } else {
            }

            onMessage(messaging, (payload) => {
                if (payload.data.foreground || parseInt(payload.data.foreground) == 1) {
                    const title = payload.notification.title;
                    const options = {
                        body: payload.notification.body,
                        icon: payload.notification.icon,
                    };
                    new Notification(title, options);
                }
            });

            function requestPermissionAndGenerateToken(registration) {
                document.addEventListener("click", function (event) {
                    if (event.target.id == 'allow-notification') {
                        Notification.requestPermission().then((permission) => {
                            if (permission === 'granted') {
                                getToken(messaging, {
                                    serviceWorkerRegistration: registration,
                                    vapidKey: "{{$firebaseNotify['vapidKey']}}"
                                })
                                    .then((token) => {
                                        $.ajax({
                                            url: "{{ route('user.save.token') }}",
                                            method: "post",
                                            data: {
                                                token: token,
                                            },
                                            success: function (res) {
                                            }
                                        });
                                        window.newApp.notificationPermission = 'granted';
                                    });
                            } else {
                                window.newApp.notificationPermission = 'denied';
                            }
                        });
                    }
                });
            }
        </script>
        <script>
            window.newApp = new Vue({
                el: "#firebase-app",
                data: {
                    user_foreground: '',
                    user_background: '',
                    notificationPermission: Notification.permission,
                    is_notification_skipped: sessionStorage.getItem('is_notification_skipped') == '1'
                },
                mounted() {
                    sessionStorage.clear();
                    this.user_foreground = "{{$firebaseNotify['user_foreground']}}";
                    this.user_background = "{{$firebaseNotify['user_background']}}";
                },
                methods: {
                    skipNotification() {
                        sessionStorage.setItem('is_notification_skipped', '1')
                        this.is_notification_skipped = true;
                    }
                }
            });
        </script>
    @endpush
@endif


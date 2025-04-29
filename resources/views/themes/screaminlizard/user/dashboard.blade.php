@extends(template().'layouts.user')
@section('title',trans('Dashboard'))
@section('content')
    <!-- main -->
    <div class="container-fluid">
        <div class="main row" id="firebase-app">


            <div class="col-12"
                 v-if="notificationPermission == 'default' && !is_notification_skipped" v-cloak
            >
                <div class="bd-callout bd-callout-primary alert d-flex justify-content-between align-items-start" role="alert">
                    <div class="d-flex align-items-center">
                        @lang('Do not miss any single important notification! Allow your browser to get instant push notification.')

                        <button class="btn btn-sm btn-primary mx-3" id="allow-notification">@lang('Allow me')</button>
                    </div>
                    <button class="close-btn pt-1 btn btn-dark" @click.prevent="skipNotification"><i class="text-white fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="col-12"
                 v-if="notificationPermission == 'denied' && !is_notification_skipped" v-cloak
            >
                <div class="bd-callout bd-callout-warning alert d-flex justify-content-between align-items-start" role="alert">
                    <div class="d-flex align-items-center">
                        @lang(' Please allow your browser to get instant push notification. Allow it from notification setting.')
                    </div>
                    <button class="close-btn pt-1 btn btn-dark" @click.prevent="skipNotification"><i class="text-white fas fa-times"></i>
                    </button>
                </div>
            </div>



            <div class="col-12">
                <div class="row g-4">
                    <!-- card boxes -->
                    <div class="col-12 d-none d-lg-block">
                        <div class="row g-4">
                            <div class="col-xl-3 col-lg-3 col-md-12">
                                <div class="card-box">
                                    <div class="d-flex justify-content-between">
                                        <h4>{{currencyPosition($walletBalance)}}</h4>
                                        <i class="fal fa-dollar-sign"></i>
                                    </div>
                                    <p class="mb-0">@lang('Main Balance')</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-12">
                                <div class="card-box">
                                    <div class="d-flex justify-content-between">
                                        <h4>{{currencyPosition($interestBalance)}}</h4>
                                        <i class="fal fa-hand-holding-usd"></i>
                                    </div>
                                    <p class="mb-0">@lang('Interest Balance')</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-12">
                                <div class="card-box">
                                    <div class="d-flex justify-content-between">
                                        <h4>{{currencyPosition($totalDeposit)}}</h4>
                                        <i class="fal fa-box-usd"></i>
                                    </div>
                                    <p class="mb-0">@lang('Total Deposit')</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-12">
                                <div class="card-box">
                                    <div class="d-flex justify-content-between">
                                        <h4>{{currencyPosition($totalInterestProfit)}}</h4>
                                        <i class="fal fa-envelope-open-dollar"></i>
                                    </div>
                                    <p class="mb-0">@lang('Total Earn')</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-12">
                                <div class="card-box">
                                    <div class="d-flex justify-content-between">
                                        <h4>{{currencyPosition($roi['totalInvestAmount'])}}</h4>
                                        <i class="fal fa-funnel-dollar"></i>
                                    </div>
                                    <p class="mb-0">@lang('Total Invest')</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-12">
                                <div class="card-box">
                                    <div class="d-flex justify-content-between">
                                        <h4>{{currencyPosition($totalPayout)}}</h4>
                                        <i class="fal fa-money-check-alt"></i>
                                    </div>
                                    <p class="mb-0">@lang('Total Payout')</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-12">
                                <div class="card-box">
                                    <div class="d-flex justify-content-between">
                                        <h4>{{$ticket}}</h4>
                                        <i class="fal fa-ticket"></i>
                                    </div>
                                    <p class="mb-0">@lang('Total Ticket')</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-12">
                                <div class="card-box">
                                    <div class="d-flex justify-content-between">
                                        <h4>{{currencyPosition($totalBonus+0)}}</h4>
                                        <i class="fal fa-usd-circle"></i>
                                    </div>
                                    <p class="mb-0">@lang('Total Referral Bonus')</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- card boxes with slider -->
                    <div class="col-12 d-lg-none">
                        <div class="row g--4 g-0 card-box-wrapper owl-carousel card-boxes">
                            <div class="card-box">
                                <div class="d-flex justify-content-between">
                                    <h4>{{currencyPosition($walletBalance)}}</h4>
                                    <i class="fal fa-dollar-sign"></i>
                                </div>
                                <p class="mb-0">@lang('Main Balance')</p>
                            </div>
                            <div class="card-box">
                                <div class="d-flex justify-content-between">
                                    <h4>{{currencyPosition($interestBalance)}}</h4>
                                    <i class="fal fa-hand-holding-usd"></i>
                                </div>
                                <p class="mb-0">@lang('Interest Balance')</p>
                            </div>
                            <div class="card-box">
                                <div class="d-flex justify-content-between">
                                    <h4>{{currencyPosition($totalDeposit)}}</h4>
                                    <i class="fal fa-box-usd"></i>
                                </div>
                                <p class="mb-0">@lang('Total Deposit')</p>
                            </div>
                            <div class="card-box">
                                <div class="d-flex justify-content-between">
                                    <h4>{{currencyPosition($totalInterestProfit)}}</h4>
                                    <i class="fal fa-envelope-open-dollar"></i>
                                </div>
                                <p class="mb-0">@lang('Total Earn')</p>
                            </div>
                            <div class="card-box">
                                <div class="d-flex justify-content-between">
                                    <h4>{{currencyPosition($roi['totalInvestAmount'])}}</h4>
                                    <i class="fal fa-funnel-dollar"></i>
                                </div>
                                <p class="mb-0">@lang('Total Invest')</p>
                            </div>
                            <div class="card-box">
                                <div class="d-flex justify-content-between">
                                    <h4>{{currencyPosition($totalPayout)}}</h4>
                                    <i class="fal fa-money-check-alt"></i>
                                </div>
                                <p class="mb-0">@lang('Total Payout')</p>
                            </div>
                            <div class="card-box">
                                <div class="d-flex justify-content-between">
                                    <h4>{{$ticket}}</h4>
                                    <i class="fal fa-ticket"></i>
                                </div>
                                <p class="mb-0">@lang('Total Ticket')</p>
                            </div>
                            <div class="card-box">
                                <div class="d-flex justify-content-between">
                                    <h4>{{currencyPosition($totalBonus+0)}}</h4>
                                    <i class="fa-light fa-file-chart-pie"></i>
                                </div>
                                <p class="mb-0">@lang('Total Referral Bonus')</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                        <div class="card-box refferal-box">
                            <h5>@lang('Your refferal link')</h5>
                            <div class="input-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{route('register.sponsor',[Auth::user()->username])}}"
                                    id="sponsorURL"
                                    disabled=""/>
                                <button id="copyBtn" onclick="copyText('sponsorURL')" class="btn text-white">
                                    @lang('Copy Link')
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                        <div class="card-box refferal-box">
                            <h5>@lang('Team Investment')</h5>
                            <div class="d-flex justify-content-between">
                                <h4>{{currencyPosition($totalTeamInvest+0)}}</h4>
                                <i class="fal fa-usd-circle"></i>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="row g-4">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card-box refferal-box">
                            <h5>@lang('Transaction Analytics')</h5>
                            <div class="chart-information">
                                <div class="progress-wrapper">
                                    <div
                                        id="container"
                                        class="apexcharts-canvas"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card-box refferal-box">
                            <div class="chart-information">
                                <div class="progress-wrapper progress-wrapper-circle">
                                    <div class="progress-container d-flex flex-column flex-sm-row justify-content-around">
                                        <div class="circular-progress cp_1">
                                            <svg
                                                class="radial-progress"
                                                data-percentage="{{getPercent($roi['totalInvest'], $roi['completed'])}}"
                                                viewBox="0 0 80 80"
                                            >
                                                <circle
                                                    class="incomplete"
                                                    cx="40"
                                                    cy="40"
                                                    r="35"
                                                ></circle>
                                                <circle
                                                    class="complete"
                                                    cx="40"
                                                    cy="40"
                                                    r="35"
                                                    style="
                                    stroke-dashoffset: 39.58406743523136;
                                    "
                                                ></circle>
                                                <text
                                                    class="percentage"
                                                    x="50%"
                                                    y="53%"
                                                    transform="matrix(0, 1, -1, 0, 80, 0)"
                                                >
                                                    {{getPercent($roi['totalInvest'], $roi['completed'])}} %
                                                </text>
                                            </svg>
                                            <h4 class="golden-text mt-4 text-center">
                                                @lang('Invest Completed')
                                            </h4>
                                        </div>

                                        <div class="circular-progress cp_3">
                                            <svg
                                                class="radial-progress"
                                                data-percentage="{{100 - getPercent($roi['expectedProfit'], $roi['returnProfit'])}}"
                                                viewBox="0 0 80 80"
                                            >
                                                <circle
                                                    class="incomplete"
                                                    cx="40"
                                                    cy="40"
                                                    r="35"
                                                ></circle>
                                                <circle
                                                    class="complete"
                                                    cx="40"
                                                    cy="40"
                                                    r="35"
                                                    style="
                                    stroke-dashoffset: 39.58406743523136;
                                    "
                                                ></circle>
                                                <text
                                                    class="percentage"
                                                    x="50%"
                                                    y="53%"
                                                    transform="matrix(0, 1, -1, 0, 80, 0)"
                                                >
                                                    {{100 - getPercent($roi['expectedProfit'], $roi['returnProfit'])}} %
                                                </text>
                                            </svg>

                                            <h4 class="golden-text mt-4 text-center">
                                                @lang('ROI Speed')
                                            </h4>
                                        </div>

                                        <div class="circular-progress cp_2">
                                            <svg
                                                class="radial-progress"
                                                data-percentage="{{getPercent($roi['expectedProfit'], $roi['returnProfit'])}}"
                                                viewBox="0 0 80 80"
                                            >
                                                <circle
                                                    class="incomplete"
                                                    cx="40"
                                                    cy="40"
                                                    r="35"
                                                ></circle>
                                                <circle
                                                    class="complete"
                                                    cx="40"
                                                    cy="40"
                                                    r="35"
                                                    style="
                                    stroke-dashoffset: 147.3406954533613;
                                    "
                                                ></circle>
                                                <text
                                                    class="percentage"
                                                    x="50%"
                                                    y="53%"
                                                    transform="matrix(0, 1, -1, 0, 80, 0)"
                                                >
                                                    {{getPercent($roi['expectedProfit'], $roi['returnProfit'])}} %
                                                </text>
                                            </svg>

                                            <h4 class="golden-text mt-4 text-center">
                                                @lang('ROI Redeemed')
                                            </h4>
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
    <script>
        "use strict";

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
                            return val
                        }
                    },
                    theme: 'dark',
                },
                colors: ['#ff6600', '#fb8e09']
            };
            var chart = new ApexCharts(document.querySelector("#container"), options);
            chart.render();

        })
        function copyFunction() {
            var copyText = document.getElementById("sponsorURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.success(`Copied: ${copyText.value}`);
        }
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


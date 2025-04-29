<!-- Card -->
<div class="card mb-3 mb-lg-5 mt-5" id="investHistoryCard">
    <!-- Header -->
    <div class="card-header card-header-content-sm-between">
        <h4 class="card-header-title mb-2 mb-sm-0">@lang("This Month's Summary")
        </h4>
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
        <div class="row col-lg-divider">
            <div class="col-lg-9 mb-5 mb-lg-0">
                <!-- Bar Chart -->
                <div class="chartjs-custom mb-4">
                    <div id="InvestHistory"></div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="row">
                    <div class="col-sm-6 col-lg-12">
                        <!-- Stats -->
                        <div class="d-flex justify-content-center flex-column aside-sales-chart-height">
                            <h6 class="card-subtitle">@lang('Invest')</h6>
                            <span class="d-block display-4 text-dark mb-1 me-3 totalInvest"></span>
                        </div>
                        <!-- End Stats -->

                        <hr class="d-none d-lg-block my-0">
                    </div>
                    <!-- End Col -->

                    <div class="col-sm-6 col-lg-12">
                        <!-- Stats -->
                        <div class="d-flex justify-content-center flex-column aside-sales-chart-height">
                            <h6 class="card-subtitle">@lang('Return Profit')</h6>
                            <span class="d-block display-4 text-dark mb-1 me-3 returnTotalProfit"></span>

                        </div>
                        <!-- End Stats -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Body -->
</div>
<!-- End Card -->


@push('script')
    <script>
        Notiflix.Block.standard('#investHistoryCard');
        var options = {
            series: [{
                name: 'Return Profit',
                type: 'column',
                data: []
            }, {
                name: 'Payout',
                type: 'column',
                data: []
            }, {
                name: 'Investments',
                type: 'line',
                data: []
            }],
            chart: {
                height: 350,
                type: 'line',
                stacked: false,
                toolbar: {
                    show: false,
                },
                zoom: {
                    enabled: false
                },
                responsive: [
                    {
                        breakpoint: 1024, // Large screens (desktop)
                        options: {
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '12px',
                                        rotate: -45
                                    }
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 768, // Tablets
                        options: {
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '10px',
                                        rotate: -30  // Slightly reduce rotation for smaller screens
                                    }
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 480, // Mobile devices
                        options: {
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '8px',
                                        rotate: 0
                                    },
                                },
                                tickAmount: 8  // Display only 8 labels on mobile
                            }
                        }
                    }
                ]
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [1, 1, 4]
            },
            xaxis: {
                categories: [], // Days data
                labels: {
                    style: {
                        colors: '#777777',
                        fontSize: '12px',
                        fontFamily: 'Arial, sans-serif',
                    },
                    rotate: -45, // Default rotation for larger screens
                }
            },
            tooltip: {
                fixed: {
                    enabled: true,
                    position: 'topLeft',
                    offsetY: 30,
                    offsetX: 60
                },
                y: {
                    formatter: function (val) {
                        return "{{basicControl()->currency_symbol}}" + val;
                    }
                }
            },
        };

        var chart = new ApexCharts(document.querySelector("#InvestHistory"), options);
        chart.render();


        InvestHistory();
        async  function InvestHistory(){
            await axios.get('{{route('admin.invest.history')}}')
                .then(function (response){
                    var newSeries = [
                        {
                            name: '{{trans('Return Profit')}}',
                            data: Object.values(response.data.returnProfit) // Get data values for returnProfit
                        },
                        {
                            name: '{{trans('Payout')}}',
                            data: Object.values(response.data.payout) // Get data values for payout
                        },
                        {
                            name: '{{trans('Investment')}}',
                            data: Object.values(response.data.investment) // Get data values for investment
                        }
                    ];

                    chart.updateOptions({
                        xaxis: {
                            categories: response.data.level // Update the x-axis categories (days)
                        }
                    });

                    chart.updateSeries(newSeries);
                    $('.returnTotalProfit').text(response.data.totalReturnProfit);
                    $('.totalInvest').text(response.data.totalInvestment);
                    Notiflix.Block.remove('#investHistoryCard');
                })
                .catch(function (error){

                })
        }

    </script>
@endpush

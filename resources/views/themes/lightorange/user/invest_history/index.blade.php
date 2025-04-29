@extends(template().'layouts.user')
@section('title',trans('Invest History'))
@section('content')

    @push('navigator')
        <!-- PAGE-NAVIGATOR -->
        <section id="page-navigator">
            <div class="container-fluid">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"
                                                       class="cursor-inherit">{{trans('Invest History')}}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- /PAGE-NAVIGATOR -->
    @endpush




    <section id="dashboard">
        <div class="dashboard-wrapper add-fund pb-50">
            <div class="row">
                <div class="col-md-12">
                    <div class="card secbg">
                        <div class="card-body ">

                            <div class="table-responsive">
                                <table class="table table table-hover table-striped text-white " id="service-table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>@lang('SL')</th>
                                        <th>@lang('Plan')</th>
                                        <th >@lang('Return Interest')</th>
                                        <th>@lang('Received Amount')</th>
                                        <th>@lang('Upcoming Payment')</th>
                                        @if(basicControl()->user_termination)
                                            <th scope="col">@lang('Action')</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($investments as $key => $invest)
                                        <tr>

                                            <td data-label="@lang('SL')">
                                                {{loopIndex($investments) + $key}}
                                            </td>

                                            <td data-label="@lang('Plan')">
                                                {{optional(@$invest->plan)->name}}
                                                <br> {{currencyPosition($invest->amount+0)}}
                                            </td>

                                            <td data-label="@lang('Return Interest')" class="text-capitalize">
                                                {{currencyPosition($invest->profit)}}
                                                {{($invest->period == '-1') ? trans('For Lifetime') : 'per '. trans($invest->point_in_text)}}

                                                <br>
                                                {{($invest->capital_status == '1') ? '+ '.trans('Capital') :''}}
                                            </td>
                                            <td data-label="@lang('Received Amount')">
                                                {{$invest->recurring_time}} x {{ $invest->profit }} =  {{currencyPosition($invest->recurring_time*$invest->profit)}}
                                            </td>

                                            <td>
                                                @if($invest->status == 1)
                                                    <span class='next-payment' data-payment='{{$invest->afterward}}'>{{dateTime($invest->afterward)}}</span>
                                                @elseif($invest->status == 0)
                                                    <span class="badge rounded-pill bg-success">@lang('Completed')</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">@lang('Terminated')</span>
                                                @endif
                                            </td>
                                            @if(basicControl()->user_termination)
                                                <td>
                                                    @if($invest->status == 1)
                                                        <button type="button" data-bs-toggle="modal" data-route="{{route('user.terminate',$invest->id)}}" data-bs-target="#TerminateModal" class="btn base-btn btn-block btn-rounded terminateBtn">@lang('Terminate')</button>

                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @empty

                                        <tr class="text-center">
                                            <td colspan="100%" class="text-center">
                                                <div class="text-center p-4">
                                                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                                    <p class="mb-0">@lang('No data to show')</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                            </div>

                            {{ $investments->appends($_GET)->links(template().'partials.pagination') }}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL-LOGIN -->
    <div id="investment-modal">
        <div class="modal-wrapper">
            <div class="modal-login-body">
                <div class="btn-close  btn-close-investment">&times;</div>
                <div class="form-block pb-5">
                    <form id="terminateRoute" class="login-form" method="post">
                        @csrf
                        <div class="signin ">
                            <p>@lang('Are you sure you want to terminate this investment')?</p>

                            <div class="btn-area mt-30 mb-30">
                                <button class="btn-login login-auth-btn" type="submit"><span>@lang('Confirm')</span></button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>

        "use strict"
        function updateTime() {
            $('.next-payment').each(function() {
                let serverTimeZone = "{{basicControl()->time_zone}}";
                // Parse the dates again to calculate the difference correctly
                const nextPaymentDate = new Date(new Date($(this).data('payment')).toLocaleString("en-US", {
                    timeZone: serverTimeZone
                })).getTime();


                if (nextPaymentDate) {
                    // Get the current time in the server's timezone
                    const nowDate = new Date(new Date().toLocaleString("en-US", {
                        timeZone: serverTimeZone
                    })).getTime();

                    let timeDifference = nextPaymentDate - nowDate;  // Calculate time difference in milliseconds

                    if (timeDifference > 0) {
                        const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                        timeDifference -= days * 1000 * 60 * 60 * 24;
                        const hours = Math.floor(timeDifference / (1000 * 60 * 60));
                        timeDifference -= hours * 1000 * 60 * 60;
                        const minutes = Math.floor(timeDifference / (1000 * 60));
                        timeDifference -= minutes * 1000 * 60;
                        const seconds = Math.floor(timeDifference / 1000);

                        $(this).text(`${days}d ${hours}h ${minutes}m ${seconds}s`);
                    } else {
                        $(this).text('{{trans('Time has passed')}}');
                    }
                }
            });
        }

        // Initial call to set up the time
        updateTime();
        // Update every second
        setInterval(updateTime, 1000);
        $(document).on('click','.terminateBtn',function (){
            $('#terminateRoute').attr('action',$(this).data('route'));
            $("#investment-modal").toggleClass("modal-open");
        })

        $(".btn-close-investment").on('click',function(){
            $("#investment-modal").removeClass("modal-open");
        });
    </script>
@endpush

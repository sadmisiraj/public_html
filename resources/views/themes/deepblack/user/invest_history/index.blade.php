@extends(template().'layouts.user')
@section('title',trans('Invest History'))
@section('content')
    <!-- Invest history -->
    <section class="transaction-history mt-5 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="header-text-full">
                        <h2>{{trans('Invest History')}}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="table-parent table-responsive">
                        <table class="table table-striped mb-5">
                            <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Plan')</th>
                                <th scope="col">@lang('Return Interest')</th>
                                <th scope="col">@lang('Received Amount')</th>
                                <th scope="col">@lang('Upcoming Payment')</th>
                                @if(basicControl()->user_termination)
                                    <th scope="col">@lang('Action')</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($investments as $key => $invest)
                                <tr>
                                    <td>{{loopIndex($investments) + $key}}</td>
                                    <td>
                                        {{optional(@$invest->plan)->name}}
                                        <br> {{currencyPosition($invest->amount+0)}}
                                    </td>
                                    <td>
                                        {{currencyPosition($invest->profit+0)}}
                                        {{($invest->period == '-1') ? trans('For Lifetime') : 'per '. trans($invest->point_in_text)}}
                                        <br>
                                        {{($invest->capital_status == '1') ? '+ '.trans('Capital') :''}}
                                    </td>
                                    <td>
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
                                                <button type="button" data-bs-toggle="modal" data-route="{{route('user.terminate',$invest->id)}}" data-bs-target="#TerminateModal" class="gold-btn terminateBtn">@lang('Terminate')</button>

                                            @else
                                                --
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="100%">{{trans('No Data Found!')}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $investments->appends($_GET)->links(template().'partials.user-pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div id="TerminateModal" class="modal fade investModal" tabindex="-1" role="dialog" data-bs-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content form-block">
                <div class="modal-header">
                    <h4 class="modal-title method-name golden-text">@lang('Confirmation')</h4>
                    <button
                        type="button"
                        data-bs-dismiss="modal"
                        class="btn-close"
                        aria-label="Close"
                    >
                        <img src="{{asset(template(true).'img/icon/cross.png')}}" alt="@lang('modal dismiss')" />
                    </button>
                </div>
                <form id="terminateRoute" method="post">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to terminate this investment')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="gold-btn">@lang("Confirm")</button>
                    </div>
                </form>

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
            $('#terminateRoute').attr('action',$(this).data('route'))
        })
    </script>
@endpush

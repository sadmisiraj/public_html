@extends(template().'layouts.user')
@section('title',trans('Invest History'))
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">@lang('Invest History')</h3>
                </div>
                <!-- table -->
                <div class="table-parent table-responsive">
                    <table class="table table-striped">
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
                        @forelse ($investments as $key => $invest)
                            <tr>
                                <td>{{loopIndex($investments) + $key}}</td>
                                <td>
                                    {{optional(@$invest->plan)->name}}
                                    <br> {{currencyPosition($invest->amount)}}
                                </td>
                                <td>
                                    {{currencyPosition($invest->profit)}}
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
                                            <button type="button" data-bs-toggle="modal" data-route="{{route('user.terminate',$invest->id)}}" data-bs-target="#TerminateModal" class="btn btn-primary terminateBtn">@lang('Terminate')</button>

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
                                        <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                        <p class="mb-0">@lang('No data to show')</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $investments->appends($_GET)->links(template().'partials.user-pagination') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="TerminateModal" tabindex="-1" aria-labelledby="TerminateModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="TerminateModalLabel">@lang('Confirmation')?</h4>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <form id="terminateRoute" method="post">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to terminate this investment')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang("Confirm")</button>
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

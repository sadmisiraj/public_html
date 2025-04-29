@extends(template().'layouts.user')
@section('title',trans('Purchase History'))
@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Purchase History')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Purchase History')</li>
                </ol>
            </nav>
        </div>

        <!-- Cmn table section start -->
        <div class="card">
            <div class="card-header d-flex justify-content-between pb-0 border-0">
                <h4>@lang('Purchase History')</h4>
            </div>
            <div class="card-body">
                <div class="cmn-table">
                    <div class="table-responsive overflow-hidden">
                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Purchase Plan')</th>
                                <th scope="col">@lang('Return Profit')</th>
                                <th scope="col">@lang('Received Amount')<i class="fa-sharp fa-thin fa-circle-info ms-1" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Total Return" data-bs-original-title="Per Return"></i></th>
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
                                            <span class="badge text-bg-success">@lang('Completed')</span>
                                        @else
                                            <span class="badge text-bg-danger">@lang('Terminated')</span>
                                        @endif
                                    </td>
                                    @if(basicControl()->user_termination)
                                        <td>
                                            @if($invest->status == 1)
                                                <button type="button" data-bs-toggle="modal" data-route="{{route('user.terminate',$invest->id)}}" data-bs-target="#TerminateModal" class="cmn-btn terminateBtn">@lang('Terminate')</button>

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
                    </div>
                </div>
            </div>
        </div>
        <!-- Cmn table section end -->

        <!-- pagination section start -->
        <div class="pagination-section">
            {{ $investments->appends($_GET)->links(template().'partials.pagination') }}
        </div>
        <!-- pagination section end -->
    </div>


    <!-- Modal section start -->
    <div class="modal fade" id="TerminateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="staticBackdropLabel">@lang('Confirmation')?</h1>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <form id="terminateRoute" method="post">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to terminate this Purchase')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="cmn-btn">@lang("Confirm")</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal section end -->
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

@extends(template().'layouts.user')
@section('title')
    @lang('Support Ticket')
@endsection

@section('content')
    <!-- main -->
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">@lang('Support Ticket')</h3>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end">
                    <a href="{{route('user.ticket.create')}}" class="btn btn-custom create-ticket-button notiflix-confirm"> <i class="fal fa-plus" aria-hidden="true"></i> Create</a>
                </div>

                <!-- table -->
                <div class="table-parent table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">@lang('Subject')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Last Reply')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tickets as $key => $ticket)
                            <tr>
                                <td data-label="Subject">[{{ trans('Ticket#').$ticket->ticket }}
                                    ] {{ $ticket->subject }}</td>
                                <td data-label="Status">
                                    @if($ticket->status == 0)
                                        <span class="badge rounded-pill bg-success">@lang('Open')</span>
                                    @elseif($ticket->status == 1)
                                        <span class="badge rounded-pill bg-primary">@lang('Answered')</span>
                                    @elseif($ticket->status == 2)
                                        <span class="badge rounded-pill bg-warning">@lang('Replied')</span>
                                    @elseif($ticket->status == 3)
                                        <span class="badge rounded-pill bg-danger">@lang('Closed')</span>
                                    @endif
                                </td>
                                <td data-label="Last Reply">{{diffForHumans($ticket->last_reply) }}</td>
                                <td data-label="Action">
                                    <a href="{{ route('user.ticket.view', $ticket->ticket) }}" type="button" class="btn btn-sm infoButton payoutHistoryBtn" title="Show">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
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

                    <!-- pagination -->
                    {{ $tickets->appends($_GET)->links(template().'partials.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush

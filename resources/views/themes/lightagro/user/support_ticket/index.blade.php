@extends(template().'layouts.user')
@section('title')
    @lang('Support Ticket')
@endsection

@section('content')
    <!-- main -->
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h4 class="mb-0">@lang('Support Ticket')</h4>
                    <a href="{{route('user.ticket.create')}}" class="btn-custom">
                        @lang('Create ticket')
                    </a>
                </div>

                <!-- table -->
                <div class="table-parent table-responsive mt-4">
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
                                        <span class="badge bg-success">@lang('Open')</span>
                                    @elseif($ticket->status == 1)
                                        <span class="badge bg-primary">@lang('Answered')</span>
                                    @elseif($ticket->status == 2)
                                        <span class="badge bg-warning">@lang('Replied')</span>
                                    @elseif($ticket->status == 3)
                                        <span class="badge bg-danger">@lang('Closed')</span>
                                    @endif
                                </td>
                                <td data-label="Last Reply">{{diffForHumans($ticket->last_reply) }}</td>
                                <td data-label="Action">
                                    <div>
                                        <a href="{{ route('user.ticket.view', $ticket->ticket) }}" class="btn-action-icon bg-success">
                                            <i class="fad fa-eye"></i>
                                        </a>
                                    </div>
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

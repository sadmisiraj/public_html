@extends(template().'layouts.user')
@section('title', trans($pageTitle))
@section('content')
<!-- Page title start -->
<div class="pagetitle">
    <h3 class="mb-1">@lang('My Gold Orders')</h3>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Dashboard')</a></li>
            <li class="breadcrumb-item active">@lang('Gold Orders')</li>
        </ol>
    </nav>
</div>
<!-- Page title end -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">@lang('Order History')</h5>
                <div>
                    <div class="dropdown d-inline-block me-2">
                        <button class="btn cmn-btn dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-download"></i> @lang('Export')
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                            <li><a class="dropdown-item" href="{{ route('user.goldcoin.orders.export.pdf') }}"><i class="fa fa-file-pdf"></i> @lang('Export as PDF')</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.goldcoin.orders.export.csv') }}"><i class="fa fa-file-csv"></i> @lang('Export as CSV')</a></li>
                        </ul>
                    </div>
                    <a href="{{ route('user.goldcoin') }}" class="btn cmn-btn">
                        <i class="fa fa-plus-circle"></i> @lang('Purchase Gold')
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>@lang('TRX ID')</th>
                                <th>@lang('Gold Coin')</th>
                                <th>@lang('Weight')</th>
                                <th>@lang('Total Price')</th>
                                <th>@lang('Payment Source')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->trx_id }}</td>
                                    <td>{{ $order->goldCoin->name }} ({{ $order->goldCoin->karat }})</td>
                                    <td>{{ $order->weight_in_grams }} g</td>
                                    <td>{{ currencyPosition($order->total_price) }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($order->payment_source) }}</span>
                                    </td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning">@lang('Pending')</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-info">@lang('Processing')</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-success">@lang('Completed')</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger">@lang('Cancelled')</span>
                                        @elseif($order->status == 'refunded')
                                            <span class="badge bg-secondary">@lang('Refunded')</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <a href="{{ route('user.goldcoin.order.details', $order->trx_id) }}" class="btn btn-sm cmn-btn">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">@lang('No orders found')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
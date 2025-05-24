@extends('admin.layouts.app')
@section('title', $pageTitle)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">@lang('Gold Coin Orders')</h5>
                        <div>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.goldcoin.orders', 'all') }}" class="btn {{ $status == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">@lang('All')</a>
                                <a href="{{ route('admin.goldcoin.orders', 'pending') }}" class="btn {{ $status == 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">@lang('Pending')</a>
                                <a href="{{ route('admin.goldcoin.orders', 'processing') }}" class="btn {{ $status == 'processing' ? 'btn-primary' : 'btn-outline-primary' }}">@lang('Processing')</a>
                                <a href="{{ route('admin.goldcoin.orders', 'completed') }}" class="btn {{ $status == 'completed' ? 'btn-primary' : 'btn-outline-primary' }}">@lang('Completed')</a>
                                <a href="{{ route('admin.goldcoin.orders', 'cancelled') }}" class="btn {{ $status == 'cancelled' ? 'btn-primary' : 'btn-outline-primary' }}">@lang('Cancelled')</a>
                                <a href="{{ route('admin.goldcoin.orders', 'refunded') }}" class="btn {{ $status == 'refunded' ? 'btn-primary' : 'btn-outline-primary' }}">@lang('Refunded')</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>@lang('TRX ID')</th>
                                    <th>@lang('User')</th>
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
                                        <td>
                                            <a href="{{ route('admin.user.edit', $order->user_id) }}">
                                                {{ $order->user->username }}
                                            </a>
                                        </td>
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
                                        <td>{{ $order->created_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.goldcoin.order.details', $order->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">@lang('No orders found')</td>
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
    </div>
@endsection 
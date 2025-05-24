@extends('admin.layouts.app')
@section('title', $pageTitle)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Gold Coin Order History')</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.goldcoin.order.history') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="user">@lang('User')</label>
                                        <input type="text" name="user" id="user" class="form-control" value="{{ request('user') }}" placeholder="Username or Email">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="status">@lang('Status')</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">@lang('All')</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>@lang('Pending')</option>
                                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>@lang('Processing')</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>@lang('Completed')</option>
                                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>@lang('Cancelled')</option>
                                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>@lang('Refunded')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-3">
                                        <label for="from_date">@lang('From Date')</label>
                                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-3">
                                        <label for="to_date">@lang('To Date')</label>
                                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-3">
                                        <label for="trx_id">@lang('TRX ID')</label>
                                        <input type="text" name="trx_id" id="trx_id" class="form-control" value="{{ request('trx_id') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">@lang('Filter')</button>
                                        <a href="{{ route('admin.goldcoin.order.history') }}" class="btn btn-secondary">@lang('Reset')</a>
                                    </div>
                                </div>
                            </div>
                        </form>

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
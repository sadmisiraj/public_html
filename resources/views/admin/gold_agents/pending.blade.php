@extends('admin.layouts.app')
@section('title', $pageTitle)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Pending Gold Orders')</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('TRX ID')</th>
                                        <th>@lang('User')</th>
                                        <th>@lang('Agent')</th>
                                        <th>@lang('Coin')</th>
                                        <th>@lang('Weight')</th>
                                        <th>@lang('Total')</th>
                                        <th>@lang('Order Date')</th>
                                        <th>@lang('Expected Delivery')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>{{ $order->trx_id }}</td>
                                        <td>{{ trim(($order->user->firstname ?? '') . ' ' . ($order->user->lastname ?? '')) }} ({{ $order->user->username }})</td>
                                        <td>
                                            @if($order->agentUser)
                                                {{ trim(($order->agentUser->firstname ?? '') . ' ' . ($order->agentUser->lastname ?? '')) }} ({{ $order->agentUser->username }})
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $order->goldCoin->name }} ({{ $order->goldCoin->karat }})</td>
                                        <td>{{ $order->weight_in_grams }} g</td>
                                        <td>{{ currencyPosition($order->total_price) }}</td>
                                        <td>{{ $order->created_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            @php $dd = $order->goldCoin->delivery_days ?? null; @endphp
                                            @if(!is_null($dd) && (int)$dd > 0)
                                                {{ $order->created_at->copy()->addDays((int)$dd)->format('d M, Y') }}
                                            @else
                                                @lang('N/A')
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">@lang('No pending orders found')</td>
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




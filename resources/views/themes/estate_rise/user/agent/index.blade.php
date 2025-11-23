@extends(template().'layouts.user')
@section('title', trans($pageTitle))
@section('content')
<div class="pagetitle">
    <h3 class="mb-1">@lang('Agent Dashboard')</h3>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Dashboard')</a></li>
            <li class="breadcrumb-item active">@lang('Agent')</li>
        </ol>
    </nav>
    </div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Your Inventory')</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>@lang('Coin')</th>
                                <th>@lang('Stock')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($inventories as $inv)
                            <tr>
                                <td>{{ $inv->goldCoin->name }} ({{ $inv->goldCoin->karat }})</td>
                                <td>{{ $inv->stock }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">@lang('No inventory assigned')</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Assigned Orders')</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>@lang('TRX ID')</th>
                                <th>@lang('Coin')</th>
                                <th>@lang('Weight')</th>
                                <th>@lang('Total')</th>
                                <th>@lang('Buyer')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Expected Delivery')</th>
                                <th>@lang('Order Date')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->trx_id }}</td>
                                <td>{{ $order->goldCoin->name }} ({{ $order->goldCoin->karat }})</td>
                                <td>{{ $order->weight_in_grams }} g</td>
                                <td>{{ currencyPosition($order->total_price) }}</td>
                                <td>{{ trim(($order->user->firstname ?? '') . ' ' . ($order->user->lastname ?? '')) }} ({{ $order->user->username }})</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>
                                    @php $dd = $order->goldCoin->delivery_days ?? null; @endphp
                                    @if(!is_null($dd) && (int)$dd > 0)
                                        {{ $order->created_at->copy()->addDays((int)$dd)->format('d M, Y') }}
                                    @else
                                        @lang('N/A')
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('d M, Y') }}</td>
                                <td>
                                    @if($order->status !== 'completed')
                                    <form action="{{ route('user.agent.order.deliver', $order->trx_id) }}" method="POST" onsubmit="return confirm('Mark this order as delivered?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">@lang('Mark Delivered')</button>
                                    </form>
                                    @else
                                        <span class="badge bg-success">@lang('Delivered')</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">@lang('No assigned orders')</td>
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



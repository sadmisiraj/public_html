@extends(template().'layouts.user')
@section('title', trans($pageTitle))
@section('content')
<!-- Page title start -->
<div class="pagetitle">
    <h3 class="mb-1">@lang('Order Details')</h3>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Dashboard')</a></li>
            <li class="breadcrumb-item"><a href="{{route('user.goldcoin.orders')}}">@lang('Gold Orders')</a></li>
            <li class="breadcrumb-item active">@lang('Order Details')</li>
        </ol>
    </nav>
</div>
<!-- Page title end -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">@lang('Order #:trx_id', ['trx_id' => $order->trx_id])</h5>
                <a href="{{ route('user.goldcoin.orders') }}" class="btn cmn-btn">
                    <i class="fa fa-arrow-left"></i> @lang('Back to Orders')
                </a>
                <a href="{{ route('user.goldcoin.order.invoice', $order->trx_id) }}" class="btn btn-primary" target="_blank">
                    <i class="fa fa-download"></i> @lang('Download Invoice')
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">@lang('Order Information')</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>@lang('TRX ID'):</td>
                                        <td>{{ $order->trx_id }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('Date'):</td>
                                        <td>{{ $order->created_at->format('d M, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('Status'):</td>
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
                                    </tr>
                                    <tr>
                                        <td>@lang('Payment Source'):</td>
                                        <td>{{ ucfirst($order->payment_source) }} @lang('Balance')</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('Address'):</td>
                                        <td>{{ $order->address ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">@lang('Gold Coin Details')</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>@lang('Name'):</td>
                                        <td>{{ $order->goldCoin->name }} ({{ $order->goldCoin->karat }})</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('Weight'):</td>
                                        <td>{{ $order->weight_in_grams }} g</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('Price Per Gram'):</td>
                                        <td>{{ currencyPosition($order->price_per_gram) }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('Subtotal'):</td>
                                        <td>{{ isset($order->subtotal) ? currencyPosition($order->subtotal) : currencyPosition($order->total_price) }}</td>
                                    </tr>
                                    
                                    <!-- Dynamic Charges Breakdown -->
                                    @if($order->getChargesBreakdown())
                                        @foreach($order->getChargesBreakdown() as $charge)
                                            <tr>
                                                <td>{{ $charge['label'] }}
                                                    @if($charge['type'] == 'percentage')
                                                        ({{ $charge['value'] }}%)
                                                    @endif
                                                :</td>
                                                <td>{{ currencyPosition($charge['amount']) }}</td>
                                            </tr>
                                        @endforeach
                                    @elseif(isset($order->gst_amount) && $order->gst_amount > 0)
                                        <!-- Fallback for old orders with GST only -->
                                        <tr>
                                            <td>@lang('GST (18%)'):</td>
                                            <td>{{ currencyPosition($order->gst_amount) }}</td>
                                        </tr>
                                    @endif
                                    
                                    <tr class="table-primary">
                                        <td><strong>@lang('Total Price'):</strong></td>
                                        <td><strong>{{ currencyPosition($order->total_price) }}</strong></td>
                                    </tr>
                                </table>
                                
                                @if($order->goldCoin->image)
                                    <div class="text-center mt-3">
                                        <img src="{{ $order->goldCoin->getImageUrl() }}" alt="{{ $order->goldCoin->name }}" class="img-fluid" style="max-height: 150px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($order->admin_feedback)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="mb-0">@lang('Admin Feedback')</h5>
                                </div>
                                <div class="card-body">
                                    <p>{{ $order->admin_feedback }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <p class="mb-0">
                                <i class="fa fa-info-circle"></i> 
                                @if($order->status == 'pending')
                                    @lang('Your order is pending. It will be processed shortly.')
                                @elseif($order->status == 'processing')
                                    @lang('Your order is being processed.')
                                @elseif($order->status == 'completed')
                                    @lang('Your order has been completed. Thank you for your purchase!')
                                @elseif($order->status == 'cancelled')
                                    @lang('Your order has been cancelled.')
                                @elseif($order->status == 'refunded')
                                    @lang('Your order has been refunded. The amount has been credited back to your account.')
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
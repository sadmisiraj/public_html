@extends('admin.layouts.app')
@section('title', $pageTitle)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">@lang('Order Details')</h5>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> @lang('Back')
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>@lang('Order Information')</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>@lang('TRX ID')</th>
                                        <td>{{ $order->trx_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Date')</th>
                                        <td>{{ $order->created_at->format('d M, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Gold Coin')</th>
                                        <td>{{ $order->goldCoin->name }} ({{ $order->goldCoin->karat }})</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Weight')</th>
                                        <td>{{ $order->weight_in_grams }} g</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Price Per Gram')</th>
                                        <td>{{ currencyPosition($order->price_per_gram) }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Subtotal')</th>
                                        <td>{{ isset($order->subtotal) ? currencyPosition($order->subtotal) : currencyPosition($order->total_price) }}</td>
                                    </tr>
                                    
                                    <!-- Dynamic Charges Breakdown -->
                                    @if($order->getChargesBreakdown())
                                        @foreach($order->getChargesBreakdown() as $charge)
                                            <tr>
                                                <th>{{ $charge['label'] }}
                                                    @if($charge['type'] == 'percentage')
                                                        ({{ $charge['value'] }}%)
                                                    @endif
                                                </th>
                                                <td>{{ currencyPosition($charge['amount']) }}</td>
                                            </tr>
                                        @endforeach
                                    @elseif(isset($order->gst_amount) && $order->gst_amount > 0)
                                        <!-- Fallback for old orders with GST only -->
                                        <tr>
                                            <th>@lang('GST (18%)')</th>
                                            <td>{{ currencyPosition($order->gst_amount) }}</td>
                                        </tr>
                                    @endif
                                    
                                    <tr>
                                        <th>@lang('Address')</th>
                                        <td>{{ $order->address ?? '-' }}</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <th><strong>@lang('Total Price')</strong></th>
                                        <td><strong>{{ currencyPosition($order->total_price) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Payment Source')</th>
                                        <td>{{ ucfirst($order->payment_source) }} @lang('Balance')</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Status')</th>
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
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>@lang('User Information')</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>@lang('Username')</th>
                                        <td>
                                            <a href="{{ route('admin.user.edit', $order->user_id) }}">
                                                {{ $order->user->username }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Email')</th>
                                        <td>{{ $order->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Phone')</th>
                                        <td>{{ $order->user->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Country')</th>
                                        <td>{{ $order->user->country ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                                
                                @if($order->goldCoin->image)
                                    <div class="mt-4">
                                        <h5>@lang('Gold Coin Image')</h5>
                                        <img src="{{ getFile($order->goldCoin->image_driver, $order->goldCoin->image, true) }}" alt="{{ $order->goldCoin->name }}" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($order->admin_feedback)
                            <div class="row mb-4">
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

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">@lang('Update Status')</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('admin.goldcoin.order.update.status', $order->id) }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="status">@lang('Status') <span class="text-danger">*</span></label>
                                                        <select name="status" id="status" class="form-control" required>
                                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>@lang('Pending')</option>
                                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>@lang('Processing')</option>
                                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>@lang('Completed')</option>
                                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>@lang('Cancelled')</option>
                                                            <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>@lang('Refunded')</option>
                                                        </select>
                                                        @if($order->status == 'cancelled' || $order->status == 'refunded')
                                                            <div class="text-warning mt-1">
                                                                <i class="fa fa-info-circle"></i> @lang('This order has already been cancelled/refunded. Changing the status again will not affect the user\'s balance.')
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="admin_feedback">@lang('Admin Feedback')</label>
                                                        <textarea name="admin_feedback" id="admin_feedback" class="form-control" rows="4">{{ $order->admin_feedback }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">@lang('Update Status')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
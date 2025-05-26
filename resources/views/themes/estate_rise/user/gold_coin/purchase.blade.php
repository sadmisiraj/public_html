@extends(template().'layouts.user')
@section('title', trans($pageTitle))
@section('content')
<!-- Page title start -->
<div class="pagetitle">
    <h3 class="mb-1">@lang('Purchase Gold')</h3>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Dashboard')</a></li>
            <li class="breadcrumb-item"><a href="{{route('user.goldcoin')}}">@lang('Gold Coins')</a></li>
            <li class="breadcrumb-item active">@lang('Purchase')</li>
        </ol>
    </nav>
</div>
<!-- Page title end -->

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $coin->name }} ({{ $coin->karat }})</h5>
            </div>
            <div class="card-body">
                @if($coin->image)
                    <div class="text-center mb-4">
                        <img src="{{ $coin->getImageUrl() }}" alt="{{ $coin->name }}" class="img-fluid" style="max-height: 200px;">
                    </div>
                @endif
                
                <div class="d-flex justify-content-between mb-3">
                    <span>@lang('Price Per Gram'):</span>
                    <span class="fw-bold">{{ currencyPosition($coin->price_per_gram) }}</span>
                </div>
                
                @if($coin->description)
                    <div class="mb-3">
                        <h6>@lang('Description'):</h6>
                        <p>{{ $coin->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">@lang('Purchase Details')</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.goldcoin.purchase') }}" method="POST">
                    @csrf
                    <input type="hidden" name="coin_id" value="{{ $coin->id }}">
                    
                    <div class="form-group mb-3">
                        <label for="weight">@lang('Weight in Grams') <span class="text-danger">*</span></label>
                        <input type="number" name="weight" id="weight" class="form-control" value="{{ old('weight', 1) }}" min="0.01" step="0.01" required>
                        <small class="text-muted">@lang('Enter the weight in grams you want to purchase')</small>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="subtotal">@lang('Subtotal')</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ $basic->currency_symbol }}</span>
                            <input type="text" id="subtotal" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="gst_amount">@lang('GST (18%)')</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ $basic->currency_symbol }}</span>
                            <input type="text" id="gst_amount" name="gst_amount" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="total_price"><strong>@lang('Total Price (with GST)')</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">{{ $basic->currency_symbol }}</span>
                            <input type="text" id="total_price" name="total_price" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="payment_source">@lang('Payment Source') <span class="text-danger">*</span></label>
                        <select name="payment_source" id="payment_source" class="form-control" required>
                            <option value="deposit" {{ old('payment_source') == 'deposit' ? 'selected' : '' }}>@lang('Deposit Balance') - {{ currencyPosition($user->balance) }}</option>
                            <option value="profit" {{ old('payment_source') == 'profit' ? 'selected' : '' }}>@lang('Profit Balance') - {{ currencyPosition($user->interest_balance) }}</option>
                            <option value="performance" {{ old('payment_source') == 'performance' ? 'selected' : '' }}>@lang('Performance Balance') - {{ currencyPosition($user->profit_balance) }}</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn cmn-btn w-100">@lang('Purchase Now')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        function calculateTotal() {
            const weight = parseFloat($('#weight').val()) || 0;
            const pricePerGram = parseFloat('{{ $coin->price_per_gram }}');
            const subtotal = weight * pricePerGram;
            
            // Calculate GST (18%)
            const gstRate = 0.18;
            const gstAmount = subtotal * gstRate;
            
            // Calculate total price with GST
            const totalPrice = subtotal + gstAmount;
            
            // Update the form fields
            $('#subtotal').val(subtotal.toFixed(8));
            $('#gst_amount').val(gstAmount.toFixed(8));
            $('#total_price').val(totalPrice.toFixed(8));
        }
        
        $('#weight').on('input', calculateTotal);
        calculateTotal(); // Calculate on page load
    });
</script>
@endpush 
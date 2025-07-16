@extends(template().'layouts.user')
@section('title', trans('Payout Money'))

@section('content')

    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Sellout Gold')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Sellout Gold')</li>
                </ol>
            </nav>
        </div>
        @if(!isActivePayout())
            <div class="col-12 payout_alert">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <div class="icon-area">
                        <i class="fa-light fa-triangle-exclamation"></i>
                    </div>
                    <div class="text-area">
                        <div class="description">
                            <h5 class="">
                                {{ __('Today Withdraw feature is off. Please try on one of these days:') }}
                                @foreach (getWithdrawDays() as $key => $day)
                                    {{ ucfirst($day) }}@if (!$loop->last), @endif
                                @endforeach</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fa-regular fa-xmark"></i></button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="col-12 global-error-alert">
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <div class="icon-area">
                        <i class="fa-light fa-triangle-exclamation"></i>
                    </div>
                    <div class="text-area">
                        <div class="description">
                            <h5 class="">{{ session('error') }}</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fa-regular fa-xmark"></i></button>
                </div>
            </div>
        @endif
        <form action="{{ route('user.payout.request') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
            <div class="col-lg-7 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-15">@lang('Select Payout Method')</h4>
                        <!-- Payment section start -->
                        <div class="payment-section">
                            <ul class="payment-container-list">
                                @foreach($payoutMethod as $method)
                                     <li class="item">
                                            <input class="form-check-input selectPayoutMethod"
                                                   value="{{ $method->id }}" type="radio"
                                                   name="payout_method_id"
                                                   id="{{$method->name}}">
                                            <label class="form-check-label" for="{{$method->name}}">
                                                <div class="image-area">
                                                    <img src="{{ getFile($method->driver,$method->logo ) }}" alt="payout method image">
                                                </div>
                                                <div class="content-area">
                                                    <h5>{{$method->name}}</h5>
                                                    <span>
                                                        {{$method->description}}
                                                    </span>
                                                </div>
                                            </label>
                                        </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Payment section end -->
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="side-bar" id="regularSidebar">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 input-box mb-3">
                                    <select class="form-control"
                                            name="wallet_type"
                                    >
                                        <option value="interest_balance"
                                                class="bg-light text-dark">@lang('Gold value Balance -'.currencyPosition(auth()->user()->interest_balance+0))</option>
                                        <option value="profit_balance"
                                                class="bg-light text-dark">@lang('Performance Balance -'.currencyPosition(auth()->user()->profit_balance+0))</option>
                                    </select>

                                </div>
                                
                                <!-- Hidden currency input field with default INR value -->
                                <input type="hidden" name="supported_currency" value="INR" id="supported_currency_input">
                                <input type="hidden" name="use_bank_account" id="useBankAccountInput" value="0">

                                <div class="col-md-12 input-box">
                                    <div class="input-group">
                                        <input class="form-control @error('amount') is-invalid @enderror"
                                               name="amount"
                                               type="text" id="amount"
                                               placeholder="@lang('Enter Amount')" autocomplete="off"/>
                                        <div class="invalid-feedback">
                                            @error('amount') @lang($message) @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="payoutSummary">
                                <div class="row d-flex text-center justify-content-center">
                                    <div class="col-md-12">
                                        <img src="{{ asset('assets/admin/img/oc-error.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
                                        <p>@lang('Waiting for payout preview')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bank Account Details Section (Hidden by default) -->
                <div id="bankAccountDetails" class="mt-4" style="display: none;">
                    <div class="card">
                        <div class="card-header">
                            <h5>@lang('Your Bank Account Details')</h5>
                        </div>
                        <div class="card-body">
                            @if(auth()->user()->bankDetails)
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <strong>@lang('Bank Name'):</strong> {{ auth()->user()->bankDetails->bank_name }}
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <strong>@lang('Account Number'):</strong> {{ auth()->user()->bankDetails->account_number }}
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <strong>@lang('IFSC Code'):</strong> {{ auth()->user()->bankDetails->ifsc_code }}
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <strong>@lang('Verification Status'):</strong> 
                                        @if(auth()->user()->bankDetails->is_verified)
                                            <span class="badge bg-success">@lang('Verified')</span>
                                        @else
                                            <span class="badge bg-warning">@lang('Pending Verification')</span>
                                        @endif
                                    </div>
                                    @if(isset($bankDetailsWarning))
                                    <div class="col-md-12 mb-2 mt-2">
                                        <div class="alert alert-warning">
                                            {{ $bankDetailsWarning }}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <p><strong>Selected Currency:</strong> INR</p>
                                        </div>
                                        <div class="col-md-12 input-box mb-3">
                                            <label for="bank-wallet-type">@lang('Select Wallet')</label>
                                            <select class="form-control" name="wallet_type" id="bank-wallet-type">
                                                <option value="interest_balance" class="bg-light text-dark">
                                                    @lang('Gold Value Balance -'.currencyPosition(auth()->user()->interest_balance+0))
                                                </option>
                                                <option value="profit_balance" class="bg-light text-dark">
                                                    @lang('Performance Balance -'.currencyPosition(auth()->user()->profit_balance+0))
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 input-box">
                                            <label for="bank-amount">@lang('Enter Amount')</label>
                                            <div class="input-group">
                                                <input class="form-control" name="amount" type="text" id="bank-amount"
                                                    placeholder="@lang('Enter Amount')" autocomplete="off"/>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="bank-withdrawal-summary" class="mb-3" style="display: none;">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">@lang('Sellout Summary')</h5>
                                                <div class="withdrawal-details mt-3">
                                                    <div class="row mb-2">
                                                        <div class="col-6">@lang('You will receive'):</div>
                                                        <div class="col-6 text-end"><span id="summary-amount">0</span> INR</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-6">@lang('Fee'):</div>
                                                        <div class="col-6 text-end"><span id="summary-fee">0</span> INR</div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-6"><strong>@lang('Total Deduction')</strong>:</div>
                                                        <div class="col-6 text-end"><strong><span id="summary-total">0</span> INR</strong></div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-6">@lang('Gold Equivalent'):</div>
                                                        <div class="col-6 text-end"><span id="summary-gold-grams">0</span> g</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="bank-error-message" class="alert alert-danger" style="display: none;"></div>
                                    <button type="button" class="cmn-btn w-100 bank-submit-btn">@lang('Withdraw')</button>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    @lang('No bank account details found. Please update your KYC information to add bank details.')
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Modal section start -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                 aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" id="staticBackdropLabel">@lang('Withdraw')</h1>
                            <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-light fa-xmark"></i>
                            </button>
                        </div>
                        <div class="modal-body" id="paymentModalBody">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal section end -->
        </form>
    </div>
@endsection

@push('script')
<script>
    const todaysGoldRate = {{ (float) App\Models\Config::getConfig('config_3') }};
</script>
    <script>
        'use strict';

        $(document).on('click','.close-btn',function (){
            $('.payout_alert').remove()
        });

        $(document).ready(function () {
            // Hide bank submit button by default
            $('.bank-submit-btn').hide();
            
            // Check if there was an error with the bank account withdrawal
            if ($('.global-error-alert').length > 0) {
                // If Bank Account is selected
                if ($('input[id="Bank Account"]').is(':checked')) {
                    // Show bank account details and error
                    $('#bankAccountDetails').show();
                    $('#useBankAccountInput').val(1);
                    $('#payoutSummary').hide();
                    $('#regularSidebar').hide(); // Hide regular sidebar
                    $('.bank-submit-btn').show();
                    
                    // Show specific error in bank error area
                    $('#bank-error-message').text($('.global-error-alert .description h5').text()).show();
                    
                    // Hide global error to avoid duplication
                    $('.global-error-alert').hide();
                    
                    // Fetch bank account limits
                    fetchBankAccountLimits($('input[id="Bank Account"]').val());
                }
            }
            
            // Check if payment method is Bank Account and show bank details
            $(document).on('click', '.selectPayoutMethod', function() {
                let methodId = $(this).attr('id');
                let methodValue = $(this).val();
                
                if (methodId === 'Bank Account') {
                    // Hide regular payout summary and show bank account details
                    $('#payoutSummary').hide();
                    $('#regularSidebar').hide(); // Hide the regular sidebar
                    $('#bankAccountDetails').show();
                    $('#useBankAccountInput').val(1);
                    $('.bank-submit-btn').show();
                    $('#bank-error-message').hide();
                    
                    // Always set currency to INR for bank accounts
                    $('#supported_currency_input').val('INR');
                    
                    // Fetch bank account withdrawal limits and fees
                    fetchBankAccountLimits(methodValue);
                    
                    // Make sure we don't try to get currencies from the server for bank accounts
                    selectedPayoutMethod = null;
                } else {
                    // Show regular payout summary and hide bank account details
                    $('#bankAccountDetails').hide();
                    $('#regularSidebar').show(); // Show the regular sidebar
                    $('#useBankAccountInput').val(0);
                    $('#payoutSummary').show();
                    
                    // Get selected method ID for currency lookup
                    selectedPayoutMethod = $(this).val();
                    supportCurrency(selectedPayoutMethod);
                }
            });
            
            // Function to fetch bank account withdrawal limits and fees
            function fetchBankAccountLimits(methodId) {
                $.ajax({
                    method: "GET",
                    url: "{{ route('user.payout.checkAmount') }}",
                    dataType: "json",
                    data: {
                        'amount': 100, // Minimum amount to get the limits
                        'selected_currency': 'INR',
                        'selected_payout_method': methodId,
                    }
                }).done(function (response) {
                    if (response.status) {
                        // Store the limits and fees in data attributes
                        $('#bank-amount').data('min-limit', response.min_limit);
                        $('#bank-amount').data('max-limit', response.max_limit);
                        $('#bank-amount').data('percentage-charge', response.percentage);
                        $('#bank-amount').data('fixed-charge', response.fixed_charge);
                        
                        // Update validation error messages with actual limits
                        $('#bank-amount').attr('placeholder', `Enter Amount (Min: ${response.min_limit}, Max: ${response.max_limit})`);
                    } else {
                        $('#bank-error-message').text(response.message).show();
                    }
                }).fail(function(error) {
                    console.error('Error fetching bank account limits:', error);
                });
            }
            
            // Basic validation for bank amount
            $(document).on('input', '#bank-amount', function() {
                let amount = $(this).val();
                let minLimit = $(this).data('min-limit') || 1000;
                let maxLimit = $(this).data('max-limit') || 50000;
                
                if(amount <= 0 || isNaN(amount)) {
                    $(this).addClass('is-invalid');
                    $(this).closest('div').find('.invalid-feedback').text('Please enter a valid amount');
                    $('.bank-submit-btn').prop('disabled', true);
                    $('#bank-withdrawal-summary').hide();
                } else {
                    // Check if amount is within the limits
                    if (amount < minLimit) {
                        $(this).addClass('is-invalid');
                        $(this).closest('div').find('.invalid-feedback').text(`Minimum withdrawal amount is ${minLimit} INR`);
                        $('.bank-submit-btn').prop('disabled', true);
                        $('#bank-withdrawal-summary').hide();
                    } else if (amount > maxLimit) {
                        $(this).addClass('is-invalid');
                        $(this).closest('div').find('.invalid-feedback').text(`Maximum withdrawal amount is ${maxLimit} INR`);
                        $('.bank-submit-btn').prop('disabled', true);
                        $('#bank-withdrawal-summary').hide();
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).closest('div').find('.invalid-feedback').text('');
                        $('.bank-submit-btn').prop('disabled', false);
                        
                        // Calculate and show withdrawal summary
                        updateBankWithdrawalSummary(amount);
                    }
                }
                
                // Copy the amount to the main amount field
                $('#amount').val(amount);
            });
            
            // Function to update the bank withdrawal summary
            function updateBankWithdrawalSummary(amount) {
                amount = parseFloat(amount);
                // Always use 10% fee for this logic
                let percentageFee = amount * 0.10;
                let fee = percentageFee.toFixed(2);
                let netPayout = (amount - percentageFee).toFixed(2);
                // Update summary values
                $('#summary-amount').text(netPayout); // You will receive
                $('#summary-fee').text(fee); // Fee
                $('#summary-total').text(amount.toFixed(2)); // Total Deduction (debited from wallet)
                // Calculate gold equivalent for 90% of withdrawal amount
                let goldAmount = 0;
                if (todaysGoldRate > 0) {
                    goldAmount = ((amount * 0.9) / todaysGoldRate).toFixed(4);
                }
                $('#summary-gold-grams').text(goldAmount);
                $('#bank-withdrawal-summary').show();
            }
            
            // Make sure form is submitted when bank submit button is clicked
            $('.bank-submit-btn').on('click', function(e) {
                e.preventDefault();
                
                // Clear error message
                $('#bank-error-message').hide();
                
                // Simple validation
                let amount = $('#bank-amount').val();
                let minLimit = $('#bank-amount').data('min-limit') || 1000;
                let maxLimit = $('#bank-amount').data('max-limit') || 50000;
                
                if (!amount || amount <= 0 || isNaN(amount)) {
                    $('#bank-amount').addClass('is-invalid');
                    $('#bank-amount').closest('div').find('.invalid-feedback').text('Please enter a valid amount');
                    return false;
                }
                
                // Check amount limits
                if (amount < minLimit) {
                    $('#bank-amount').addClass('is-invalid');
                    $('#bank-amount').closest('div').find('.invalid-feedback').text(`Minimum withdrawal amount is ${minLimit} INR`);
                    return false;
                } else if (amount > maxLimit) {
                    $('#bank-amount').addClass('is-invalid');
                    $('#bank-amount').closest('div').find('.invalid-feedback').text(`Maximum withdrawal amount is ${maxLimit} INR`);
                    return false;
                }
                
                // Make sure Bank Account payment method is selected
                if (!$('input[id="Bank Account"]').is(':checked')) {
                    $('input[id="Bank Account"]').prop('checked', true);
                }
                
                // Set values in the main form
                $('#amount').val(amount);
                $('select[name="wallet_type"]').val($('#bank-wallet-type').val());
                $('#useBankAccountInput').val(1);
                
                // Force INR currency for bank accounts
                $('#supported_currency_input').val('INR');
                
                // Show loading state
                $(this).prop('disabled', true).text('Processing...');
                
                // Submit the form - use traditional form submission to avoid AJAX issues
                $('form[action="{{ route("user.payout.request") }}"]').submit();
            });
            
            let amountStatus = false;
            let selectedPayoutMethod = "";

            function clearMessage(fieldId) {
                $(fieldId).removeClass('is-valid')
                $(fieldId).removeClass('is-invalid')
                $(fieldId).closest('div').find(".invalid-feedback").html('');
                $(fieldId).closest('div').find(".is-valid").html('');
            }

            $(document).on('click', '.selectPayoutMethod', function () {
                $('#paymentModalBody').html('');
                let updatedWidth = window.innerWidth;
                window.addEventListener('resize', () => {
                    updatedWidth = window.innerWidth;
                });
                let methodId = $(this).attr('id');
                
                // Don't show the modal for Bank Account payment method
                if (methodId === 'Bank Account') {
                    return;
                }
                
                let html = `<div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 input-box mb-3">
                                    <select class="form-control"
                                            name="wallet_type"
                                    >
                                        <option
                                            value="interest_balance"
                                            class="bg-light text-dark">@lang('Performance Balance -'.currencyPosition(auth()->user()->profit_balance+0))</option>
                                        <option value="profit_balance"
                                                class="bg-light text-dark">@lang('Profit Balance -'.currencyPosition(auth()->user()->interest_balance+0))</option>
                                    </select>

                                </div>
                                <div class="col-md-12 input-box mb-3">
                                    <select class="form-control"
                                            name="supported_currency"
                                            id="supported_currency">
                                        <option value="">@lang('Select Currency')</option>
                                    </select>
                                </div>

                                <div class="col-md-12 input-box">
                                    <div class="input-group">
                                        <input class="form-control @error('amount') is-invalid @enderror"
                                               name="amount"
                                               type="text" id="amount"
                                               placeholder="@lang('Enter Amount')" autocomplete="off"/>
                                        <div class="invalid-feedback">
                                            @error('amount') @lang($message) @enderror
                                        </div>
                                        <div class="valid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="payoutSummary">
                        <div class="row d-flex text-center justify-content-center">
                            <div class="col-md-12">
                                <img src="{{ asset('assets/admin/img/oc-error.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
                                <p>@lang('Waiting for payout preview')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
                if(updatedWidth <= 991){
                    $('.side-bar').html('');
                    $('#paymentModalBody').html(html);
                    let paymentModal =  new bootstrap.Modal(document.getElementById('staticBackdrop'));
                    paymentModal.show()
                }else {
                    $('.side-bar').html(html)
                }
            });
            
            // Trigger the display of bank details if Bank Account is selected on page load
            if($('input[id="Bank Account"]').is(':checked')) {
                $('#bankAccountDetails').show();
                $('#useBankAccountInput').val(1);
                $('#payoutSummary').hide();
                $('#regularSidebar').hide(); // Hide regular sidebar
                $('.bank-submit-btn').show();
                // Force INR currency for bank accounts
                $('#supported_currency_input').val('INR');
                
                // Fetch bank account limits on page load
                fetchBankAccountLimits($('input[id="Bank Account"]').val());
            }

            function supportCurrency(selectedPayoutMethod) {
                if (!selectedPayoutMethod) {
                    console.error('Selected Gateway is undefined or null.');
                    return;
                }

                $('#supported_currency').empty();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('user.payout.supported.currency') }}",
                    data: {gateway: selectedPayoutMethod},
                    type: "GET",
                    success: function (data) {

                        if (data === "") {
                            let markup = `<option value="USD">USD</option>`;
                            $('#supported_currency').append(markup);
                        }

                        let markup = '<option value="">Selected Currency</option>';
                        $('#supported_currency').append(markup);

                        $(data).each(function (index, value) {

                            let markup = `<option value="${value}">${value}</option>`;
                            $('#supported_currency').append(markup);
                        });
                    },
                    error: function (error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }


            $(document).on('change, input', "#amount, #supported_currency, .selectPayoutMethod", function (e) {
                // Skip for bank account
                if ($('input[id="Bank Account"]').is(':checked')) {
                    return;
                }
                
                let amount = $('#amount').val();
                let selectedCurrency = $('#supported_currency').val();
                let currency_type = 1;

                if (!isNaN(amount) && amount > 0) {

                    let fraction = amount.split('.')[1];
                    let limit = currency_type == 0 ? 8 : 2;


                    if (fraction && fraction.length > limit) {
                        amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
                        $('#amount').val(amount);
                    }

                    checkAmount(amount, selectedCurrency, selectedPayoutMethod)


                } else {
                    clearMessage($('#amount'))
                    $('#payoutSummary').html(`<div class="row d-flex text-center justify-content-center">
                                                    <div class="col-md-12">
                                                        <img src="{{ asset('assets/admin/img/oc-error.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
                                                        <p>@lang('Waiting for payout preview')</p>
                                                    </div>
                                                </div>`)
                }
            });


            function checkAmount(amount, selectedCurrency, selectedPayoutMethod) {

                $.ajax({
                    method: "GET",
                    url: "{{ route('user.payout.checkAmount') }}",
                    dataType: "json",
                    data: {
                        'amount': amount,
                        'selected_currency': selectedCurrency,
                        'selected_payout_method': selectedPayoutMethod,
                    }
                }).done(function (response) {
                    console.log(response)
                    let amountField = $('#amount');
                    if (response.status) {
                        clearMessage(amountField);
                        $(amountField).addClass('is-valid');
                        $(amountField).closest('div').find(".valid-feedback").html(response.message);
                        amountStatus = true;
                        let base_currency ="{{basicControl()->base_currency}}"
                        showCharge(response, base_currency);
                    } else {
                        amountStatus = false;
                        // submitButton();
                        $('#payoutSummary').html(`<div class="row d-flex text-center justify-content-center">
                                                    <div class="col-md-12">
                                                        <img src="{{ asset('assets/admin/img/oc-error.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
                                                        <p>@lang('Waiting for payout preview')</p>
                                                    </div>
                                                </div>`);
                        clearMessage(amountField);
                        $(amountField).addClass('is-invalid');
                        $(amountField).closest('div').find(".invalid-feedback").html(response.message);
                    }
                });
            }


            function showCharge(response, currency) {

                let txnDetails =   `<div class="side-box">
                    <div class="transfer-details-section">
                        <ul class="transfer-list">
                         <li class="item title">
                            <h5>@lang('Payout Summary')</h5>
                        </li>
						<li class="item">
							<span>{{ __('Amount In') }} ${response.currency} </span>
							<span class="text-success"> ${response.amount} ${response.currency}</span>
						</li>

						<li class="item">
							<span>{{ __('Charge') }}</span>
							<span class="text-danger">  ${response.charge} ${response.currency}</span>
						</li>


						<li class="item">
							<span>{{ __('Payout Amount') }}</span>
							<span class=""> ${response.net_payout_amount} ${response.currency}</span>
						</li>


						<li class="item">
							<span>{{ __('In Base Currency') }}</span>
							<span class=""> ${response.amount_in_base_currency} ${currency}</span>
						</li>
					</ul>
                    </div>
                </div>
               <button type="submit" class="cmn-btn w-100">@lang('Withdraw')</button>`;
                $('#payoutSummary').html(txnDetails)
            }
        });
    </script>
@endpush


@push('style')
    <style>
        .paymentModal button {
            margin-top: 20px;
        }
        @media only screen and (max-width: 991px) {
            .side-bar {
                display: none;
            }

        }
        @media only screen and (max-width: 420px) {
            .payment-section .payment-container-list .gateway-description{
                opacity: .7;
                font-size: 15px;
                font-weight: 500;
                line-height: normal;
                margin-top: 7px;
                margin-bottom: 25px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        }
        
        #bankAccountDetails {
            margin: 0 0 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        #bankAccountDetails .card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        #bankAccountDetails .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }
        
        #bankAccountDetails .card-body {
            padding: 20px;
        }
        
        #bankAccountDetails .badge {
            padding: 5px 8px;
            font-size: 12px;
        }
        
        .bank-submit-btn {
            margin-top: 15px;
            padding: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .bank-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .selectPayoutMethod:checked + label {
            background-color: rgba(var(--primary-rgb), 0.05);
            border-color: var(--primary);
            transition: all 0.3s ease;
        }
        
        .payment-container-list .item {
            transition: all 0.3s ease;
        }
        
        .payment-container-list .item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

    </style>
@endpush

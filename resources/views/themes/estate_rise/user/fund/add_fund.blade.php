@extends(template().'layouts.user')
@section('title',trans('Fund Deposit'))
@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Fund Deposit')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Fund Deposit')</li>
                </ol>
            </nav>
        </div>
        <form action="{{ route('payment.request') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
            <div class="col-lg-7 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-15">@lang('Select Payment Method')</h4>
                        <!-- Payment section start -->
                        <div class="payment-section">
                            <ul class="payment-container-list">
                                @foreach($gateways as $method)
                                    <li class="item">
                                        <input class="form-check-input selectPayment" type="radio"
                                               name="gateway_id"
                                               value="{{ $method->id }}"
                                               id="{{ $method->name }}">
                                        <label class="form-check-label" for="{{ $method->name }}">
                                            <div class="image-area">
                                                <img src="{{ getFile($method->driver,$method->image ) }}" alt="EstateRise">
                                            </div>
                                            <div class="content-area">
                                                <h5>{{$method->name}}</h5>

                                                <span class="gateway-description">
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
                <div class="side-bar">
                    <div class="card">
                        <div class="card-body">
                            <!-- Transfer details section start -->
                            <div class="transfer-details-section">
                                <div class="mb-3 add-select-field" >
                                    <select class="form-control"
                                            name="supported_currency"
                                            id="supported_currency">
                                        <option value="">@lang('Select Currency')</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control @error('amount') is-invalid @enderror"
                                           name="amount"
                                           type="text" id="amount"
                                           placeholder="@lang('Enter Amount')" autocomplete="off"/>
                                    <div class="invalid-feedback">
                                        @error('amount') @lang($message) @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>
                                <div id="paymentSummary">
                                    <div class="row d-flex text-center justify-content-center">
                                        <div class="col-md-12">
                                            <img src="{{ asset('assets/admin/img/oc-error.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
                                            <p>@lang('Waiting for payment preview')</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Transfer details section end -->
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
                            <h1 class="modal-title" id="staticBackdropLabel">@lang('Deposit')</h1>
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
        'use strict';


        $(document).ready(function () {
            let amountStatus = false;
            let selectedGateway = "";

            function clearMessage(fieldId) {
                $(fieldId).removeClass('is-valid')
                $(fieldId).removeClass('is-invalid')
                $(fieldId).closest('div').find(".invalid-feedback").html('');
                $(fieldId).closest('div').find(".is-valid").html('');
            }

            $(document).on('click', '.selectPayment', function () {
                $('#paymentModalBody').html('');
                let updatedWidth = window.innerWidth;
                window.addEventListener('resize', () => {
                    updatedWidth = window.innerWidth;
                });
                let html = `<div class="card">
                        <div class="card-body">
                            <!-- Transfer details section start -->
                            <div class="transfer-details-section">
                                <div class="mb-3 add-select-field" >
                                    <select class="form-control"
                                            name="supported_currency"
                                            id="supported_currency">
                                        <option value="">@lang('Select Currency')</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control @error('amount') is-invalid @enderror"
                                           name="amount"
                                           type="text" id="amount"
                                           placeholder="@lang('Enter Amount')" autocomplete="off"/>
                                    <div class="invalid-feedback">
                                        @error('amount') @lang($message) @enderror
                </div>
                <div class="valid-feedback"></div>
            </div>
            <div id="paymentSummary">
                <div class="row d-flex text-center justify-content-center">
                    <div class="col-md-12">
                        <img src="{{ asset('assets/admin/img/oc-error.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
                                            <p>@lang('Waiting for payment preview')</p>
                                        </div>
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
                selectedGateway = $(this).val();
                supportCurrency(selectedGateway);
            });

            function supportCurrency(selectedGateway) {
                if (!selectedGateway) {
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
                    url: "{{ route('supported.currency') }}",
                    data: {gateway: selectedGateway},
                    type: "GET",
                    success: function (response) {

                        $('.add-select-field').empty();

                        if (response.data === "") {
                            let markup = `<option value="USD">USD</option>`;
                            $('#supported_currency').append(markup);
                        }

                        if (response.currencyType == 1) {
                            let select =   `
                                                <select class="form-control"
                                                        name="supported_currency"
                                                        id="supported_currency">
                                                        <option value="">`+'{{trans('Select Currency')}}'+`</option>
                                                </select>`;
                            $('.add-select-field').append(select);

                            // Check if this is bank transfer and only has INR option
                            let isBankTransfer = false;
                            let hasOnlyINR = false;
                            
                            // Check if selected gateway name is "Bank Transfer" 
                            $(".payment-container-list .item").each(function() {
                                if ($(this).find("input").is(":checked") && $(this).find("h5").text() === "Bank Transfer") {
                                    isBankTransfer = true;
                                }
                            });
                            
                            // Check if only INR is available
                            if (response.data && response.data.length === 1 && response.data[0] === "INR") {
                                hasOnlyINR = true;
                            }
                            
                            $(response.data).each(function (index, value) {
                                let selected = "";
                                // Auto-select INR if bank transfer and only INR is available
                                if (isBankTransfer && value === "INR") {
                                    selected = "selected";
                                }
                                let markup = `<option value="${value}" ${selected}>${value}</option>`;
                                $('#supported_currency').append(markup);
                            });
                            
                            // Trigger change event to update the form if INR was auto-selected
                            if (isBankTransfer && hasOnlyINR) {
                                $('#supported_currency').trigger('change');
                            }
                        }

                        let markup2 = '<option value="">'+'{{trans('Select Crypto Currency')}}'+'</option>';
                        $('#supported_crypto_currency').append(markup2);

                        if (response.currencyType == 0){
                            let markup2 = `
                                        <select class="js-example-basic-single form-control"
                                                name="supported_crypto_currency"
                                                id="supported_crypto_currency">
                                              <option value="">`+'{{trans('Select Crypto Currency')}}'+`</option>
                                        </select>`;
                            $('.add-select-field').append(markup2);

                            $(response.data).each(function (index, value) {
                                let markupOption = `<option value="${value}">${value}</option>`;
                                $('#supported_crypto_currency').append(markupOption);
                            });
                        }
                    },
                    error: function (error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }


            $(document).on('change, input', "#amount, #supported_currency, .selectPayment, #supported_crypto_currency", function (e) {

                let amount = $('#amount').val();
                let selectedCurrency = $('#supported_currency').val();
                let selectedCryptoCurrency = $('#supported_crypto_currency').val();
                let currency_type = 1;

                if (!isNaN(amount) && amount > 0) {

                    let fraction = amount.split('.')[1];
                    let limit = currency_type == 0 ? 8 : 2;

                    if (fraction && fraction.length > limit) {
                        amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
                        $('#amount').val(amount);
                    }

                    checkAmount(amount, selectedCurrency, selectedGateway, selectedCryptoCurrency)

                    if (selectedCurrency != null) {

                    }
                } else {
                    clearMessage($('#amount'))
                    $('#paymentSummary').html(`<div class="row d-flex text-center justify-content-center">
                                            <div class="col-md-12">
                                                <img src="{{ asset('assets/admin/img/oc-error.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
                                                <p>@lang('Waiting for payment preview')</p>
                                            </div>
                                        </div>`)
                }
            });

            function checkAmount(amount, selectedCurrency, selectGateway, selectedCryptoCurrency = null) {
                $.ajax({
                    method: "GET",
                    url: "{{ route('deposit.checkAmount') }}",
                    dataType: "json",
                    data: {
                        'amount': amount,
                        'selected_currency': selectedCurrency,
                        'select_gateway': selectGateway,
                        'selectedCryptoCurrency': selectedCryptoCurrency,
                    }
                }).done(function (response) {
                    let amountField = $('#amount');
                    if (response.status) {
                        clearMessage(amountField);
                        $(amountField).addClass('is-valid');
                        $(amountField).closest('div').find(".valid-feedback").html(response.message);
                        amountStatus = true;
                        let base_currency = "{{basicControl()->base_currency}}"
                        showCharge(response, base_currency);
                    } else {
                        amountStatus = false;
                        $('#paymentSummary').html(`<div class="row d-flex text-center justify-content-center">
                                            <div class="col-md-12">
                                                <img src="{{ asset('assets/admin/img/oc-error.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
                                                <p>@lang('Waiting for payment preview')</p>
                                            </div>
                                        </div>`);
                        clearMessage(amountField);
                        $(amountField).addClass('is-invalid');
                        $(amountField).closest('div').find(".invalid-feedback").html(response.message);
                    }


                });
            }


            function showCharge(response, currency) {

                // Function to convert number to words
                function numberToWords(num) {
                    const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 
                        'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
                    const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
                    
                    if (num === 0) return 'Zero';
                    
                    function convertLessThanOneThousand(num) {
                        if (num === 0) return '';
                        if (num < 20) return ones[num];
                        const ten = Math.floor(num / 10);
                        const unit = num % 10;
                        return tens[ten] + (unit ? ' ' + ones[unit] : '');
                    }
                    
                    function convert(num) {
                        if (num === 0) return 'Zero';
                        let result = '';
                        
                        // Handle crores (10,000,000+)
                        if (num >= 10000000) {
                            result += convert(Math.floor(num / 10000000)) + ' Crore ';
                            num %= 10000000;
                        }
                        
                        // Handle lakhs (100,000+)
                        if (num >= 100000) {
                            result += convert(Math.floor(num / 100000)) + ' Lakh ';
                            num %= 100000;
                        }
                        
                        // Handle thousands (1,000+)
                        if (num >= 1000) {
                            result += convertLessThanOneThousand(Math.floor(num / 1000)) + ' Thousand ';
                            num %= 1000;
                        }
                        
                        // Handle hundreds
                        if (num >= 100) {
                            result += ones[Math.floor(num / 100)] + ' Hundred ';
                            num %= 100;
                        }
                        
                        // Handle tens and ones
                        if (num > 0) {
                            if (result !== '') result += 'and ';
                            result += convertLessThanOneThousand(num);
                        }
                        
                        return result;
                    }
                    
                    // Split number into integer and decimal parts
                    const parts = num.toString().split('.');
                    let result = convert(parseInt(parts[0]));
                    
                    // Handle decimal part
                    if (parts.length > 1) {
                        result += ' Point';
                        for (let i = 0; i < parts[1].length; i++) {
                            result += ' ' + ones[parseInt(parts[1][i])];
                        }
                    }
                    
                    return result;
                }
                
                // Convert amount to words
                const amountInWords = numberToWords(parseFloat(response.amount));

                let txnDetails =  ` <div class="side-box">
                    <div class="transfer-details-section">
                        <ul class="transfer-list">
                        <li class="item title">
                             <h5>@lang('Deposit Summary')</h5>
                         </li>
                        <li class="item">
                            <span>{{ __('Amount In') }} ${response.currency} </span>
                            <span class="text-success"> ${response.amount} ${response.currency}</span>
                        </li>
                        
                        <li class="item">
                            <span>{{ __('Amount In Words') }}</span>
                            <span class="text-success"> ${amountInWords} ${response.currency}</span>
                        </li>

                        <li class="item">
                            <span>{{ __('Charge') }}</span>
                            <span class="text-danger">  ${response.charge} ${response.currency}</span>
                        </li>


                        <li class="item">
                            <span>{{ __('Payable Amount') }}</span>
                            <span class=""> ${response.payable_amount} ${response.currency}</span>
                        </li>


                        <li class="item">
                            <span>{{ __('In Base Currency') }}</span>
                            <span class=""> ${response.amount_in_base_currency} ${currency}</span>
                        </li>

                    </ul>
                    <button type="submit" class="cmn-btn w-100">@lang('Make Payment')</button>
                    </div>
                </div>`
                ;
                $('#paymentSummary').html(txnDetails)
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

    </style>
@endpush







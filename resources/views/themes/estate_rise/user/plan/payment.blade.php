@extends(template().'layouts.user')
@section('title',trans('Payment'))
@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Payment')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Payment')</li>
                </ol>
            </nav>
        </div>
        <form action="{{ route('plan.payment.request') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
            <div class="col-lg-7 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-15">@lang('How would you like to pay')?</h4>
                        <!-- Payment section start -->
                        <div class="payment-section">
                            <ul class="payment-container-list">
                                @foreach($gateways as $key => $method)
                                    <li class="item">
                                        <input class="form-check-input selectPayment" value="{{ $method->id }}"  type="radio" name="gateway"
                                               id="{{ $method->name }}">
                                        <label class="form-check-label" for="{{ $method->name }}">
                                            <div class="image-area">
                                                <img src="{{ getFile($method->driver,$method->image ) }}" alt="gateway image">
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
                                <div class="col-md-12 input-box mb-3 add-select-field" >
                                    <select class="form-control"
                                            name="supported_currency"
                                            id="supported_currency">
                                        <option value="">@lang('Select Currency')</option>
                                    </select>
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
                            <h1 class="modal-title" id="staticBackdropLabel">@lang('Payment')</h1>
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
                                <div class="col-md-12 input-box mb-3 add-select-field" >
                                    <select class="form-control"
                                            name="supported_currency"
                                            id="supported_currency">
                                        <option value="">@lang('Select Currency')</option>
                                    </select>
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
                                                <select class="js-example-basic-single form-control"
                                                        name="supported_currency"
                                                        id="supported_currency">
                                                        <option value="">`+'{{trans('Select Currency')}}'+`</option>
                                                </select>`;
                            $('.add-select-field').append(select);

                            $(response.data).each(function (index, value) {
                                let markup = `<option value="${value}">${value}</option>`;
                                $('#supported_currency').append(markup);
                            });
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


            $(document).on('change, input', "#amount, #supported_currency, #supported_crypto_currency", function (e) {

                let amount = '{{$totalPayment}}';
                let selectedCurrency = $('#supported_currency').val();
                let selectedCryptoCurrency = $('#supported_crypto_currency').val();
                let currency_type = 1;

                if (!isNaN(amount) && amount > 0) {

                    let fraction = amount.split('.')[1];
                    let limit = currency_type == 0 ? 8 : 2;

                    if (fraction && fraction.length > limit) {
                        amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
                    }

                    checkAmount(amount, selectedCurrency, selectedGateway, selectedCryptoCurrency)

                    if (selectedCurrency != null) {

                    }
                } else {
                    clearMessage(amountField)
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
                    url: "{{ route('user.payment.checkAmount') }}",
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
                        showCharge(response.data, base_currency);
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


                let txnDetails =  ` <div class="side-box">
                  <div class="transfer-details-section">
                        <ul class="transfer-list">
                        <li class="item title">
                           <h5>@lang('Payment Summary')</h5>
                        </li>
                        <li class="item">
                            <span>{{ __('Amount In') }} ${response.currency} </span>
                            <span class="text-success"> ${response.amount} ${response.currency}</span>
                        </li>

                        <li class="item">
                            <span>{{ __('Charge') }}</span>
                            <span class="text-danger">  ${response.fixed_charge + response.percentage_charge} ${response.currency}</span>
                        </li>


                        <li class="item">
                            <span>{{ __('Payable Amount') }}</span>
                            <span class=""> ${response.payable_amount} ${response.currency}</span>
                        </li>


                        <li class="item">
                            <span>{{ __('In Base Currency') }}</span>
                            <span class=""> ${response.payable_amount_base_in_currency +response.base_currency_charge } ${currency}</span>
                        </li>

                    </ul>
                    <button type="submit" class="cmn-btn w-100">@lang('Make Payment')</button>
                    </div>
                </div>
                `
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


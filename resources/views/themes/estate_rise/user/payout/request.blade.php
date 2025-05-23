@extends(template().'layouts.user')
@section('title', trans('Payout Money'))

@section('content')

    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Payout Money')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Payout Money')</li>
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
                <div class="side-bar">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 input-box mb-3">
                                    <select class="form-control"
                                            name="wallet_type"
                                    >
                                        <option
                                            value="balance"
                                            class="bg-light text-dark">@lang('Deposit Balance - '.currencyPosition(auth()->user()->balance+0))</option>
                                        <option value="interest_balance"
                                                class="bg-light text-dark">@lang('Performance Balance -'.currencyPosition(auth()->user()->profit_balance+0))</option>
                                        <option value="profit_balance"
                                                class="bg-light text-dark">@lang('Profit Balance -'.currencyPosition(auth()->user()->interest_balance+0))</option>
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
        'use strict';

        $(document).on('click','.close-btn',function (){
            $('.payout_alert').remove()
        });

        $(document).ready(function () {
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
                let html = `<div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 input-box mb-3">
                                    <select class="form-control"
                                            name="wallet_type"
                                    >
                                        <option
                                            value="balance"
                                            class="bg-light text-dark">@lang('Deposit Balance - '.currencyPosition(auth()->user()->balance+0))</option>
                                        <option value="interest_balance"
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

                selectedPayoutMethod = $(this).val();
                supportCurrency(selectedPayoutMethod);
            });

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

    </style>
@endpush

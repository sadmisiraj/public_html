@extends(template().'layouts.user')
@section('title', trans('Payout Money'))

@section('content')
    <section class="payment-gateway mt-5 pt-5">
        <div class="container-fluid">
            <div class="row ">
                <div class="col">
                    <div class="header-text-full mb-0">
                        <h2>@lang('Payout Money')</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(!isActivePayout())
                    <div class="col-12 payout_alert">
                        <div
                            class="bd-callout bd-callout-primary alert d-flex flex-wrap justify-content-between align-items-center"
                            role="alert">
                            <div class="d-flex flex-wrap align-items-center">
                                <i class="fas fa-info-circle me-2"></i> <h5 class="mb-0">
                                    {{ __('Today Withdraw feature is off. Please try on one of these days:') }}
                                    @foreach (getWithdrawDays() as $key => $day)
                                        {{ ucfirst($day) }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach</h5>

                            </div>
                            <button class="close-btn pt-1 btn btn-dark"><i class="text-white fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
            <div class="mt-0 checkout-section">
                <div class="card p-4 padding-payout">
                    <form action="{{ route('user.payout.request') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4 g-lg-5">
                            <div class="col-md-12 col-lg-7">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <div class="payment-box mb-4">
                                            <h5 class="payment-option-title ">@lang('Select Payout Method')</h5>
                                            <div class="payment-option-wrapper">
                                                <div class="payment-section">
                                                    <ul class="payment-container-list">
                                                        @forelse($payoutMethod as $method)
                                                            <li class="item">
                                                                <input class="form-check-input selectPayoutMethod"
                                                                       value="{{ $method->id }}" type="radio"
                                                                       name="payout_method_id"
                                                                       id="{{ $method->name }}">
                                                                <label class="form-check-label"
                                                                       for="{{ $method->name }}">
                                                                    <div class="image-area">
                                                                        <img
                                                                            src="{{ getFile($method->driver,$method->logo ) }}"
                                                                            alt="">
                                                                    </div>
                                                                    <div class="content-area">
                                                                        <h5>{{$method->name}}</h5>
                                                                        <span>{{$method->description}}</span>
                                                                    </div>
                                                                </label>

                                                            </li>
                                                        @empty
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-lg-5">
                                <div class="side-bar mt-5">
                                    <div class="side-box mt-2">
                                        <div class="col-md-12 input-box mb-3">
                                            <select class="form-control"
                                                    name="wallet_type"
                                            >
                                                <option
                                                    value="balance" class="bg-light text-dark">@lang('Deposit Balance')
                                                    - {{currencyPosition(auth()->user()->balance+0)}}</option>
                                                <option value="interest_balance"
                                                        class="bg-light text-dark">@lang('Interest Balance')
                                                    - {{currencyPosition(auth()->user()->interest_balance+0)}}</option>
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
                                                <img src="{{ asset('assets/admin/img/oc-error-light.svg') }}"
                                                     id="no-data-image" class="no-data-image" alt="" srcset="">
                                                <p>@lang('Waiting for payout preview')</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div id="staticBackdrop" class="modal fade paymentModal" tabindex="-1" role="dialog"
                             data-bs-backdrop="static">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content form-block">
                                    <div class="modal-header">
                                        <h4 class="modal-title method-name golden-text">@lang('Withdraw')</h4>
                                        <button
                                            type="button"
                                            data-bs-dismiss="modal"
                                            class="btn-close"
                                            aria-label="Close"
                                        >
                                            <img src="{{asset(template(true).'img/icon/cross.png')}}"
                                                 alt="@lang('modal dismiss')"/>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="paymentModalBody">

                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        'use strict';
        $(document).on('click', '.close-btn', function () {
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
                let html = `<div class="side-box mt-2">
                                    <div class="col-md-12 input-box mb-3">
                                        <select class="form-control"
                                                name="wallet_type"
                                        >
                                            <option
                                                value="balance" class="bg-light text-dark">@lang('Deposit Balance') - {{currencyPosition(auth()->user()->balance+0)}}</option>
                                            <option value="interest_balance" class="bg-light text-dark">@lang('Interest Balance') - {{currencyPosition(auth()->user()->interest_balance+0)}}</option>
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
                <img src="{{ asset('assets/admin/img/oc-error-light.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
                                            <p>@lang('Waiting for payout preview')</p>
                                        </div>
                                    </div>
                                </div>`;
                if (updatedWidth <= 991) {
                    $('.side-bar').html('');
                    $('#paymentModalBody').html(html);
                    let paymentModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
                    paymentModal.show()
                } else {
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
                                                        <img src="{{ asset('assets/admin/img/oc-error-light.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
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
                        // submitButton();
                        $('#payoutSummary').html(`<div class="row d-flex text-center justify-content-center">
                                                    <div class="col-md-12">
                                                        <img src="{{ asset('assets/admin/img/oc-error-light.svg') }}" id="no-data-image" class="no-data-image" alt="" srcset="">
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

                let txnDetails = `<div class="side-box">
                    <h5>@lang('Payout Summary')</h5>
                    <div class="showCharge">
                        <ul class="list-group">
						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Amount In') }} ${response.currency} </span>
							<span class="text-success"> ${response.amount} ${response.currency}</span>
						</li>

						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Charge') }}</span>
							<span class="text-danger">  ${response.charge} ${response.currency}</span>
						</li>


						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Payout Amount') }}</span>
							<span class=""> ${response.net_payout_amount} ${response.currency}</span>
						</li>


						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('In Base Currency') }}</span>
							<span class=""> ${response.amount_in_base_currency} ${currency}</span>
						</li>
					</ul>
                    </div>
                </div>
               <button type="submit" class="gold-btn">@lang('Withdraw')</button>`;
                $('#payoutSummary').html(txnDetails)
            }


        });


    </script>
@endpush

@push('style')
    <style>
        .checkout-section .payment-option-title {
            margin-bottom: 25px !important;
            margin-top: 10px !important;
            margin-left: 30px;
            font-size: 25px;

        }

        .payout_alert i {
            background: linear-gradient(135deg, #b38728, #fcf6ba, #bf953f, #fbf5b7, #aa771c);
            font-size: 18px;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .payout_alert h5 {
            font-size: 16px;
        }
    </style>
@endpush


@push('style')
    <style>
        .paymentModal button {
            margin-top: 20px !important;
        }

        @media only screen and (max-width: 991px) {
            .side-bar {
                display: none;
            }

            .side-box {
                margin-top: 0rem !important;
            }


        }

        @media only screen and (max-width: 420px) {
            .payment-section .payment-container-list .gateway-description {
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

            .payment-section ul {
                padding-left: 0;
            }

            .checkout-section .payment-box .payment-option-wrapper {
                padding: 0;
            }

            .checkout-section {
                padding: 8px;
            }

        }

    </style>
@endpush


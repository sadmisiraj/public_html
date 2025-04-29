@extends(template().'layouts.user')
@section('title', trans('Payout Money'))

@section('content')

    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">@lang('Payout Money')</h3>
                </div>
            </div>
            @if(!isActivePayout())
                <div class="col-12 payout_alert">
                    <div class="bd-callout bd-callout-primary alert d-flex justify-content-between align-items-center"
                         role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fal fa-info-circle me-2"></i> <h5 class="mb-0">
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
            <div class="row">
                <div class="mt-3 checkout-section">
                    <div class="card p-4 padding-payout">
                        <form action="{{ route('user.payout.request') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4 g-lg-5">
                                <div class="col-md-12 col-lg-7">
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <div class="payment-box mb-4">
                                                <h5 class="payment-option-title mb-5">@lang('Select Payout Method')</h5>
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
                                                        value="balance"
                                                        class="bg-light text-dark">@lang('Deposit Balance - '.currencyPosition(auth()->user()->balance+0))</option>
                                                    <option value="interest_balance"
                                                            class="bg-light text-dark">@lang('Interest Balance -'.currencyPosition(auth()->user()->interest_balance+0))</option>
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

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="investModalLabel"
                                 aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="investModalLabel">@lang('Withdraw')</h4>
                                            <button type="button" class="close-btn" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                <i class="fal fa-times"></i>
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
        </div>
    </div>

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
                let html = `  <div class="side-box mt-2">
                                            <div class="col-md-12 input-box mb-3">
                                                <select class="form-control"
                                                        name="wallet_type"
                                                >
                                                    <option
                                                        value="balance" class="bg-light text-dark">@lang('Deposit Balance - '.currencyPosition(auth()->user()->balance+0))</option>
                                                    <option value="interest_balance" class="bg-light text-dark">@lang('Interest Balance -'.currencyPosition(auth()->user()->interest_balance+0))</option>
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
               <button type="submit" class="btn btn-primary base-btn btn-block btn-rounded">@lang('Withdraw')</button>`;
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
        }

        .payout_alert i {
            color: var(--primary);
            font-size: 18px;
        }

        .payout_alert h5 {
            font-size: 16px;
        }

        .paymentModal button {
            margin-top: 20px;
        }

        @media only screen and (max-width: 991px) {
            .side-bar {
                display: none;
            }

            .paymentModal {
                display: block !important;
            }
        }
    </style>
@endpush

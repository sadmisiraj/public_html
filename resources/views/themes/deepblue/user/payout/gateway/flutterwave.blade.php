@extends(template().'layouts.user')
@section('title',__('Payout'))
@section('content')
    <section id="dashboard">
        <div class="container-fluid">
            <div class="main row">
                <div class="col-12">
                    <section class="profile-setting">
                        <div class="row g-5">
                            <div class="col-lg-6 mbc">
                                <div class="sidebar-wrapper">
                                    <form action="{{ route('user.payout.flutterwave',$payout->trx_id) }}"
                                          method="post"
                                          enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" class="type" name="type" value="">
                                        <div class="row g-4">
                                            @if($payoutMethod->supported_currency)
                                                <div class="col-md-12 mb-3">
                                                    <div class="input-box search-currency-dropdown">
                                                        <label class="mb-2" for="from_wallet">@lang('Select Bank Currency')</label>
                                                        <input type="text" name="currency_code"
                                                               placeholder="Selected"
                                                               autocomplete="off"
                                                               value="{{ $payout->payout_currency_code }}"
                                                               class="form-control transfer-currency @error('currency_code') is-invalid @enderror">

                                                        @error('currency_code')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endif


                                            <div class="col-md-12 input-box mb-3">
                                                <label class="mb-2" for="from_wallet">@lang('Select Transfer')</label>
                                                <select id="from_wallet" name="transfer_name"
                                                        class="form-control form-control-sm bank">
                                                    <option value=""
                                                            selected="">@lang('Select Transfer')</option>
                                                    @foreach($payoutMethod->banks as $bank)
                                                        <option
                                                            value="{{$bank}}" {{old('transfer_name') == $bank ?'selected':''}}>{{$bank}}</option>
                                                    @endforeach
                                                </select>
                                                @error('transfer_name')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-12 input-box dynamic-bank mx-1 d-none mb-3">
                                                <label class="mb-2">@lang('Select Bank')</label>
                                                <select id="dynamic-bank" name="bank"
                                                        class="form-control js-example-basic-single">
                                                </select>
                                                @error('bank')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="row dynamic-input">

                                            </div>

                                            @if($payoutMethod->automatic_payout_permisstion)
                                                <div class="input-box mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="automatic_payout_permisstion" type="checkbox" value="1"/>
                                                        <label class="form-check-label" for="tandc">
                                                            @lang('Automatic Payout')
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="input-box col-12">
                                                <button type="submit" class="btn btn-primary base-btn btn-block btn-rounded">@lang('submit')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div id="tab1" class="content active">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>@lang('Payout Method')</span>
                                            <span class="text-info">{{ __($payoutMethod->name) }} </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>@lang('Request Amount')</span>
                                            <span
                                                class="text-success">{{ (getAmount($payout->amount)) }} {{ $payout->payout_currency_code }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>@lang('Charge')</span>
                                            <span
                                                class="text-success">{{ (getAmount($payout->charge)) }} {{ $payout->payout_currency_code }}</span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>@lang('Charge Percentage')</span>
                                            <span
                                                class="text-success">{{ (getAmount($payout->net_amount)) }} {{ $payout->payout_currency_code }}</span>
                                        </li>


                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>@lang('Amount In Base Currency')</span>
                                            <span
                                                class="text-success">{{ (getAmount($payout->net_amount_in_base_currency)) }} {{ $basic->base_currency }}</span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
    <script type="text/javascript">
        'use strict';

        var bankName = null;
        var payAmount = '{{$payout->amount}}'
        var baseCurrency = "{{config('basic.base_currency_code')}}"
        var transferName = "{{old('transfer_name')}}";
        if (transferName) {
            getBankForm(transferName);
        }


        $(document).ready(function () {
            $(document).on("change", ".bank", function () {
                bankName = $(this).val();
                $('.dynamic-bank').addClass('d-none');
                getBankForm(bankName);
            })
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getBankForm(bankName) {
            $.ajax({
                url: "{{route('user.payout.getBankForm')}}",
                type: "post",
                data: {
                    bankName,
                },
                success: function (response) {
                    if (response.bank != null) {
                        showBank(response.bank.data)
                    }
                    showInputForm(response.input_form)
                }
            });
        }

        function showBank(bankLists) {
            $('#dynamic-bank').html(``);
            var options = `<option disabled selected>@lang("Select Bank")</option>`;
            for (let i = 0; i < bankLists.length; i++) {
                options += `<option value="${bankLists[i].code}">${bankLists[i].name}</option>`;
            }

            $('.dynamic-bank').removeClass('d-none');
            $('#dynamic-bank').html(options);
        }

        function showInputForm(form_fields) {
            $('.dynamic-input').html(``);
            var output = "";

            for (let field in form_fields) {
                let newKey = field.replace('_', ' ');
                output += `<div class="col-md-12 mb-3">
                         <label class="mb-2">${newKey}</label>
				         <input type="text" name="${field}" value="" class="form-control" required>
			          </div>`
            }
            $('.dynamic-input').html(output);
        }

    </script>

@endpush


@push('style')
    <style>

        .mbc {
            margin-bottom: 20px !important;
        }
        .sidebar-wrapper select{
            background: transparent;
            color: #FFFFFF;
        }

        .sidebar-wrapper .row {
            display: block;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: 0;
            margin-left: 0;
        }

        .sidebar-wrapper input{
            padding-left: 17px;
        }

        .sidebar-wrapper select:focus{
            background: transparent;
        }
        .sidebar-wrapper select option{
           background: var(--background-1);
        }
        .list-group{
            border: 1px solid var(--bordercolor);
        }
        .list-group li {
            border-bottom: 1px solid var(--bordercolor);
        }
        #dashboard{
            margin-top: 55px!important;
        }
        .form-control {
            padding: 0 0 0 17px;
        }

        .sidebar-wrapper{
            background: transparent;
            border: 1px solid var(--bordercolor)!important;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .image-inputs {
            position: relative;
            padding: 20px;
            border: 2px dashed #ddd;
            cursor: pointer;
            height: 230px !important;
            width: 288px;
        }

        .preview-image{
            max-height: 186px;
            width: 243px;
        }

        .image-inputs input#image-upload {
            position: absolute;
            width: 84%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            max-height: 185px;
            padding: 0;
        }

        .image-inputs #image-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .image-inputs #image-label i {
            font-size: 24px;
            color: var(--primary);
            opacity: 0.5;
        }
        .form-control:focus {
            color: #FFFFFF;
            outline: 0;
            box-shadow: none;
        }
        .card-body textarea:focus{
            background: transparent;
        }

        .card-body textarea{
            line-height: 2;
        }
    </style>
@endpush

@extends(template().'layouts.user')
@section('title',trans('Payout Log'))

@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true).'css/bootstrap-datepicker.css') }}"/>
@endpush

@section('content')
    <section class="transaction-history mt-5 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="header-text-full">
                        <h2>{{trans('Payout Log')}}</h2>
                    </div>
                </div>
            </div>

            <form action="{{route('user.payout.index')}}" method="get">
                <div class="row select-transaction">
                    <div class="col-md-6 col-lg-4">
                        <div class="input-group mb-4">
                            <div class="img">
                                <img src="{{asset(template(true).'img/icon/edit.png')}}" alt="@lang('edit img')" />
                            </div>
                            <input
                                type="text"
                                name="trx_id"
                                value="{{@request()->trx_id}}"
                                class="form-control"
                                placeholder="@lang('Transaction ID')"
                            />
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="input-group mb-4">
                            <div class="img">
                                <img src="{{asset(template(true).'img/icon/chevron.png')}}" alt="@lang('chevron img')" />
                            </div>
                            <select
                                name="status"
                                class="form-select"
                                id="salutation"
                                aria-label="Default select example"
                            >
                                <option value="">@lang('All Payment')</option>
                                <option value="1"
                                        @if(@request()->status == '1') selected @endif>@lang('Pending Payment')</option>
                                <option value="2"
                                        @if(@request()->status == '2') selected @endif>@lang('Complete Payment')</option>
                                <option value="3"
                                        @if(@request()->status == '3') selected @endif>@lang('Rejected Payment')</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="input-group mb-4">
                            <div class="img">
                                <img src="{{asset(template(true).'img/icon/chevron.png')}}" alt="@lang('chevron img')" />
                            </div>
                            <input type="text" class="form-control" name="date_time"
                                   id="datepicker" placeholder="@lang('Select a date')" autocomplete="off" readonly/>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <button type="submit" class="gold-btn search-btn mb-4">
                            @lang('Search')
                        </button>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col">
                    <div class="table-parent table-responsive">
                        <table class="table table-striped mb-5">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Transaction ID')</th>
                                <th scope="col">@lang('Gateway')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Charge')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Time')</th>
                                <th scope="col">@lang('Detail')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($payouts as $item)
                                <tr>
                                    <td>{{$item->trx_id}}</td>
                                    <td>@lang(optional($item->method)->name)</td>
                                    <td>{{ $item->amount+0 .' '.$item->payout_currency_code  }}</td>
                                    <td>{{ $item->charge+0 .' '.$item->payout_currency_code  }} </td>
                                    <td>
                                        @if($item->status == 0)
                                            <span class="badge  bg-warning">@lang('Pending')</span>
                                        @elseif($item->status == 1)
                                            <span class="badge  bg-info">@lang('Generated')</span>
                                        @elseif($item->status == 2)
                                            <span class="badge  bg-success">@lang('Complete')</span>
                                        @elseif($item->status == 3)
                                            <span class="badge  bg-danger">@lang('Cancel')</span>
                                        @endif

                                    </td>
                                    <td>{{ dateTime($item->created_at, 'd M Y h:i A') }}</td>
                                    <td>
                                        @if($item->status == 0)
                                            <a href="{{ route('user.payout.confirm',$item->trx_id) }}" target="_blank"
                                               class="gold-btn btn"> @lang('Confirm') <span></span></a>
                                        @else
                                            <button
                                                type="button"
                                                class="btn btn-success btn-sm infoButton"
                                                data-information="{{json_encode($item->getInformation())}}"
                                                data-feedback="{{$item->feedback}}"
                                                data-trx_id="{{ $item->trx_id }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#infoModal"
                                            >
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="100%" class="text-center">{{__('No Data Found!')}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{ $payouts->appends($_GET)->links(template().'partials.user-pagination') }}

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title golden-text" id="infoModalLabel">
                        @lang('Details')
                    </h3>
                    <button
                        type="button"
                        data-bs-dismiss="modal"
                        class="btn-close"
                        aria-label="Close"
                    >
                        <img src="{{asset(template(true).'img/icon/cross.png')}}" alt="@lang('cross img')" />
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-primary bg-transparent lebelFont text-white">@lang('Transactions')
                            : <span class="trx"></span>
                        </li>
                        <li class="list-group-item list-group-item-primary bg-transparent lebelFont text-white">@lang('Admin Feedback')
                            : <span
                                class="feedback"></span></li>
                    </ul>
                    <div class="payout-detail text-white">

                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="gold-btn"
                        data-bs-dismiss="modal">
                        @lang('Close')
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset(template(true).'js/bootstrap-datepicker.js') }}"></script>
    <script>
        'use strict'
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>

    <script>
        "use strict";

        $(document).ready(function () {
            $('.infoButton').on('click', function () {
                var infoModal = $('#infoModal');
                infoModal.find('.trx').text($(this).data('trx_id'));
                infoModal.find('.feedback').text($(this).data('feedback'));
                var list = [];
                var information = Object.entries($(this).data('information'));


                var ImgPath = "{{asset(config('location.withdrawLog.path'))}}/";
                var result = ``;

                information.forEach((value,index)=>{

                    if (information[index][1].type == 'file') {
                        result += `<li class="list-group-item bg-transparent customborder lebelFont text-white">
                                            <span class="font-weight-bold "> ${information[index][1].field_name.split('_')
                            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                            .join(' ')} </span> : <img src="${information[index][1].field_value}" alt="..." class="w-100 mt-2 payoutImage" >
                                        </li>`;
                    } else {
                        result += `<li class="list-group-item bg-transparent customborder lebelFont text-white">
                                            <span class="font-weight-bold "> ${information[index][1].field_name.split('_')
                            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                            .join(' ')} </span> : <span class="font-weight-bold ml-3">${information[index][1].field_value}</span>
                                        </li>`;
                    }

                })

                if (result) {
                    infoModal.find('.payout-detail').html(`<br><h4 class="my-3 golden-text">@lang('Payment Information')</h4>  ${result}`);
                } else {
                    infoModal.find('.payout-detail').html(`${result}`);
                }
                infoModal.modal('show');
            });


            $('.closeModal').on('click', function (e) {
                $("#infoModal").modal("hide");
            });
        });

    </script>
@endpush

@push('style')
    <style>
        .payoutImage {
            height: 100px;
            width: 100px!important;
        }
    </style>
@endpush


@extends(template().'layouts.user')
@section('title',trans('Payout Log'))

@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true).'css/bootstrap-datepicker.css') }}"/>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3"
                >
                    <h3 class="mb-0">@lang('Payout Log')</h3>
                </div>

                <!-- table -->
                <div class="table-parent table-responsive">
                    <div class="table-search-bar">
                        <div class="d-none d-lg-block">
                            <form action="{{route('user.payout.index')}}" method="get"
                                  enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="input-box">
                                            <input
                                                type="text"
                                                name="trx_id"
                                                value="{{@request()->trx_id}}"
                                                class="form-control"
                                                placeholder="@lang('Transaction ID')"
                                            />
                                        </div>
                                    </div>

                                    <div class="input-box col-lg-3 col-md-3 col-sm-12">
                                        <select name="status" id="package_status"
                                                class="form-control js-example-basic-single">
                                            <option value="">@lang('All Payment')</option>
                                            <option value="1"
                                                    @if(@request()->status == '0') selected @endif>@lang('Pending Payment')</option>
                                            <option value="2"
                                                    @if(@request()->status == '2') selected @endif>@lang('Complete Payment')</option>
                                            <option value="3"
                                                    @if(@request()->status == '3') selected @endif>@lang('Rejected Payment')</option>
                                        </select>
                                    </div>

                                    <div class="input-box col-lg-3 col-md-3 col-sm-12">
                                        <input type="text" class="form-control datepicker" name="date_time"
                                               autocomplete="off" readonly placeholder="@lang('Select a date')"
                                               value="{{ old('date_time',request()->date_time) }}">
                                    </div>


                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <button class="btn-custom w-100" type="submit">@lang('Search')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped">
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
                                           class="btn btn-primary"><i class="fa-thin fa-square-check"></i> @lang('Confirm') <span></span></a>
                                    @else
                                        <button
                                            type="button"
                                            class="btn infoButton payoutHistoryBtn"
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


    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">
                        @lang('Details')
                    </h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-primary bg-transparent lebelFont darkblue-text">@lang('Transactions')
                            : <span class="trx"></span>
                        </li>
                        <li class="list-group-item list-group-item-primary bg-transparent lebelFont darkblue-text">@lang('Admin Feedback')
                            : <span
                                class="feedback"></span></li>
                    </ul>
                    <div class="payout-detail darkblue-text">

                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="gold-btn btn-custom w-25 p-3 text-white"
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
                        result += `<li class="list-group-item bg-transparent customborder lebelFont darkblue-text">
                                            <span class="font-weight-bold "> ${information[index][1].field_name.split('_')
                            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                            .join(' ')} </span> : <img src="${information[index][1].field_value}" alt="..." class="w-100 mt-2 payoutImage" >
                                        </li>`;
                    } else {
                        result += `<li class="list-group-item bg-transparent customborder lebelFont darkblue-text">
                                            <span class="font-weight-bold "> ${information[index][1].field_name.split('_')
                            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                            .join(' ')} </span> : <span class="font-weight-bold ml-3">${information[index][1].field_value}</span>
                                        </li>`;
                    }

                })

                if (result) {
                    infoModal.find('.payout-detail').html(`<br><h4 class="my-3 darkblue-text">@lang('Payment Information')</h4>  ${result}`);
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


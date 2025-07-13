@extends(template().'layouts.user')
@section('title',trans('Payout Log'))

@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true).'css/bootstrap-datepicker.css') }}"/>
@endpush

@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Payout Log')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Payout Log')</li>
                </ol>
            </nav>
        </div>

        <!-- Cmn table section start -->
        <div class="card">
            <div class="card-header d-flex justify-content-between pb-0 border-0">
                <h4>@lang('Payout History')</h4>
                <button type="button" class="cmn-btn" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">@lang('Filter')<i
                        class="fa-regular fa-filter"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="cmn-table">
                    <div class="table-responsive overflow-hidden">
                        <table class="table table-striped align-middle">
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
                                    <td>
                                        @php
                                            $method = optional($item->method);
                                            if (is_null($method)) {
                                                echo 'Method Not Found';
                                            } else {
                                                echo __($method->name);
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $item->amount+0 .' '.$item->payout_currency_code  }}</td>
                                    <td>{{ $item->charge+0 .' '.$item->payout_currency_code  }} </td>
                                    <td>
                                        @if($item->status == 0)
                                            <span class="badge  text-bg-warning">@lang('Pending')</span>
                                        @elseif($item->status == 1)
                                            <span class="badge  text-bg-info">@lang('Generated')</span>
                                        @elseif($item->status == 2)
                                            <span class="badge  text-bg-success">@lang('Complete')</span>
                                        @elseif($item->status == 3)
                                            <span class="badge  text-bg-danger">@lang('Cancel')</span>
                                        @endif
                                    </td>
                                    <td>{{ dateTime($item->created_at, 'd M Y h:i A') }}</td>
                                    <td>
                                        @if($item->status == 0)
                                            <a href="{{ route('user.payout.confirm',$item->trx_id) }}" target="_blank"
                                               class="cmn-btn"><i class="fas fa-check-circle"></i> @lang('Confirm') <span></span></a>
                                        @else
                                            <button
                                                type="button"
                                                class="btn infoButton payoutHistoryBtn"
                                                data-information="@php
                                                    try {
                                                        echo json_encode($item->getInformation() ?: []);
                                                    } catch (\Exception $e) {
                                                        echo json_encode([]);
                                                    }
                                                @endphp"
                                                data-feedback="{{$item->feedback}}"
                                                data-trx_id="{{ $item->trx_id }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#infoModal"
                                            >
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <a href="{{ route('user.payout.invoice', $item->trx_id) }}" class="btn btn-primary btn-sm" target="_blank">
                                                <i class="fa fa-download"></i> @lang('Invoice')
                                            </a>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="100%" class="text-center">
                                        <div class="text-center p-4">
                                            <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                            <p class="mb-0">@lang('No data to show')</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cmn table section end -->

        <!-- pagination section start -->
        <div class="pagination-section">
            {{ $payouts->appends($_GET)->links(template().'partials.pagination') }}
        </div>
        <!-- pagination section end -->
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
                    <div class="transfer-details-section">
                    <ul class="transfer-list">
                        <li class="item"><span>@lang('Transactions')</span>
                             <span class="trx"></span>
                        </li>
                        <li class="item"><span>@lang('Admin Feedback')</span>
                             <span
                                class="feedback"></span></li>
                    </ul>
                    </div>
                    <div class="transfer-details-section">
                            <ul class="transfer-list payout-detail">

                            </ul>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="cmn-btn" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas sidebar start -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">@lang('Payout history filter')</h5>
            <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-light fa-arrow-right"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('user.payout.index')}}" method="get">
                <div class="row g-4">
                    <div>
                        <label for="ProductName" class="form-label">@lang('Transaction ID')</label>
                        <input type="text" name="trx_id" value="{{@request()->trx_id}}" class="form-control" id="ProductName">
                    </div>

                    <div>
                        <label for="NumberOfSales" class="form-label">@lang('Select a date')</label>
                        <input type="date" class="form-control" name="date_time" value="{{ old('date_time',request()->date_time) }}" id="NumberOfSales">
                    </div>

                    <div id="formModal">
                        <label class="form-label">@lang('status')</label>
                        <select class="modal-select" name="status">
                            <option value="">@lang('All Payment')</option>
                            <option value="1"
                                    @if(@request()->status == '0') selected @endif>@lang('Pending Payment')</option>
                            <option value="2"
                                    @if(@request()->status == '2') selected @endif>@lang('Complete Payment')</option>
                            <option value="3"
                                    @if(@request()->status == '3') selected @endif>@lang('Rejected Payment')</option>
                        </select>
                    </div>
                    <div class="btn-area">
                        <button type="submit" class="cmn-btn">@lang('Filter')</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- Offcanvas sidebar end -->
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
                        result += `<li class="item">
                                            <span class="font-weight-bold "> ${information[index][1].field_name.split('_')
                            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                            .join(' ')} </span>  <span><img src="${information[index][1].field_value}" alt="..." class="w-100 mt-2 payoutImage" ></span>
                                        </li>`;
                    } else {
                        result += `<li class="item">
                                            <span class="font-weight-bold "> ${information[index][1].field_name.split('_')
                            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                            .join(' ')} </span>  <span class="font-weight-bold ml-3">${information[index][1].field_value}</span>
                                        </li>`;
                    }

                })

                if (result) {
                    infoModal.find('.payout-detail').html(`<li class="item title"><h5>@lang('Payment Information')</h5></li>  ${result}`);
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


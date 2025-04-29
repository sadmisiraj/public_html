@extends(template().'layouts.user')
@section('title',trans('Payout Log'))
@section('content')
    @push('navigator')
        <section id="page-navigator">
            <div class="container-fluid">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}"> @lang('Home') </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"
                                                       class="cursor-inherit">{{trans('Payout Log')}}</a></li>
                    </ol>
                </div>
            </div>
        </section>
    @endpush

    <section id="dashboard">
        <div class="dashboard-wrapper add-fund pb-50">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card secbg form-block p-0 br-4">
                        <div class="card-body">
                            <form action="{{ route('user.payout.index') }}" method="get">
                                <div class="row justify-content-between">
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <input
                                                type="text"
                                                name="trx_id"
                                                value="{{@request()->trx_id}}"
                                                class="form-control"
                                                placeholder="@lang('Transaction ID')"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group mb-2">
                                            <select name="status" class="form-control">
                                                <option value="">@lang('All Payment')</option>
                                                <option value="1"
                                                        @if(@request()->status == '0') selected @endif>@lang('Pending Payment')</option>
                                                <option value="2"
                                                        @if(@request()->status == '2') selected @endif>@lang('Complete Payment')</option>
                                                <option value="3"
                                                        @if(@request()->status == '3') selected @endif>@lang('Rejected Payment')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group mb-2">
                                            <input type="date" class="form-control datepicker" name="date_time"
                                                   autocomplete="off"  placeholder="@lang('Select a date')"
                                                   value="{{ old('date_time',request()->date_time) }}">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group mb-2 h-fill">
                                            <button type="submit" class="btn btn-primary  base-btn w-fill h-fill">
                                                <i
                                                    class="fas fa-search"></i> @lang('Search')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-30">
                <div class="col-md-12">
                    <div class="card secbg ">
                        <div class="card-body ">

                            <div class="table-responsive">
                                <table class="table table-hover table-striped text-white" id="service-table">
                                    <thead class="thead-dark">
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
                                                       class="btn btn-primary  base-btn w-fill h-fill"><i class="fa-thin fa-square-check"></i> @lang('Confirm') <span></span></a>
                                                @else
                                                    <button
                                                        type="button"
                                                        class="btn btn-info btn-sm infoButton "
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
                                            <td colspan="100%" class="text-center">
                                                <div class="text-center p-4">
                                                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                                    <p class="mb-0">@lang('No data to show')</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                            </div>
                            {{ $payouts->appends($_GET)->links(template().'partials.pagination') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="infoModal" class="modal fade" tabindex="-1" data-backdrop="static"  role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content form-block">

                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group ">
                        <li class="list-group-item bg-transparent">@lang('Transactions') : <span class="trx"></span>
                        </li>
                        <li class="list-group-item bg-transparent">@lang('Admin Feedback') : <span
                                class="feedback"></span></li>
                    </ul>
                    <div class="payout-detail">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light closeModal" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

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
                        result += `<li class="list-group-item bg-transparent">
                                            <span class="font-weight-bold "> ${information[index][1].field_name.split('_')
                            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                            .join(' ')} </span> : <img src="${information[index][1].field_value}" alt="..." class="w-100 mt-2 payoutImage" >
                                        </li>`;
                    } else {
                        result += `<li class="list-group-item bg-transparent">
                                            <span class="font-weight-bold "> ${information[index][1].field_name.split('_')
                            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                            .join(' ')} </span> : <span class="font-weight-bold ml-3">${information[index][1].field_value}</span>
                                        </li>`;
                    }

                })

                if (result) {
                    infoModal.find('.payout-detail').html(`<br><strong class="my-3">@lang('Payment Information')</strong>  ${result}`);
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
            height: 80px;
            width: 80px!important;
            margin-left: 10px;

        }
    </style>
@endpush

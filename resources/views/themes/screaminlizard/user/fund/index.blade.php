@extends(template().'layouts.user')
@section('title',trans('Fund History'))

@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3"
                >
                    <h3 class="mb-0">@lang('Fund History')</h3>
                </div>

                <!-- table -->
                <div class="table-parent table-responsive">
                    <div class="table-search-bar">
                        <div class="d-none d-lg-block">
                            <form action="{{route('user.fund.index')}}" method="get" enctype="multipart/form-data">
                                <div class="row g-3 align-items-end">
                                    <div class="input-box col-lg-3 col-md-6 col-xl-3">
                                        <input
                                            type="text"
                                            name="trx_id"
                                            value="{{@request()->trx_id}}"
                                            class="form-control"
                                            placeholder="@lang('Transaction ID')"
                                        />
                                    </div>
                                    <div class="input-box col-lg-3 col-md-6 col-xl-3">
                                        <select name="status" id="package_status" class="form-control js-example-basic-single">
                                            <option value="all">@lang('All Payment')</option>
                                            <option value="1"
                                                    @if(@request()->status == '1') selected @endif>@lang('Complete Payment')</option>
                                            <option value="2"
                                                    @if(@request()->status == '0') selected @endif>@lang('Pending Payment')</option>
                                            <option value="3"
                                                    @if(@request()->status == '3') selected @endif>@lang('Cancel Payment')</option>
                                        </select>
                                    </div>
                                    <div class="input-box col-lg-3 col-md-6 col-xl-3">
                                        <input type="text" class="form-control datepicker"  name="date_time" autocomplete="off" readonly placeholder="@lang('Select a date')" value="{{ old('date_time',request()->date_time) }}">
                                    </div>
                                    <div class="input-box col-lg-3 col-md-6 col-xl-3">
                                        <button class="btn-custom w-100"><i class="fal fa-search"></i> @lang('Search') </button>
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
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($funds as $data)
                            <tr>
                                <td>{{$data->trx_id}}</td>
                                <td>@lang(optional($data->gateway)->name)</td>
                                <td>{{ currencyPosition($data->payable_amount_in_base_currency+0)  }}</td>
                                <td>{{ currencyPosition($data->base_currency_charge+0) }}</td>
                                <td>
                                    @if($data->status == 1)
                                        <span class="badge bg-success">@lang('Complete')</span>
                                    @elseif($data->status == 2)
                                        <span class="badge bg-warning">@lang('Pending')</span>
                                    @elseif($data->status == 3)
                                        <span class="badge bg-danger">@lang('Cancel')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('Pending')</span>
                                    @endif
                                </td>
                                <td>{{ dateTime($data->created_at, 'd M Y h:i A') }}</td>
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
                    {{ $funds->appends($_GET)->links(template().'partials.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset(template(true).'js/bootstrap-datepicker.js')}}"></script>
    <script>
        'use strict'
        $(document).ready(function () {
            $(".datepicker").datepicker({
                autoclose: true,
                clearBtn: true,
                format: 'yyyy-mm-dd'
            });
        });
    </script>
@endpush

@extends(template().'layouts.user')
@section('title',trans('Fund Deposit History'))

@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true).'css/bootstrap-datepicker.css') }}"/>
@endpush

@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Fund Deposit History')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Fund Deposit History')</li>
                </ol>
            </nav>
        </div>

        <!-- Cmn table section start -->
        <div class="card">
            <div class="card-header d-flex justify-content-between pb-0 border-0">
                <h4>@lang('Fund History')</h4>
                <div class="btn-area gap-3 d-flex">
                    <button type="button" class="cmn-btn" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">@lang('Filter')<i
                            class="fa-regular fa-filter"></i>
                    </button>
                </div>
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
                                            <span class="badge rounded-pill text-bg-success">@lang('Complete')</span>
                                        @elseif($data->status == 2)
                                            <span class="badge rounded-pill text-bg-warning">@lang('Pending')</span>
                                        @elseif($data->status == 3)
                                            <span class="badge rounded-pill text-bg-danger">@lang('Cancel')</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-warning">@lang('Pending')</span>
                                        @endif
                                    </td>
                                    <td>{{ dateTime($data->created_at, 'd M Y h:i A') }}</td>
                                </tr>

                            @empty
                                <tr class="text-center">
                                    <td colspan="100%" class="text-center">
                                        <div class="text-center p-4">
                                            <img class="dataTables-image mb-3"
                                                 src="{{ asset('assets/admin/img/oc-error.svg') }}"
                                                 alt="Image Description" data-hs-theme-appearance="default">
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
            {{ $funds->appends($_GET)->links(template().'partials.pagination') }}
        </div>
        <!-- pagination section end -->
    </div>

    <!-- Offcanvas sidebar start -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">@lang('Fund History Filter')</h5>
            <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-light fa-arrow-right"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('user.fund.index')}}" method="get">
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
                            <option value="all">@lang('All Payment')</option>
                            <option value="1"
                                    @if(@request()->status == '1') selected @endif>@lang('Complete Payment')</option>
                            <option value="2"
                                    @if(@request()->status == '0') selected @endif>@lang('Pending Payment')</option>
                            <option value="3"
                                    @if(@request()->status == '3') selected @endif>@lang('Cancel Payment')</option>
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
@endpush

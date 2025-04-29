@extends(template().'layouts.user')
@section('title')
    @lang('Transaction')
@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true).'css/bootstrap-datepicker.css') }}" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3"
                >
                    <h3 class="mb-0">@lang('Transaction')</h3>
                </div>
                <div class="table-search-bar">
                    <div class="d-none d-lg-block">
                        <form action="{{route('user.transaction')}}" method="get" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="transaction_id"
                                            value="{{request()->transaction_id}}"
                                            class="form-control"
                                            placeholder="@lang('Search for Transaction ID')"
                                        />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="input-box">
                                        <input
                                            name="remark" value="{{request()->remark}}" class="form-control" placeholder="@lang('Remark')"
                                            type="text"
                                        />
                                    </div>
                                </div>

                                <div class="input-box col-lg-3 col-md-3 col-sm-12">
                                    <input type="text" class="form-control datepicker" name="date" autocomplete="off" readonly placeholder="@lang('Select a date')" value="{{ old('date',request()->date) }}">
                                </div>


                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <button class="btn-custom w-100" type="submit">@lang('Search')</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- table -->
                <div class="table-parent table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>@lang('SL No.')</th>
                            <th>@lang('Transaction ID')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Charge')</th>
                            <th>@lang('Remarks')</th>
                            <th>@lang('Time')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{loopIndex($transactions) + $loop->index}}</td>
                                <td>@lang($transaction->trx_id)</td>
                                <td>
                                        <span
                                            class="fontBold text-{{($transaction->trx_type == "+") ? 'success': 'danger'}}">{{($transaction->trx_type == "+") ? '+': '-'}} {{currencyPosition($transaction->amount)}}</span>
                                </td>
                                <td>
                                        <span
                                            class="fontBold text-danger">{{currencyPosition($transaction->charge)}} </span>
                                </td>
                                <td>@lang($transaction->remarks)</td>
                                <td>{{ dateTime($transaction->created_at, 'd M Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="100%" class="text-center">{{__('No Data Found!')}}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $transactions->appends($_GET)->links(template().'partials.user-pagination') }}
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
@endpush

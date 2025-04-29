@extends(template().'layouts.user')
@section('title',trans($title))

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
                    <h3>{{trans($title)}}</h3>
                </div>
                <div class="search-bar">
                    <form action="{{ route('user.referral.bonus') }}" method="get" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="input-box">
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{@request()->name}}"
                                        class="form-control"
                                        placeholder="@lang('Search User')"
                                    />
                                </div>
                            </div>

                            <div class="input-box col-lg-4 col-md-4 col-sm-12">
                                <input type="text" class="form-control datepicker" name="date" autocomplete="off" readonly placeholder="@lang('Select a date')" value="{{ old('date', request()->date) }}">
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <button class="btn-custom w-100" type="submit">@lang('Search')</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- table -->
                <div class="table-parent table-responsive">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>@lang('SL No.')</th>
                            <th>@lang('Bonus From')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Remarks')</th>
                            <th>@lang('Time')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{loopIndex($transactions) + $loop->index}}</td>
                                <td>{{optional(@$transaction->bonusBy)->fullname}}</td>
                                <td>
                                    <span class="font-weight-bold text-success">{{currencyPosition($transaction->amount)}}</span>
                                </td>
                                <td>@lang($transaction->remarks)</td>
                                <td>{{ dateTime($transaction->created_at, 'd M Y h:i A') }}</td>
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
                    {{ $transactions->appends($_GET)->links(template().'partials.user-pagination') }}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true).'css/bootstrap-datepicker.css') }}" />
@endpush

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



@extends(template().'layouts.user')
@section('title',trans($title))

@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true).'css/bootstrap-datepicker.css') }}" />
@endpush

@section('content')
    <section class="transaction-history mt-5 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="header-text-full">
                        <h2>{{trans($title)}}</h2>
                    </div>
                </div>
            </div>

            <form action="{{ route('user.referral.bonus') }}" method="get">
                <div class="row select-transaction">
                    <div class="col-md-6 col-lg-4">
                        <div class="input-group mb-4">
                            <div class="img">
                                <img src="{{asset(template(true).'img/icon/edit.png')}}" alt="@lang('edit img')" />
                            </div>
                            <input
                                type="text"
                                name="name"
                                value="{{@request()->name}}"
                                class="form-control"
                                placeholder="@lang('Search User')"
                            />
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="input-group mb-4">
                            <div class="img">
                                <img src="{{asset(template(true).'img/icon/chevron.png')}}" alt="@lang('chevron img')" />
                            </div>
                            <input type="text" class="form-control datepicker" name="date" autocomplete="off" readonly placeholder="@lang('Select a date')" value="{{ old('date', request()->date) }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
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
    </section>
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



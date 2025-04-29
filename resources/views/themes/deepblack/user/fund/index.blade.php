@extends(template().'layouts.user')
@section('title',trans('Fund History'))

@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true).'css/bootstrap-datepicker.css') }}" />
@endpush

@section('content')

    <!-- Fund history -->
    <section class="transaction-history mt-5 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="header-text-full">
                        <h2>{{trans('Fund History')}}</h2>
                    </div>
                </div>
            </div>
            <form action="{{route('user.fund.index')}}" method="get">
                <div class="row select-transaction">
                    <div class="col-md-6 col-lg-3">
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
                                        @if(@request()->status == '1') selected @endif>@lang('Complete Payment')</option>
                                <option value="2"
                                        @if(@request()->status == '2') selected @endif>@lang('Pending Payment')</option>
                                <option value="3"
                                        @if(@request()->status == '3') selected @endif>@lang('Cancel Payment')</option>
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
                    <div class="col-md-6 col-lg-3">
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
                                            <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                            <p class="mb-0">@lang('No data to show')</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{ $funds->appends($_GET)->links(template().'partials.user-pagination') }}

                    </div>
                </div>
            </div>
        </div>
    </section>
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

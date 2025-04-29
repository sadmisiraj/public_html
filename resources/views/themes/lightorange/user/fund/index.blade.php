@extends(template().'layouts.user')
@section('title',trans('Fund History'))
@section('content')
    @push('navigator')
        <!-- PAGE-NAVIGATOR -->
        <section id="page-navigator">
            <div class="container-fluid">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"
                                                       class="cursor-inherit">{{trans('Fund History')}}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- /PAGE-NAVIGATOR -->
    @endpush

    <section id="dashboard">
        <div class="dashboard-wrapper add-fund pb-50">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card secbg form-block p-0 br-4">
                        <div class="card-body">

                            <form action="{{ route('user.fund.index') }}" method="get">
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
                                                <option value="all">@lang('All Payment')</option>
                                                <option value="1"
                                                        @if(@request()->status == '1') selected @endif>@lang('Complete Payment')</option>
                                                <option value="2"
                                                        @if(@request()->status == '0') selected @endif>@lang('Pending Payment')</option>
                                                <option value="3"
                                                        @if(@request()->status == '3') selected @endif>@lang('Cancel Payment')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group mb-2">
                                            <input type="date" class="form-control datepicker"  name="date_time" autocomplete="off"  placeholder="@lang('Select a date')" value="{{ old('date_time',request()->date_time) }}">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group mb-2 h-fill">
                                            <button type="submit" class="btn btn-primary base-btn w-fill h-fill">
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

                            </div>
                            {{ $funds->appends($_GET)->links(template().'partials.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


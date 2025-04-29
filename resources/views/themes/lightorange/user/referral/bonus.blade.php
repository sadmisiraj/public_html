@extends(template().'layouts.user')
@section('title',trans('Referral Bonus'))
@section('content')
    @push('navigator')
        <!-- PAGE-NAVIGATOR -->
        <section id="page-navigator">
            <div class="container-fluid">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"
                                                       class="cursor-inherit">{{trans('Referral Bonus')}}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- /PAGE-NAVIGATOR -->
    @endpush

    <section id="dashboard">
        <div class="dashboard-wrapper add-fund pb-50">
            <div class="row justify-content-between">
                <div class="col-md-12">
                    <div class="card secbg form-block p-0 br-4">
                        <div class="card-body">
                            <form action="{{route('user.referral.bonus')}}" method="get">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <input
                                                type="text"
                                                name="name"
                                                value="{{@request()->name}}"
                                                class="form-control"
                                                placeholder="@lang('Search User')"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-2">
                                            <input type="date" class="form-control" name="date" id="datepicker" value="{{ old('date', request()->date) }}"/>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-2 h-fill">
                                            <button type="submit" class="btn btn-primary base-btn w-fill h-fill">
                                                <i class="fas fa-search"></i> @lang('Search')</button>
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
                    <div class="card secbg">
                        <div class="card-body ">

                            <div class="table-responsive">
                                <table class="table table table-hover table-striped text-white " id="service-table">
                                    <thead class="thead-dark">
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
                                                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                                    <p class="mb-0">@lang('No data to show')</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                            </div>


                            {{ $transactions->appends($_GET)->links(template().'partials.pagination') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

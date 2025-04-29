@extends(template().'layouts.user')
@section('title')
    @lang('Transaction')
@endsection

@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Transaction')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Transaction')</li>
                </ol>
            </nav>
        </div>

        <!-- Cmn table section start -->
        <div class="card">
            <div class="card-header d-flex justify-content-between pb-0 border-0">
                <h4>@lang('Transaction History')</h4>
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
            {{ $transactions->appends($_GET)->links(template().'partials.pagination') }}
        </div>
        <!-- pagination section end -->
    </div>

    <!-- Offcanvas sidebar start -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">@lang('Transaction Filter')</h5>
            <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-light fa-arrow-right"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('user.transaction')}}" method="get">
                <div class="row g-4">
                    <div>
                        <label for="ProductName" class="form-label">@lang('Transaction ID')</label>
                        <input type="text" name="transaction_id" value="{{@request()->transaction_id}}" class="form-control" id="ProductName">
                    </div>
                    <div>
                        <label for="NumberOfSales" class="form-label">@lang('Remark')</label>
                        <input type="text" class="form-control" name="remark" value="{{ old('remark',request()->remark) }}" id="NumberOfSales">
                    </div>
                    <div>
                        <label for="NumberOfSales" class="form-label">@lang('Select a date')</label>
                        <input type="date" class="form-control" name="date" value="{{ old('date',request()->date) }}" id="NumberOfSales">
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


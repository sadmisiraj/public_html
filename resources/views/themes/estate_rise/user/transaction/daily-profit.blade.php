@extends(template().'layouts.user')
@section('title')
    @lang('Daily Profit Transaction')
@endsection

@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Daily Profit Transaction')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('user.transaction')}}">@lang('Transaction')</a></li>
                    <li class="breadcrumb-item active">@lang('Daily Profit Transaction')</li>
                </ol>
            </nav>
        </div>

        <!-- Cmn table section start -->
        <div class="card">
            <div class="card-header d-flex justify-content-between pb-0 border-0">
                <h4>@lang('Daily Profit Transaction History')</h4>
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
                                            <p class="mb-0">@lang('No daily profit transactions to show')</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Mobile Transaction List -->
                    <div class="transaction-mobile-list d-block d-md-none">
                        @forelse($transactions as $transaction)
                            <div class="transaction-mobile-card mb-2 p-2">
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span class="text-truncate" style="max-width: 90px;">{{ $transaction->trx_id }}</span>
                                    <span class="fontBold text-{{($transaction->trx_type == '+') ? 'success': 'danger'}}">
                                        {{($transaction->trx_type == '+') ? '+' : '-'}}{{ currencyPosition($transaction->amount) }}
                                    </span>
                                    <span class="fontBold text-danger ms-2">{{ currencyPosition($transaction->charge) }}</span>
                                </div>
                                <div class="text-muted" style="font-size: 13px; line-height: 1.2;">{{ $transaction->remarks }}</div>
                                <div class="text-muted" style="font-size: 12px;">{{ dateTime($transaction->created_at, 'd M Y h:i A') }}</div>
                            </div>
                        @empty
                            <div class="text-center p-3">@lang('No daily profit transactions to show')</div>
                        @endforelse
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
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">@lang('Daily Profit Transaction Filter')</h5>
            <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-light fa-arrow-right"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('user.daily-profit-transaction')}}" method="get">
                <div class="row g-4">
                    <div>
                        <label for="ProductName" class="form-label">@lang('Transaction ID')</label>
                        <input type="text" name="transaction_id" value="{{@request()->transaction_id}}" class="form-control" id="ProductName">
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

@push('style')
    <style>
        @media (max-width: 767.98px) {
            .table-responsive { display: none !important; }
            .transaction-mobile-list { width: 100%; }
            .transaction-mobile-card {
                background: #fff;
                border: 1px solid #eee;
                border-radius: 6px;
                margin-bottom: 8px;
                padding: 8px 10px;
                box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            }
            .transaction-mobile-card .d-flex > span {
                font-size: 13px;
                margin-right: 8px;
            }
            .transaction-mobile-card .text-muted {
                margin-top: 2px;
                margin-bottom: 0;
            }
        }
    </style>
@endpush 
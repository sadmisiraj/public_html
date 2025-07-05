@extends(template().'layouts.user')
@section('content')
<style>
    /* Additional page-specific styles */
    .dashboard-inner {
        margin-top: 30px; /* Increase top margin for this specific page */
    }
    
    @media (max-width: 767px) {
        .dashboard-inner {
            margin-top: 20px;
        }
    }
</style>
<div class="dashboard-inner">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title">@lang('RGP Transactions')</h5>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="fw-bold text-muted">@lang('RGP L'):</span>
                            <span class="fw-bold">{{ auth()->user()->rgp_l ?? '0.00' }}</span>
                        </div>
                        <div>
                            <span class="fw-bold text-muted">@lang('RGP R'):</span>
                            <span class="fw-bold">{{ auth()->user()->rgp_r ?? '0.00' }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-3">
                        <form action="{{ route('user.rgp.transactions') }}" method="GET" class="row align-items-end">
                            <div class="col-md-3 col-sm-6">
                                <label>@lang('Transaction Type')</label>
                                <select name="transaction_type" class="form-select form--select">
                                    <option value="">@lang('All Types')</option>
                                    <option value="credit" @selected(request()->transaction_type == 'credit')>@lang('Credit')</option>
                                    <option value="debit" @selected(request()->transaction_type == 'debit')>@lang('Debit')</option>
                                    <option value="match" @selected(request()->transaction_type == 'match')>@lang('Match')</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label>@lang('Side')</label>
                                <select name="side" class="form-select form--select">
                                    <option value="">@lang('All Sides')</option>
                                    <option value="left" @selected(request()->side == 'left')>@lang('Left')</option>
                                    <option value="right" @selected(request()->side == 'right')>@lang('Right')</option>
                                    <option value="both" @selected(request()->side == 'both')>@lang('Both')</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 mt-sm-0 mt-2">
                                <label>@lang('From Date')</label>
                                <input type="date" name="date_from" class="form-control" value="{{ request()->date_from }}">
                            </div>
                            <div class="col-md-3 col-sm-6 mt-sm-0 mt-2">
                                <label>@lang('To Date')</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request()->date_to }}">
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn--base w-100">@lang('Filter')</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                                <tr>
                                    <th>@lang('Transaction ID')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Side')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Previous RGP L')</th>
                                    <th>@lang('Previous RGP R')</th>
                                    <th>@lang('New RGP L')</th>
                                    <th>@lang('New RGP R')</th>
                                    <th>@lang('Remarks')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->transaction_id }}</td>
                                    <td>
                                        @if($transaction->transaction_type == 'credit')
                                            <span class="badge bg-success">@lang('Credit')</span>
                                        @elseif($transaction->transaction_type == 'debit')
                                            <span class="badge bg-danger">@lang('Debit')</span>
                                        @else
                                            <span class="badge bg-primary">@lang('Match')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->side == 'left')
                                            <span class="badge bg-info">@lang('Left')</span>
                                        @elseif($transaction->side == 'right')
                                            <span class="badge bg-warning">@lang('Right')</span>
                                        @else
                                            <span class="badge bg-dark">@lang('Both')</span>
                                        @endif
                                    </td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->previous_rgp_l }}</td>
                                    <td>{{ $transaction->previous_rgp_r }}</td>
                                    <td>{{ $transaction->new_rgp_l }}</td>
                                    <td>{{ $transaction->new_rgp_r }}</td>
                                    <td>{{ $transaction->remarks }}</td>
                                    <td>{{ showDateTime($transaction->created_at) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage ?? 'No transactions found') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ paginateLinks($transactions) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
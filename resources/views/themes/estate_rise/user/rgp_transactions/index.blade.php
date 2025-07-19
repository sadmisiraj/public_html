@extends(template().'layouts.user')
@section('content')
<style>
    /* Mobile-friendly RGP Transactions Styles */
    .dashboard-inner {
        margin-top: 30px;
    }
    
    /* Mobile-first responsive design */
    @media (max-width: 767px) {
        /* Add top padding to prevent header overlap */
        .dashboard-wrapper {
            margin-top: 80px !important;
        }
        
        .dashboard-inner {
            margin-top: 10px;
        }
        
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            padding: 15px;
        }
        
        .card-header .balance-info {
            display: flex;
            flex-direction: row;
            gap: 10px;
            width: 100%;
        }
        
        .balance-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background: var(--bg-color2);
            border-radius: 6px;
            border: 1px solid var(--border-color1);
            flex: 1;
        }
        
        .filter-form {
            margin-bottom: 15px;
            padding: 0 15px;
        }
        
        .filter-form .form-group {
            margin-bottom: 10px;
        }
        
        .filter-form label {
            font-weight: 600;
            margin-bottom: 3px;
            color: var(--heading-color);
            font-size: 13px;
        }
        
        .filter-form .form-control,
        .filter-form .form-select {
            border-radius: 6px;
            border: 1px solid var(--border-color1);
            padding: 8px 12px;
            font-size: 13px;
            min-height: 38px;
        }
        
        .filter-form .form-control:focus,
        .filter-form .form-select:focus {
            border-color: rgb(var(--primary-color));
            box-shadow: 0 0 0 0.2rem rgba(var(--primary-color), 0.25);
        }
        
        .filter-btn {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 8px;
            font-size: 14px;
        }
        
        /* Grid layout for transactions - Mobile only */
        .transactions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 8px;
            padding: 0 15px;
        }
        
        .transaction-card {
            background: var(--bg-color1);
            border-radius: 6px;
            box-shadow: var(--shadow1);
            border: 1px solid var(--border-color1);
            padding: 10px;
            font-size: 12px;
            line-height: 1.3;
        }
        
        .transaction-card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            padding: 0;
            gap: 8px;
        }
        
        .transaction-card .transaction-id {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: var(--heading-color);
            font-size: 11px;
            flex: 1;
        }
        
        .transaction-card .badge {
            padding: 3px 6px;
            font-size: 10px;
            border-radius: 10px;
            font-weight: 600;
        }
        
        .transaction-card .card-body {
            padding: 0;
        }
        
        .transaction-card .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 3px 0;
            font-size: 11px;
        }
        
        .transaction-card .info-row .label {
            font-weight: 600;
            color: var(--heading-color);
            min-width: 80px;
        }
        
        .transaction-card .info-row .value {
            text-align: right;
            flex: 1;
        }
        
        .transaction-card .amount-value {
            font-weight: 700;
            color: var(--heading-color);
            font-size: 12px;
        }
        
        .transaction-card .date-value {
            color: var(--grayish-blue);
            font-size: 10px;
        }
        
        .transaction-card .remarks {
            margin-top: 6px;
            padding-top: 6px;
            border-top: 1px solid var(--border-color1);
            font-size: 10px;
            color: var(--grayish-blue);
            line-height: 1.2;
        }
        
        /* Hide desktop table on mobile */
        .desktop-table {
            display: none !important;
        }
        
        /* Compact empty state */
        .empty-state {
            text-align: center;
            padding: 30px 15px;
            color: var(--grayish-blue);
        }
        
        .empty-state i {
            font-size: 36px;
            margin-bottom: 10px;
            opacity: 0.5;
        }
        
        .empty-state h6 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .empty-state p {
            font-size: 13px;
            margin: 0;
        }
        
        /* Mobile pagination styles */
        .card-footer {
            padding: 15px;
            background: var(--bg-color1);
            border-top: 1px solid var(--border-color1);
        }
        
        .pagination {
            justify-content: center;
            flex-wrap: wrap;
            gap: 5px;
            margin: 0;
        }
        
        .pagination .page-item {
            margin: 0 2px;
        }
        
        .pagination .page-link {
            padding: 8px 12px;
            font-size: 13px;
            min-width: 40px;
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid var(--border-color1);
            background: var(--bg-color1);
            color: var(--heading-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .pagination .page-link:hover {
            background: var(--bg-color2);
            border-color: rgb(var(--primary-color));
            color: rgb(var(--primary-color));
        }
        
        .pagination .page-item.active .page-link {
            background: rgb(var(--primary-color));
            border-color: rgb(var(--primary-color));
            color: white;
        }
        
        .pagination .page-item.disabled .page-link {
            background: var(--bg-color2);
            border-color: var(--border-color1);
            color: var(--grayish-blue);
            cursor: not-allowed;
        }
        
        /* Pagination info */
        .pagination-info {
            text-align: center;
            margin-bottom: 10px;
            font-size: 12px;
            color: var(--grayish-blue);
        }
        
        /* Reduce card body padding */
        .card-body {
            padding: 0;
        }
        
        /* Compact balance display */
        .balance-item span {
            font-size: 13px;
        }
        
        .balance-item .fw-bold {
            font-size: 14px;
        }
    }
    
    /* Tablet styles */
    @media (min-width: 768px) and (max-width: 991px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .balance-info {
            display: flex;
            gap: 20px;
        }
        
        .filter-form .row > div {
            margin-bottom: 15px;
        }
        
        /* Show 2 columns on tablet */
        .transactions-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        /* Hide desktop table on tablet */
        .desktop-table {
            display: none !important;
        }
        
        /* Tablet pagination */
        .pagination .page-link {
            padding: 10px 14px;
            font-size: 14px;
            min-width: 44px;
            min-height: 44px;
        }
    }
    
    /* Desktop enhancements */
    @media (min-width: 992px) {
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .balance-info {
            display: flex;
            gap: 30px;
        }
        
        .filter-form .row {
            align-items: end;
        }
        
        /* Hide mobile grid on desktop */
        .transactions-grid {
            display: none !important;
        }
        
        /* Show desktop table */
        .desktop-table {
            display: block !important;
        }
        
        /* Desktop table styles */
        .custom--table {
            margin-bottom: 0;
            width: 100%;
        }
        
        .custom--table thead tr th {
            background: var(--bg-color2);
            border-bottom: 2px solid var(--border-color1);
            font-weight: 600;
            color: var(--heading-color);
            padding: 12px 8px;
            text-align: left;
        }
        
        .custom--table tbody tr {
            border-bottom: 1px solid var(--border-color1);
        }
        
        .custom--table tbody tr:hover {
            background-color: var(--bg-color2);
        }
        
        .custom--table tbody td {
            padding: 12px 8px;
            vertical-align: middle;
        }
        
        .transaction-id {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: var(--heading-color);
        }
        
        .amount-value {
            font-weight: 700;
            color: var(--heading-color);
        }
        
        .date-value {
            color: var(--grayish-blue);
            font-size: 13px;
        }
        
        .badge {
            padding: 4px 8px;
            font-size: 11px;
            border-radius: 12px;
            font-weight: 600;
        }
        
        /* Desktop pagination */
        .card-footer {
            padding: 20px;
        }
        
        .pagination .page-link {
            padding: 8px 12px;
            font-size: 14px;
            min-width: 40px;
            min-height: 40px;
        }
    }
    
    /* Dark theme support */
    .dark-theme .balance-item {
        background: var(--bg-color2);
        border-color: var(--border-color2);
    }
    
    .dark-theme .transaction-card {
        background: var(--bg-color2);
        border-color: var(--border-color2);
    }
    
    .dark-theme .transaction-card .info-row .label {
        color: var(--heading-color);
    }
    
    .dark-theme .custom--table thead tr th {
        background: var(--bg-color3);
        border-color: var(--border-color2);
    }
    
    .dark-theme .custom--table tbody tr:hover {
        background-color: var(--bg-color3);
    }
    
    .dark-theme .pagination .page-link {
        background: var(--bg-color2);
        border-color: var(--border-color2);
        color: var(--heading-color);
    }
    
    .dark-theme .pagination .page-link:hover {
        background: var(--bg-color3);
        border-color: rgb(var(--primary-color));
        color: rgb(var(--primary-color));
    }
    
    .dark-theme .pagination .page-item.disabled .page-link {
        background: var(--bg-color3);
        border-color: var(--border-color2);
        color: var(--grayish-blue);
    }
}
</style>

<div class="dashboard-inner">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title">@lang('RGP Transactions')</h5>
                    <div class="balance-info">
                        <div class="balance-item">
                            <span class="fw-bold text-muted">@lang('RGP L'):</span>
                            <span class="fw-bold">{{ auth()->user()->rgp_l ?? '0.00' }}</span>
                        </div>
                        <div class="balance-item">
                            <span class="fw-bold text-muted">@lang('RGP R'):</span>
                            <span class="fw-bold">{{ auth()->user()->rgp_r ?? '0.00' }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-3">
                        <form action="{{ route('user.rgp.transactions') }}" method="GET" class="filter-form">
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Transaction Type')</label>
                                        <select name="transaction_type" class="form-select form--select">
                                            <option value="">@lang('All Types')</option>
                                            <option value="credit" @selected(request()->transaction_type == 'credit')>@lang('Credit')</option>
                                            <option value="debit" @selected(request()->transaction_type == 'debit')>@lang('Debit')</option>
                                            <option value="match" @selected(request()->transaction_type == 'match')>@lang('Match')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Side')</label>
                                        <select name="side" class="form-select form--select">
                                            <option value="">@lang('All Sides')</option>
                                            <option value="left" @selected(request()->side == 'left')>@lang('Left')</option>
                                            <option value="right" @selected(request()->side == 'right')>@lang('Right')</option>
                                            <option value="both" @selected(request()->side == 'both')>@lang('Both')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('From Date')</label>
                                        <input type="date" name="date_from" class="form-control" value="{{ request()->date_from }}">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('To Date')</label>
                                        <input type="date" name="date_to" class="form-control" value="{{ request()->date_to }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn--base filter-btn">
                                        <i class="fas fa-filter me-2"></i>@lang('Filter')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Mobile Grid Layout -->
                    <div class="transactions-grid">
                        @forelse($transactions as $transaction)
                        <div class="transaction-card">
                            <div class="card-header">
                                <span class="transaction-id">{{ $transaction->transaction_id }}</span>
                                <div class="badges">
                                    @if($transaction->transaction_type == 'credit')
                                        <span class="badge bg-success">@lang('Credit')</span>
                                    @elseif($transaction->transaction_type == 'debit')
                                        <span class="badge bg-danger">@lang('Debit')</span>
                                    @else
                                        <span class="badge bg-primary">@lang('Match')</span>
                                    @endif
                                    
                                    @if($transaction->side == 'left')
                                        <span class="badge bg-info">@lang('Left')</span>
                                    @elseif($transaction->side == 'right')
                                        <span class="badge bg-warning">@lang('Right')</span>
                                    @else
                                        <span class="badge bg-dark">@lang('Both')</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="info-row">
                                    <span class="label">@lang('Amount'):</span>
                                    <span class="value amount-value">{{ $transaction->amount }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="label">@lang('Previous'):</span>
                                    <span class="value">L: {{ $transaction->previous_rgp_l }} | R: {{ $transaction->previous_rgp_r }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="label">@lang('Current'):</span>
                                    <span class="value">L: {{ $transaction->new_rgp_l }} | R: {{ $transaction->new_rgp_r }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="label">@lang('Date'):</span>
                                    <span class="value date-value">{{ showDateTime($transaction->created_at) }}</span>
                                </div>
                                @if($transaction->remarks)
                                <div class="remarks">
                                    {{ $transaction->remarks }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="fas fa-receipt"></i>
                                <h6>{{ __($emptyMessage ?? 'No transactions found') }}</h6>
                                <p>Try adjusting your filters to see more results</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    
                    <!-- Desktop Table Layout -->
                    <div class="desktop-table">
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
                                        <td>
                                            <span class="transaction-id">{{ $transaction->transaction_id }}</span>
                                        </td>
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
                                        <td>
                                            <span class="amount-value">{{ $transaction->amount }}</span>
                                        </td>
                                        <td>{{ $transaction->previous_rgp_l }}</td>
                                        <td>{{ $transaction->previous_rgp_r }}</td>
                                        <td>{{ $transaction->new_rgp_l }}</td>
                                        <td>{{ $transaction->new_rgp_r }}</td>
                                        <td>{{ $transaction->remarks }}</td>
                                        <td>
                                            <span class="date-value">{{ showDateTime($transaction->created_at) }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">
                                            <div class="empty-state">
                                                <i class="fas fa-receipt"></i>
                                                <h6>{{ __($emptyMessage ?? 'No transactions found') }}</h6>
                                                <p>Try adjusting your filters to see more results</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
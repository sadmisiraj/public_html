@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <div class="card-header">
                            <h5 class="card-title">@lang('RGP Transactions for') {{ $user->fullname }} ({{ $user->username }})</h5>
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div>
                                    <a href="{{ route('admin.users.detail', $user->id) }}" class="btn btn--primary btn-sm">
                                        <i class="las la-user"></i> @lang('User Details')
                                    </a>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="mr-2">@lang('Current RGP L'):</span>
                                    <span class="font-weight-bold">{{ $user->rgp_l ?? '0.00' }}</span>
                                    <span class="mx-3">|</span>
                                    <span class="mr-2">@lang('Current RGP R'):</span>
                                    <span class="font-weight-bold">{{ $user->rgp_r ?? '0.00' }}</span>
                                </div>
                            </div>
                        </div>
                        <table class="table table--light style--two">
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
                                <th>@lang('Source')</th>
                                <th>@lang('Remarks')</th>
                                <th>@lang('Date')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td data-label="@lang('Transaction ID')">{{ $transaction->transaction_id }}</td>
                                    <td data-label="@lang('Type')">
                                        @if($transaction->transaction_type == 'credit')
                                            <span class="badge badge--success">@lang('Credit')</span>
                                        @elseif($transaction->transaction_type == 'debit')
                                            <span class="badge badge--danger">@lang('Debit')</span>
                                        @else
                                            <span class="badge badge--primary">@lang('Match')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Side')">
                                        @if($transaction->side == 'left')
                                            <span class="badge badge--info">@lang('Left')</span>
                                        @elseif($transaction->side == 'right')
                                            <span class="badge badge--warning">@lang('Right')</span>
                                        @else
                                            <span class="badge badge--dark">@lang('Both')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Amount')">{{ $transaction->amount }}</td>
                                    <td data-label="@lang('Previous RGP L')">{{ $transaction->previous_rgp_l }}</td>
                                    <td data-label="@lang('Previous RGP R')">{{ $transaction->previous_rgp_r }}</td>
                                    <td data-label="@lang('New RGP L')">{{ $transaction->new_rgp_l }}</td>
                                    <td data-label="@lang('New RGP R')">{{ $transaction->new_rgp_r }}</td>
                                    <td data-label="@lang('Source')">{{ ucfirst($transaction->source) }}</td>
                                    <td data-label="@lang('Remarks')">{{ $transaction->remarks }}</td>
                                    <td data-label="@lang('Date')">{{ showDateTime($transaction->created_at) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage ?? 'No transactions found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($transactions) }}
                </div>
            </div>
        </div>
    </div>
@endsection 
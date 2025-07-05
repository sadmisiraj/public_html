@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <div class="card-header">
                            <h5 class="card-title">@lang('RGP Transactions') 
                                @if(isset($allTransactions))
                                <small class="text-muted">(Total: {{ $allTransactions }})</small>
                                @endif
                            </h5>
                            <form action="{{ route('admin.rgp.transactions') }}" method="GET" class="form-inline float-sm-right bg--white">
                                <div class="input-group has_append">
                                    <select class="form-control" name="user_id">
                                        <option value="">@lang('All Users')</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" @selected(request()->user_id == $user->id)>{{ $user->username }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control" name="transaction_type">
                                        <option value="">@lang('All Types')</option>
                                        <option value="credit" @selected(request()->transaction_type == 'credit')>@lang('Credit')</option>
                                        <option value="debit" @selected(request()->transaction_type == 'debit')>@lang('Debit')</option>
                                        <option value="match" @selected(request()->transaction_type == 'match')>@lang('Match')</option>
                                    </select>
                                    <select class="form-control" name="side">
                                        <option value="">@lang('All Sides')</option>
                                        <option value="left" @selected(request()->side == 'left')>@lang('Left')</option>
                                        <option value="right" @selected(request()->side == 'right')>@lang('Right')</option>
                                        <option value="both" @selected(request()->side == 'both')>@lang('Both')</option>
                                    </select>
                                    <input type="text" name="search" class="form-control" placeholder="@lang('Search here')" value="{{ $search ?? '' }}">
                                    <div class="input-group-append">
                                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
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
                                    <td data-label="@lang('User')">
                                        @if($transaction->user)
                                            <span class="font-weight-bold">{{ $transaction->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.user.edit', $transaction->user_id) }}">{{ $transaction->user->username }}</a>
                                            </span>
                                        @else
                                            <span class="font-weight-bold text-danger">User not found</span>
                                        @endif
                                    </td>
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
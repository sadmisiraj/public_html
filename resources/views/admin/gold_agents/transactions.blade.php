@extends('admin.layouts.app')
@section('title', $pageTitle)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">@lang('Coin Transactions for:') {{ $agent->username }}</h5>
                        <a href="{{ route('admin.gold.agents.index') }}" class="btn btn-secondary">@lang('Back')</a>
                    </div>
                    <div class="card-body">
                        <form method="GET" class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label">@lang('Coin')</label>
                                <select name="coin_id" class="form-select">
                                    <option value="">@lang('All')</option>
                                    @foreach(($coins ?? []) as $c)
                                        <option value="{{ $c->id }}" {{ request('coin_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->karat }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">@lang('Type')</label>
                                <select name="change_type" class="form-select">
                                    <option value="">@lang('All')</option>
                                    @foreach(($changeTypes ?? []) as $t)
                                        <option value="{{ $t }}" {{ request('change_type') == $t ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($t)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">@lang('Reference')</label>
                                <input type="text" name="reference" value="{{ request('reference') }}" class="form-control" placeholder="TRX">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">@lang('Buyer')</label>
                                <input type="text" name="buyer" value="{{ request('buyer') }}" class="form-control" placeholder="Name or username">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">@lang('From')</label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">@lang('To')</label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                            </div>
                            <div class="col-12 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">@lang('Filter')</button>
                                <a href="{{ route('admin.gold.agents.transactions', $agent->id) }}" class="btn btn-secondary">@lang('Reset')</a>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>@lang('Agent')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Coin')</th>
                                    <th>@lang('Change')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Reference')</th>
                                    <th>@lang('Note')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ trim(($agent->firstname ?? '') . ' ' . ($agent->lastname ?? '')) }} ({{ $agent->username }})</td>
                                        <td>{{ $log->created_at->format('d M, Y H:i') }}</td>
                                        <td>{{ $log->goldCoin->name }} ({{ $log->goldCoin->karat }})</td>
                                        <td>
                                            @php $q = (int)$log->quantity_change; @endphp
                                            <span class="{{ $q >= 0 ? 'text-success' : 'text-danger' }}">{{ $q >= 0 ? '+' : '' }}{{ $q }}</span>
                                        </td>
                                        <td>{{ str_replace('_', ' ', ucfirst($log->change_type)) }}</td>
                                        <td>{{ $log->reference ?? '-' }}</td>
                                        <td>
                                            @if($log->change_type === 'admin_add')
                                                @lang('Added to inventory by admin')
                                            @elseif($log->change_type === 'admin_remove')
                                                @lang('Removed from inventory by admin')
                                            @elseif($log->change_type === 'agent_deliver')
                                                @php
                                                    $bf = data_get($log->meta, 'buyer_firstname');
                                                    $bl = data_get($log->meta, 'buyer_lastname');
                                                    $bu = data_get($log->meta, 'buyer_username');
                                                @endphp
                                                @if($bu || $bf || $bl)
                                                    @lang('Delivered to') {{ trim(($bf ?? '').' '.($bl ?? '')) }} ({{ $bu }}) [@lang('TRX') {{ $log->reference }}]
                                                @else
                                                    @lang('Delivered to user') [@lang('TRX') {{ $log->reference }}]
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">@lang('No transactions found')</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



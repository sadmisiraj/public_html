@extends('admin.layouts.app')
@section('title', $pageTitle)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">@lang('Gold Pickup Agents')</h5>
                        <form method="GET" class="d-flex" action="{{ route('admin.gold.agents.index') }}">
                            <input type="text" name="q" value="{{ $q }}" class="form-control me-2" placeholder="Search username or email">
                            <button class="btn btn-primary" type="submit">@lang('Search')</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('User')</th>
                                        <th>@lang('Email')</th>
                                        <th>@lang('Agent')</th>
                                        <th>@lang('Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $u)
                                    <tr>
                                        <td>{{ $u->username }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>
                                            <span class="badge {{ $u->is_gold_agent ? 'bg-success' : 'bg-secondary' }}">{{ $u->is_gold_agent ? 'Yes' : 'No' }}</span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.gold.agents.toggle') }}" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $u->id }}">
                                                <input type="hidden" name="is_gold_agent" value="{{ $u->is_gold_agent ? 0 : 1 }}">
                                                <button type="submit" class="btn btn-sm {{ $u->is_gold_agent ? 'btn-danger' : 'btn-success' }}">
                                                    {{ $u->is_gold_agent ? 'Remove Agent' : 'Make Agent' }}
                                                </button>
                                            </form>
                                            @if($u->is_gold_agent)
                                                <a href="{{ route('admin.gold.agents.inventory', $u->id) }}" class="btn btn-sm btn-primary">@lang('Manage Inventory')</a>
                                                <a href="{{ route('admin.gold.agents.transactions', $u->id) }}" class="btn btn-sm btn-info">@lang('View Coin Transactions')</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



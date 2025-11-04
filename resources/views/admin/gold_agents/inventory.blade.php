@extends('admin.layouts.app')
@section('title', $pageTitle)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">@lang('Manage Inventory for:') {{ $agent->username }}</h5>
                        <a href="{{ route('admin.gold.agents.index') }}" class="btn btn-secondary">@lang('Back')</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.gold.agents.inventory.update', $agent->id) }}">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>@lang('Coin')</th>
                                            <th>@lang('Current Stock')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($coins as $coin)
                                        @php $stock = $inventories[$coin->id]->stock ?? 0; @endphp
                                        <tr>
                                            <td>{{ $coin->name }} ({{ $coin->karat }})</td>
                                            <td style="max-width: 200px;">
                                                <input type="number" class="form-control" name="stock[{{ $coin->id }}]" value="{{ $stock }}" min="0">
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-primary">@lang('Save Changes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



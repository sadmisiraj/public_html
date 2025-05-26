@extends('admin.layouts.app')
@section('title', $pageTitle)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">@lang('Gold Coin List')</h5>
                        <a href="{{ route('admin.goldcoin.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus-circle"></i> @lang('Add New')
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Karat')</th>
                                    <th>@lang('Price Per Gram')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($coins as $coin)
                                    <tr>
                                        <td>
                                            <img src="{{ $coin->getImageUrl() }}" alt="{{ $coin->name }}" class="img-thumbnail" style="max-width: 80px;">
                                        </td>
                                        <td>{{ $coin->name }}</td>
                                        <td>{{ $coin->karat }}</td>
                                        <td>{{ currencyPosition($coin->price_per_gram) }}</td>
                                        <td>
                                            @if($coin->status)
                                                <span class="badge bg-success">@lang('Active')</span>
                                            @else
                                                <span class="badge bg-danger">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.goldcoin.edit', $coin->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pen-alt"></i>
                                                </a>
                                                <a href="{{ route('admin.goldcoin.destroy', $coin->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this coin?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">@lang('No gold coins found')</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $coins->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
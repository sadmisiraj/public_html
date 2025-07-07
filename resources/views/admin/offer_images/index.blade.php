@extends('admin.layouts.app')
@section('page_title', __('Offer Images'))

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.dashboard') }}">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.security.index') }}">@lang('Security Settings')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Offer Images')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Offer Images')</h1>
                </div>
                <div class="col-sm-auto">
                    <a href="{{ route('admin.offer-images.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> @lang('Add New')
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Offer Images List')</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('Title')</th>
                                        <th>@lang('Image')</th>
                                        <th>@lang('URL')</th>
                                        <th>@lang('Order')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($offerImages as $offerImage)
                                        <tr>
                                            <td>{{ $offerImage->title }}</td>
                                            <td>
                                                <img src="{{ $offerImage->getImageUrl() }}" alt="{{ $offerImage->title }}" 
                                                     width="100" height="60" class="img-thumbnail">
                                            </td>
                                            <td>{{ $offerImage->url ?? 'N/A' }}</td>
                                            <td>{{ $offerImage->order }}</td>
                                            <td>
                                                @if($offerImage->status)
                                                    <span class="badge bg-success">@lang('Active')</span>
                                                @else
                                                    <span class="badge bg-danger">@lang('Inactive')</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.offer-images.edit', $offerImage->id) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.offer-images.destroy', $offerImage->id) }}" 
                                                          method="POST" onsubmit="return confirm('Are you sure you want to delete this offer image?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">@lang('No offer images found')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
@extends('admin.layouts.app')
@section('page_title', __('Edit Offer Image'))

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
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.offer-images.index') }}">@lang('Offer Images')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Edit')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Edit Offer Image')</h1>
                </div>
                <div class="col-sm-auto">
                    <a href="{{ route('admin.offer-images.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> @lang('Back to List')
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Edit Offer Image')</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.offer-images.update', $offerImage->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="title" class="form-label">@lang('Title') <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                               value="{{ old('title', $offerImage->title) }}" required>
                                        @error('title')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="url" class="form-label">@lang('URL') <small class="text-muted">(@lang('Optional'))</small></label>
                                        <input type="url" name="url" id="url" class="form-control @error('url') is-invalid @enderror" 
                                               value="{{ old('url', $offerImage->url) }}" placeholder="https://example.com">
                                        @error('url')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="order" class="form-label">@lang('Display Order') <span class="text-danger">*</span></label>
                                        <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" 
                                               value="{{ old('order', $offerImage->order) }}" min="0" required>
                                        @error('order')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Status') <span class="text-danger">*</span></label>
                                        <div class="d-flex">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" name="status" id="status_active" value="1" 
                                                       {{ old('status', $offerImage->status) == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status_active">@lang('Active')</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0" 
                                                       {{ old('status', $offerImage->status) == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status_inactive">@lang('Inactive')</label>
                                            </div>
                                        </div>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="image" class="form-label">@lang('Image')</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" 
                                               accept="image/jpeg,image/png,image/jpg">
                                        <small class="text-muted">@lang('Recommended size: 600x400px. Max: 2MB. Allowed formats: JPG, JPEG, PNG')</small>
                                        @error('image')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Current Image')</label>
                                        <div>
                                            <img src="{{ $offerImage->getImageUrl() }}" alt="{{ $offerImage->title }}" 
                                                 class="img-thumbnail" style="max-width: 300px;">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">@lang('Update')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
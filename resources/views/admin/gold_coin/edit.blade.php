@extends('admin.layouts.app')
@section('title', $pageTitle)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Edit Gold Coin')</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.goldcoin.update', $coin->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name">@lang('Name') <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $coin->name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="karat">@lang('Karat') <span class="text-danger">*</span></label>
                                        <input type="text" name="karat" id="karat" class="form-control" value="{{ old('karat', $coin->karat) }}" required>
                                        <small class="text-muted">@lang('e.g., 22K, 24K')</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price_per_gram">@lang('Price Per Gram') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">{{ $basic->currency_symbol }}</span>
                                            <input type="number" name="price_per_gram" id="price_per_gram" class="form-control" value="{{ old('price_per_gram', $coin->price_per_gram) }}" step="0.00000001" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="status">@lang('Status') <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="1" {{ old('status', $coin->status) == 1 ? 'selected' : '' }}>@lang('Active')</option>
                                            <option value="0" {{ old('status', $coin->status) == 0 ? 'selected' : '' }}>@lang('Inactive')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="description">@lang('Description')</label>
                                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $coin->description) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="image">@lang('Image')</label>
                                        @if($coin->image)
                                            <div class="mb-2">
                                                <img src="{{ getFile($coin->image_driver, $coin->image, true) }}" alt="{{ $coin->name }}" class="img-thumbnail" style="max-width: 200px;">
                                            </div>
                                        @endif
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                        <small class="text-muted">@lang('Recommended size: 500x500px. Leave empty to keep current image.')</small>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">@lang('Update')</button>
                                        <a href="{{ route('admin.goldcoin.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 
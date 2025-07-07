@extends('admin.layouts.app')
@section('page_title', __('Dashboard Popup Settings'))
@section('content')
    <div class="content container-fluid" id="setting-section">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.dashboard') }}">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.security.index') }}">@lang('Security Settings')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Dashboard Popup Settings')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Dashboard Popup Settings')</h1>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.security.dashboard.popup.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label font-weight-bold">@lang('Dashboard Popup Image')</label>
                                <div class="image-input">
                                    <label for="image-upload" id="image-label">
                                        <i class="fas fa-upload"></i>
                                    </label>
                                    <input type="file" name="dashboard_popup_image" placeholder="@lang('Choose image')" id="image">
                                    <img id="image_preview_container" class="preview-image"
                                         src="{{ getFile($basicControl->dashboard_popup_image_driver, $basicControl->dashboard_popup_image) }}"
                                         alt="@lang('Dashboard Popup Image')">
                                </div>
                                <small class="form-text text-muted">@lang('Recommended size: 800x600px')</small>
                                @error('dashboard_popup_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label font-weight-bold">@lang('Show Dashboard Popup')</label>
                                <div class="custom-switch-btn">
                                    <input type='hidden' value='0' name='show_dashboard_popup'>
                                    <input type="checkbox" name="show_dashboard_popup" class="custom-switch-checkbox"
                                           id="show_dashboard_popup"
                                           value="1" {{ $basicControl->show_dashboard_popup == 1 ? 'checked' : '' }} >
                                    <label class="custom-switch-checkbox-label" for="show_dashboard_popup">
                                        <span class="custom-switch-checkbox-inner"></span>
                                        <span class="custom-switch-checkbox-switch"></span>
                                    </label>
                                </div>
                                <small class="form-text text-muted">@lang('Enable to show the popup when users first log in to the dashboard')</small>
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="form-label font-weight-bold">@lang('Popup URL (Optional)')</label>
                                <input type="url" name="dashboard_popup_url" class="form-control" 
                                       value="{{ $basicControl->dashboard_popup_url ?? '' }}" 
                                       placeholder="https://example.com">
                                <small class="form-text text-muted">@lang('Add a URL to make the popup clickable')</small>
                                @error('dashboard_popup_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        @lang('Save Changes')
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush 
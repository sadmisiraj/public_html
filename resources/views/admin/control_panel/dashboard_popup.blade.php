@extends('admin.layouts.app')
@section('title')
    @lang('Dashboard Popup Settings')
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <form method="post" action="{{ route('admin.dashboard.popup.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Dashboard Popup Image')</label>
                            <div class="image-input">
                                <label for="image-upload" id="image-label">
                                    <i class="fas fa-upload"></i>
                                </label>
                                <input type="file" name="dashboard_popup_image" placeholder="@lang('Choose image')" id="image">
                                <img id="image_preview_container" class="preview-image"
                                     src="{{ getFile(basicControl()->dashboard_popup_image_driver, basicControl()->dashboard_popup_image) }}"
                                     alt="@lang('Dashboard Popup Image')">
                            </div>
                            @error('dashboard_popup_image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Show Dashboard Popup')</label>
                            <div class="custom-switch-btn">
                                <input type='hidden' value='0' name='show_dashboard_popup'>
                                <input type="checkbox" name="show_dashboard_popup" class="custom-switch-checkbox"
                                       id="show_dashboard_popup"
                                       value="1" {{ basicControl()->show_dashboard_popup == 1 ? 'checked' : '' }} >
                                <label class="custom-switch-checkbox-label" for="show_dashboard_popup">
                                    <span class="custom-switch-checkbox-inner"></span>
                                    <span class="custom-switch-checkbox-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                    @lang('Save Changes')
                </button>
            </form>
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

@push('css')
<style>
.preview-image {
    max-width: 200px;
    max-height: 150px;
    width: auto;
    height: auto;
    display: block;
    margin-top: 10px;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    background: #f5f7fa;
    object-fit: contain;
}
.image-input {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
</style>
@endpush 
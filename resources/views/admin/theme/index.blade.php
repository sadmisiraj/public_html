@extends('admin.layouts.app')
@section('page_title', __('Manage Theme'))
@section('content')
    <div class="content container-fluid" id="homeStyles">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang("Manage Theme")</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang("Manage Theme")</h1>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-10">
                <div class="row d-flex justify-content-between">
                    @foreach(config('theme') as  $key =>  $theme)
                        <div class="col-sm-6 col-lg-4 mb-3 mb-lg-5">
                            <div class="select-theme">
                                <label class="form-control" for="formControlRadioReverseEg{{$key}}">
                      <span class="form-check">
                        <input type="radio" class="form-check-input" name="theme" value="{{$key}}" id="formControlRadioReverseEg{{$key}}" @checked(basicControl()->theme == $key)>
                         <img class="img-fluid w-100" src="{{asset($theme['preview'])}}"
                              alt="Image Description">
                      </span>
                                </label>
                            </div>
                            <div class="text-center">
                                <h5 class="mb-0 bg-warning p-3">{{$theme['name']}}</h5>
                            </div>
                            <!-- End Card -->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function() {
            // Assuming you want to trigger an event when the radio button is changed
            $('.form-check-input').on('change', function() {
                if ($(this).prop('checked')) {
                    Notiflix.Block.standard('#homeStyles');

                    var radioValue = $(this).val();
                    selectHomeStyle(radioValue)
                }
            });
            async function selectHomeStyle(val) {
                let url = "{{ route('admin.select.theme', ['val' => ':val']) }}";
                url = url.replace(':val', val);
                await axios.post(url)
                    .then(function (res) {
                        Notiflix.Block.remove('#homeStyles');
                        if (res.data === 'success'){
                            Notiflix.Notify.success('Theme Update Successfully');
                        }else {
                            Notiflix.Notify.failure('This is DEMO version. You can just explore all the features but can\'t take any action.');
                        }
                        location.reload()
                    })
                    .catch(function (error) {
                        Notiflix.Block.remove('#homeStyles');
                        Notiflix.Notify.failure('This Theme is not exist');
                    });
            }
        });
    </script>
@endpush

@extends('admin.layouts.app')
@section('page_title', __('Manage Home Style'))
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
                                aria-current="page">@lang("Manage Home Style")</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang("Manage Home Style")</h1>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-10">
                <div class="row d-flex justify-content-center">
                    @foreach(config('theme')[getTheme()]['home_version'] as  $key =>  $home)
                        <div class="col-sm-6 col-lg-4 mb-3 mb-lg-5">
                            <div class="select-theme">
                                <label class="form-control" for="formControlRadioReverseEg{{$key}}">
                      <span class="form-check">
                        <input type="radio" class="form-check-input" name="home_style" value="{{$key}}" id="formControlRadioReverseEg{{$key}}" @checked(basicControl()->home_style == $key) >
                         <img class="img-fluid w-100" src="{{asset($home['preview'])}}"
                              alt="Image Description">
                      </span>
                                </label>
                            </div>
                            <div class="text-center">
                                <h5 class="mb-0 bg-warning p-3">{{$home['name']}}</h5>
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
                let url = "{{ route('admin.select.home', ['val' => ':val']) }}";
                url = url.replace(':val', val);
                await axios.get(url)
                    .then(function (res) {
                        console.log(res)
                        Notiflix.Block.remove('#homeStyles');
                        Notiflix.Notify.success('Home Style Update Successfully');
                    })
                    .catch(function (error) {
                        Notiflix.Notify.failure('This Home is not exist');
                    });
            }
        });
    </script>
@endpush

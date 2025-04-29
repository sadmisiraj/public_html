@extends(template().'layouts.user')
@section('title',__('2 Step Security'))

@section('content')
    <section class="transaction-history twofactor">
        <div class="container-fluid">
            <div class="main row">
                <div class="col-12">
                    <div
                        class="d-flex justify-content-between align-items-center mb-3"
                    >
                        <h3 class="mb-0">{{trans('2 Step Security')}} </h3>
                    </div>
                </div>
                <div class="row">
                    @if(auth()->user()->two_fa == 1)
                        <div class="col-lg-6 col-md-6 mb-3">
                            <div class="card text-center bg-dark">

                                <div class="card-header  mb-3 d-flex justify-content-between align-items-center">
                                    <h5 class="mb-2">@lang("Two Factor Authenticator")</h5>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#regenerateModal"
                                            class="btn-custom">@lang("Regenerate")</button>
                                </div>
                                <div class="card-body">


                                    <div class="refferal-box">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control"
                                                value="{{$secret}}"
                                                id="referralURL"
                                                readonly
                                            >
                                            <button id="copyBtn" onclick="copyFunction()" class="btn text-white">
                                                @lang('Copy Code')
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group mx-auto text-center py-4">
                                        <img class="mx-auto"
                                             src="https://quickchart.io/chart?cht=qr&chs=150x150&chl={{($qrCodeUrl)}}">
                                    </div>

                                    <div class="form-group mx-auto text-center">
                                        <a href="javascript:void(0)" class="btn btn-bg btn-lg"
                                           data-bs-toggle="modal"
                                           data-bs-target="#disableModal">@lang('Disable Two Factor Authenticator')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-6 col-md-6 mb-3">
                            <div class="card text-center bg-dark">
                                <div class="card-header  mb-3 d-flex justify-content-between align-items-center">
                                    <h5 class="mb-2">@lang("Two Factor Authenticator")</h5>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#regenerateModal"
                                            class="btn-custom">@lang("Regenerate")</button>
                                </div>

                                <div class="card-body">
                                    <div class="refferal-box">
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{$secret}}"
                                                   id="referralURL" readonly>
                                            <button class="input-group-text btn-custom copy__referal_btn copytext"
                                                    id="copyBoard"
                                                    onclick="copyFunction()">@lang('copy link')</button>
                                        </div>
                                    </div>

                                    <div class="form-group mx-auto text-center py-4">
                                        <img class="mx-auto"
                                             src="https://quickchart.io/chart?cht=qr&chs=150x150&chl={{($qrCodeUrl)}}">
                                    </div>

                                    <div class="form-group mx-auto text-center">
                                        <a href="javascript:void(0)"
                                           class="btn btn-bg btn-lg btn-custom-rounded "
                                           data-bs-toggle="modal"
                                           data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    @endif


                    <div class="col-lg-6 col-md-6 mb-3">
                        <div class="card text-center bg-dark py-2">
                            <div class="mt-3 mb-3">
                                <h3 class="card-title golden-text pt-2">@lang('Google Authenticator')</h3>
                            </div>
                            <div class="card-body">

                                <h6 class="text-uppercase my-3">@lang('Use Google Authenticator to Scan the QR code  or use the code')</h6>

                                <p class="p-5">@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                                <a class="btn btn btn-bg btn-md mt-3 btn-custom-rounded"
                                   href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                                   target="_blank">@lang('DOWNLOAD APP')</a>

                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>





    <!-- Enable 2fa -->
    <div class="modal fade" id="enableModal" tabindex="-1" aria-labelledby="enableModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">
                        @lang('Verify Your OTP')
                    </h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <form action="{{route('user.twoStepEnable')}}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control" name="code"
                                   placeholder="@lang('Enter Google Authenticator Code')">
                        </div>

                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="submit" class="btn btn-success">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Enable 2fa -->
    <div class="modal fade" id="disableModal" tabindex="-1" aria-labelledby="enableModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">
                        @lang('Verify Your OTP to Disable')
                    </h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <form action="{{route('user.twoStepDisable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="password" class="form-control" name="password"
                                   placeholder="@lang('Enter Your Password')" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-success">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Enable 2fa -->
    <div class="modal fade" id="regenerateModal" tabindex="-1" aria-labelledby="enableModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">
                        @lang('Re-generate Confirmation')
                    </h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <form action="{{route('user.twoStepRegenerate')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @lang("Are you want to Re-generate Authenticator ?")
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn-success">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



@push('script')
    <script>
        function copyFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.success(`Copied: ${copyText.value}`);
        }
    </script>
@endpush

@push('style')
    <style>
        #content form {

            -webkit-box-shadow: none !important;
            box-shadow:none !important;

        }
    </style>
@endpush


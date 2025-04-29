@extends(template().'layouts.app')
@section('title',$page_title)
@section('content')
    <!-- login-signup section start -->
    <section class="login-signup-page">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 col-lg-12 col-md-10 mx-auto">
                    <div class="login-signup-box">
                        <div class="row g-0 d-flex align-items-center justify-content-center">
                            <div class="col-lg-6">
                                <div class="login-signup-form ">
                                    @if (session('status'))
                                        <div class="alert alert-warning alert-dismissible fade show w-100" role="alert">
                                            {{ trans(session('status')) }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <form action="{{route('user.mail.verify')}}" method="post">
                                        @csrf

                                        <div class="row g-4">
                                            <div class="col-12">
                                                <input type="text" name="code" class="form-control" id="exampleInputEmail1"
                                                       placeholder="@lang('Enter Your Code')">
                                                @error('code')<span class="text-danger mt-1">{{ trans($message) }}</span>@enderror
                                                @error('error')<span class="text-danger mt-1">{{ trans($message) }}</span>@enderror
                                            </div>

                                        </div>
                                        <button type="submit" class="cmn-btn mt-30 w-100"><span>@lang('submit')</span></button>
                                        <div class="pt-20 text-center">
                                            @lang("Didn't get Code? Click to")
                                            <p class="mb-0 highlight mt-1">
                                                <a href="{{route('user.resend.code')}}?type=email">@lang('Resend code')</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="img-box">
                                    <img src="{{ isset($login_registration['single']['media']->image)?getFile($login_registration['single']['media']->image->driver,$login_registration['single']['media']->image->path):'' }}" alt="login page image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- login-signup section end -->
@endsection

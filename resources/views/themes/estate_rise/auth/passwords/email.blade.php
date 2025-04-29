@extends(template().'layouts.app')
@section('title',trans('Login'))
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
                                    <form action="{{ route('password.email') }}" method="post">
                                        @csrf

                                        <div class="row g-4">
                                            <div class="col-12">
                                                <h4>@lang('Recover Password')!</h4>
                                                <p>@lang('Regain access with your seamless and secure account retrieval process in just a few clicks')!</p>
                                            </div>
                                            <div class="col-12">
                                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                                       placeholder="@lang('Email Address')">
                                                @error('email')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="cmn-btn mt-30 w-100"><span>@lang('Send Password Reset Link')</span></button>
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

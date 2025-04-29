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
                                    <form action="{{ route('password.update') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <div class="row g-4">
                                            <div class="col-12">
                                                <h4>@lang('Reset Password')!</h4>
                                            </div>
                                            <div class="col-12">
                                                <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control" id="exampleInputEmail1"
                                                       placeholder="@lang('Email Address')">
                                                @error('email')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="col-12">
                                                <input type="password" name="password" class="form-control" id="exampleInputEmail1"
                                                       placeholder="@lang('Password')" required autocomplete="off">
                                                @error('password')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                            <div class="col-12">
                                                <input type="password" name="password_confirmation" class="form-control" id="exampleInputEmail1"
                                                       placeholder="@lang('Confirm Password')" required autocomplete="off">
                                                @error('password_confirmation')<span class="text-danger mt-1">@lang($message)</span>@enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="cmn-btn mt-30 w-100"><span>@lang('Reset Password')</span></button>
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

@extends(template().'layouts.app')
@section('title',__('Reset Password'))


@section('content')

    <!-- login_signup_area_start -->
    <section class="login_signup_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-5">
                    <div class="login_signup_banner">
                        <div class="image_area animation1">
                            <img src="{{ asset(template(true).'img/login/1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-7">
                    <div class="login_signup_form p-4">
                        <div class="section_header text-center">

                            <h4 class="pt-30 pb-30">@lang('Reset Password')</h4>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ trans(session('status')) }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{route('password.update')}}" method="post">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <p>@lang('New Password')</p>
                            <div class="input-group mb-3">
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="@lang('New Password')">
                                <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-lock"></i></span>
                            </div>
                            @error('password')<span class="text-danger float-left">@lang($message)</span>@enderror
                            <p>@lang('Confirm Password')</p>
                            <div class="input-group mb-3">
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="@lang('Confirm Password')"
                                />
                                <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-lock"></i></span>
                            </div>

                            <button type="submit" class="btn custom_btn mt-30 w-100">@lang('submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

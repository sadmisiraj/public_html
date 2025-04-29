@extends(template().'layouts.app')
@section('content')
<!-- reset password  -->
<section class="login-section">
    <div class="container">
        <div class="login-wrapper">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="form-wrapper">
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
                                    <h4>@lang('Reset Password')</h4>
                                </div>
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="@lang('Enter Your Email Address')" autocomplete="off"/>
                                    <label for="floatingInput">@lang('Enter Your Email Address')</label>
                                    @error('email')<span class="text-danger mt-1">{{ trans($message) }}</span>@enderror
                                </div>

                            </div>
                            <button class="btn-custom w-100 mt-3" type="submit">@lang('Send Password Reset Link')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

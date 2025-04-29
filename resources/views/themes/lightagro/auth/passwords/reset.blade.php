@extends(template().'layouts.app')

@section('content')
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

                            <form action="{{ route('password.update') }}" method="post">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-12">
                                        <h4>@lang('Reset Password')</h4>
                                    </div>
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-floating">
                                        <input  type="email" id="floatingEmail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="@lang('Email Address')" required autofocus >
                                        <label for="floatingEmail" class="">{{ __('Email Address') }}</label>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                             {{ $message }}
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="form-floating">
                                        <input id="floatingPassword" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="@lang('Password')" required autocomplete="off">
                                        <label for="floatingPassword">@lang('Password')</label>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-floating">
                                        <input id="floatingConfirmPassword" type="password" class="form-control" name="password_confirmation" placeholder="@lang('Confirm Password')" autocomplete="off" >
                                        <label for="floatingConfirmPassword">{{ __('Confirm Password') }}</label>
                                    </div>

                                </div>
                                <button class="btn-custom w-100 mt-3" type="submit">@lang('submit')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

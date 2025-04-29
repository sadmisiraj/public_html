@extends(template().'layouts.app')
@section('title',__('Reset Password'))


@section('content')
    <section class="contact_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6  order-2 order-md-1 m-auto">
                    <div class="form_area p-4 shadow1 ">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ trans(session('status')) }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{route('password.update')}}" method="post">
                            @csrf
                            <div class="form_title pb-2">
                                <h3>@lang('Reset Password')</h3>
                            </div>
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="mb-4">
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="@lang('Email')"
                                    value="{{old('email',$email)}}"
                                />
                                @error('email')<span class="text-danger float-left">@lang($message)</span>@enderror
                            </div>
                            <div class="mb-4">
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="@lang('New Password')"
                                />
                                @error('password')<span class="text-danger float-left">@lang($message)</span>@enderror
                            </div>
                            <div class="mb-4">
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="@lang('Confirm Password')"
                                />
                            </div>
                            <button type="submit" class="btn custom_btn mt-30">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

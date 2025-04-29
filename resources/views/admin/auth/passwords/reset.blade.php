@extends('admin.layouts.login')
@section('page_title', ('Admin | Reset Password'))
@section('content')

    <div class="card card-lg mt-lg-5 mb-5">
        <div class="card-body">

            <form method="post" action="{{route('admin.password.reset.update')}}" class="js-validate needs-validation"
                  novalidate>
                @csrf
                <div class="text-center">
                    <div class="mb-5">
                        <h1 class="display-5">Reset password</h1>
                        <p>Enter the email address you used when you joined and we'll send you instructions to reset
                            your password.</p>
                    </div>
                </div>

                <input type="hidden" name="token" value="{{$token}}">

                <div class="mb-4">
                    <label class="form-label" for="resetPasswordSrEmail" tabindex="0">Your email</label>
                    <input type="email" class="form-control form-control-lg" value="{{$email}}" name="email" id="resetPasswordSrEmail"
                           tabindex="1" placeholder="Enter your email address" aria-label="Enter your email address"
                           required>
                    <span class="invalid-feedback">Please enter a valid email address.</span>
                    @error('email')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

               <div class="mb-4">
                   <label class="form-label" for="resetPasswordSrEmail" tabindex="0">Password</label>
                   <div class="input-group input-group-merge" data-hs-validation-validate-class>
                       <input type="password"
                              class="js-toggle-password form-control form-control-lg @error('password') is-invalid @enderror"
                              name="password" id="signupSrPassword" placeholder="Enter Password"
                              data-hs-toggle-password-options='
                               {
                                "target": "#changePassTarget",
                                "defaultClass": "bi-eye-slash",
                                "showClass": "bi-eye",
                                "classChangeTarget": "#changePassIcon"
                                }'>
                       <a id="changePassTarget" class="input-group-append input-group-text"
                          href="javascript:void(0)">
                           <i id="changePassIcon" class="bi-eye"></i>
                       </a>
                   </div>
                   @error('password')
                   <span class="invalid-feedback d-block">{{ $message }}</span>
                   @enderror
               </div>



                <div class="mb-4">
                    <label class="form-label" for="resetPasswordSrEmail" tabindex="0">Confirm Password</label>
                    <div class="input-group input-group-merge" data-hs-validation-validate-class>
                        <input type="password"
                               class="js-toggle-password form-control form-control-lg @error('password') is-invalid @enderror"
                               name="password_confirmation" id="ConfirmPass" placeholder="Enter Confirm Password"
                               data-hs-toggle-password-options='
                               {
                                "target": "#changeConfirmPassTarget",
                                "defaultClass": "bi-eye-slash",
                                "showClass": "bi-eye",
                                "classChangeTarget": "#changeConfirmPassIcon"
                                }'>
                        <a id="changeConfirmPassTarget" class="input-group-append input-group-text"
                           href="javascript:void(0)">
                            <i id="changeConfirmPassIcon" class="bi-eye"></i>
                        </a>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    <div class="text-center">
                        <a class="btn btn-link" href="{{ route('admin.login') }}">
                            <i class="bi-chevron-left"></i> Back to Sign in
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

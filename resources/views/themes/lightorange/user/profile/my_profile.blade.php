@extends(template().'layouts.user')
@section('title',trans('Profile Settings'))

@section('content')
    @push('navigator')
        <!-- PAGE-NAVIGATOR -->
        <section id="page-navigator">
            <div class="container-fluid">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"
                                                       class="cursor-inherit">{{trans('Profile Settings')}}</a></li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- /PAGE-NAVIGATOR -->
    @endpush

    <section id="dashboard">
        <div class="dashboard-wrapper add-fund pb-50">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card secbg br-4">
                        <div class="card-body br-4">
                            <form method="post" action=""
                                  enctype="multipart/form-data">
                                <div class="form-group">
                                    @csrf
                                    <div class="image-input ">
                                        <label for="image-upload" id="image-label"><i
                                                class="fas fa-upload"></i></label>
                                        <input type="file" name="image" placeholder="Choose image" id="image">
                                        <img id="image_preview_container" class="preview-image"
                                             style="max-width: 200px"
                                             src="{{getFile(Auth::user()->image_driver, Auth::user()->image)}}"
                                             alt="preview image">
                                    </div>
                                    @error('image')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                </div>
                                <h4 class="text-center mb-2">@lang($user->fullname) <sup><sapn class="badge badge-pill bg-outline-success badge_lavel_style text-white border-1">{{ @$user->rank->rank_lavel }}</sapn></sup></h4>
                                <h5 class="text-center mt-2 mb-3">@lang(@$user->rank->rank_name)</h5>
                                <p class="text-center mb-2">@lang('Joined At') @lang($user->created_at->format('d M, Y g:i A'))</p>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="card secbg form-block br-4">
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{$errors->all() || session('kycForm')?$errors->has('profile') || $errors->has('profileImage') ?'active':'':'active'}}"
                                       data-toggle="tab" href="#home">@lang('Profile Information')</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{$errors->has('password')? 'active':''}}"
                                       data-toggle="tab"
                                       href="#menu1">@lang('Password Setting')</a>
                                </li>
                                @foreach($kyc as $key => $value)
                                    <li class="nav-item">
                                        <a class="nav-link {{$errors->has($value->name) || session('kycForm') ==$value->name? 'active':''}} {{session($value->name)?'active':''}}"
                                           data-toggle="tab"
                                           href="#{{'kyc'.$key}}"> @lang(ucfirst($value->name))</a>
                                    </li>
                                @endforeach

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content ">
                                <div id="home"
                                     class="container mt-4 tab-pane  {{$errors->all() || session('kycForm')?$errors->has('profile')|| $errors->has('profileImage')?'active':'':'active' }}">

                                    <form action="{{ route('user.profile.update')}}" method="post">
                                        @csrf

                                        <div class="row ">
                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <label>@lang('First Name')</label>
                                                    <input class="form-control" type="text" name="first_name"
                                                           value="{{old('first_name')?: $user->firstname }}">
                                                    @if($errors->has('first_name'))
                                                        <div
                                                            class="error text-danger">@lang($errors->first('firstname')) </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <label>@lang('Last Name')</label>
                                                    <input class="form-control" type="text" name="last_name"
                                                           value="{{old('last_name')?: $user->lastname }}">
                                                    @if($errors->has('last_name'))
                                                        <div
                                                            class="error text-danger">@lang($errors->first('lastname')) </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <label>@lang('Username')</label>
                                                    <input class="form-control" type="text" name="username"
                                                           value="{{old('username')?: $user->username }}">
                                                    @if($errors->has('username'))
                                                        <div
                                                            class="error text-danger">@lang($errors->first('username')) </div>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <label>@lang('Email Address')</label>
                                                    <input class="form-control" type="email" name="email"
                                                           value="{{ $user->email }}">
                                                    @if($errors->has('email'))
                                                        <div
                                                            class="error text-danger">@lang($errors->first('email')) </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label>@lang('Phone Number')</label>
                                                <div class="form-group ">
                                                    <input type="hidden" name="phone_code" id="phoneCode" >
                                                    <input type="hidden" name="country_code" id="countryCode" >
                                                    <input type="hidden" name="country" id="countryName" >
                                                    <input type="text" id="telephone" name="phone" value="{{old('phone')}}"  class="sign-in-input">


                                                    @if($errors->has('phone'))
                                                        <div
                                                            class="error text-danger">@lang($errors->first('phone')) </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <label>@lang('Preferred language')</label>

                                                    <select name="language_id" id="language_id" class="form-control">
                                                        <option value="" disabled>@lang('Select Language')</option>
                                                        @foreach($languages as $la)
                                                            <option value="{{$la->id}}"

                                                                {{ old('language_id', $user->language_id) == $la->id ? 'selected' : '' }}>@lang($la->name)</option>
                                                        @endforeach
                                                    </select>

                                                    @if($errors->has('language_id'))
                                                        <div
                                                            class="error text-danger">@lang($errors->first('language_id')) </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label>@lang('Address')</label>
                                            <textarea class="form-control" name="address"
                                                      rows="5">@lang($user->address)</textarea>

                                            @if($errors->has('address'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('address')) </div>
                                            @endif
                                        </div>

                                        <div class="submit-btn-wrapper text-center text-md-left">
                                            <button type="submit"
                                                    class="btn btn-primary base-btn btn-block btn-rounded">
                                                <span>@lang('Update User')</span></button>
                                        </div>
                                    </form>
                                </div>


                                <div id="menu1"
                                     class="container mt-4 tab-pane {{$errors->has('password')?'active':''}}">

                                    <form method="post" action="{{ route('user.updatePassword') }}">
                                        @csrf
                                        <div class="form-group mt-4">
                                            <label>@lang('Current Password')</label>
                                            <input id="password" type="password" class="form-control"
                                                   name="current_password" autocomplete="off">
                                            @if($errors->has('current_password'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('current_password')) </div>
                                            @endif
                                        </div>
                                        <div class="form-group mt-4">
                                            <label>@lang('New Password')</label>
                                            <input id="password" type="password" class="form-control"
                                                   name="password" autocomplete="off">
                                            @if($errors->has('password'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('password')) </div>
                                            @endif
                                        </div>

                                        <div class="form-group ">
                                            <label>@lang('Confirm Password')</label>
                                            <input id="password_confirmation" type="password"
                                                   name="password_confirmation" autocomplete="off"
                                                   class="form-control">
                                            @if($errors->has('password_confirmation'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('password_confirmation')) </div>
                                            @endif
                                        </div>

                                        <div class="submit-btn-wrapper text-center">
                                            <button type="submit"
                                                    class=" btn btn-primary base-btn btn-block btn-rounded">
                                                <span>@lang('Update Password')</span></button>
                                        </div>
                                    </form>
                                </div>

                                @foreach($kyc as $key => $item)
                                    <div id="{{'kyc'.$key}}" class="container mt-4 tab-pane {{$errors->has($item->name) || session('kycForm') ==$item->name ?'active':''}}" >
                                        @php($check = checkUserKyc($item->id))
                                        @if($check == 'pending')
                                            <div class="alert alert-warning" role="alert">
                                                @lang('Your KYC submission has been pending')
                                            </div>
                                        @elseif($check == true)
                                            <div class="alert alert-success" role="alert">
                                                @lang('Your KYC already verified')
                                            </div>
                                        @else
                                            <form action="{{ route('user.kyc.verification.submit') }}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="row g-4">
                                                    <input type="hidden" name="type" value="{{ $item->id }}">
                                                    @foreach($item->input_form as $k => $value)

                                                        @if($value->type == "text")
                                                            <div class="input-box col-md-12">
                                                                <label for="">{{ $value->field_label }}</label>
                                                                <input type="text" class="form-control"
                                                                       name="{{ $value->field_name }}"
                                                                       value="{{ old($value->field_name) }}"
                                                                       placeholder="{{ $value->field_label }}"
                                                                       autocomplete="off"/>
                                                                @if($errors->has($value->field_name))
                                                                    <div
                                                                        class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if($value->type == "number")
                                                            <div class="input-box col-md-12">
                                                                <label for="">{{ $value->field_label }}</label>
                                                                <input type="text" class="form-control"
                                                                       name="{{ $value->field_name }}"
                                                                       value="{{ old($value->field_name) }}"
                                                                       placeholder="{{ $value->field_label }}"
                                                                       autocomplete="off"/>
                                                                @if($errors->has($value->field_name))
                                                                    <div
                                                                        class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if($value->type == "date")
                                                            <div class="input-box col-md-12">
                                                                <label for="">{{ $value->field_label }}</label>
                                                                <input type="date" class="form-control"
                                                                       name="{{ $value->field_name }}"
                                                                       value="{{old($value->field_name)}}"
                                                                       placeholder="{{ $value->field_label }}"
                                                                       autocomplete="off"/>
                                                                @if($errors->has($value->field_name))
                                                                    <div
                                                                        class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        @if($value->type == "textarea")
                                                            <div class="input-box col-md-12">
                                                                <label for="">{{ $value->field_label }}</label>
                                                                <textarea class="form-control" id="" cols="30"
                                                                          rows="10"
                                                                          name="{{ $value->field_name }}"> {{old( $value->field_name)}} </textarea>
                                                                @if($errors->has($value->field_name))
                                                                    <div
                                                                        class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        @if($value->type == "file")
                                                            <div class="input-box col-12">
                                                                <label for="">{{ $value->field_label }}</label>
                                                                <div class="attach-file">
                                                                    <input class="form-control" accept="image/*"
                                                                           name="{{ $value->field_name }}"
                                                                           type="file"/>
                                                                    @if($errors->has($value->field_name))
                                                                        <div
                                                                            class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        @endif

                                                    @endforeach


                                                    <div class="input-box col-12 mt-3">
                                                        <button type="submit"
                                                                class="btn btn-primary base-btn btn-block btn-rounded">@lang('Submit')</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection

@push('css-lib')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/css/intlTelInput.css">
    <link rel="stylesheet" href="{{asset(template(true).'css/bootstrap-fileinput.css')}}">
@endpush

@push('js-lib')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/intlTelInput.min.js"></script>
    <script src="{{asset(template(true).'js/bootstrap-fileinput.js')}}"></script>
@endpush


@push('script')
    <script>

        $(document).on('change', '#image', function (event) {
            let imageFile = event.target.files[0];
            let url = '{{route('user.profile.update.image')}}';
            $('#profile').attr('src', URL.createObjectURL(event.target.files[0]));
            let formData = new FormData();
            formData.append('image', imageFile);
            axios.post(url, formData, {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            })
                .then(function (res) {
                    if (res.data.err) {
                        Notiflix.Notify.failure(res.data.err);
                    } else {
                        Notiflix.Notify.success(res.data);
                    }

                })
                .catch(function (error) {

                });
        });
        $(document).ready(function (){

            // International Telephone Input start
            const input = document.querySelector("#telephone");
            const iti = window.intlTelInput(input, {
                initialCountry: "bd",
                separateDialCode: true,
            });
            input.addEventListener("countrychange", updateCountryInfo);
            updateCountryInfo();
            function updateCountryInfo() {
                const selectedCountryData = iti.getSelectedCountryData();
                const phoneCode = '+' + selectedCountryData.dialCode;
                const countryCode = selectedCountryData.iso2;
                const countryName = selectedCountryData.name;
                $('#phoneCode').val(phoneCode);
                $('#countryCode').val(countryCode);
                $('#countryName').val(countryName);
            }

            const initialPhone = "{{$user->phone??null}}";
            const initialPhoneCode = "{{$user->phone_code??null}}";
            const initialCountryCode = "{{$user->country_code??null}}";
            const initialCountry = "{{$user->country??null}}";
            if (initialPhoneCode) {
                iti.setNumber(initialPhoneCode);
            }
            if (initialCountryCode) {
                iti.setNumber(initialCountryCode);
            }
            if (initialCountry) {
                iti.setNumber(initialCountry);
            }
            if (initialPhone) {
                iti.setNumber(initialPhone);
            }
        })

    </script>
@endpush

@push('script')
    <script>
        "use strict";
        $(document).on('click', '#image-label', function () {
            $('#image').trigger('click');
        });
        $(document).on('change', '#image', function () {
            var _this = $(this);
            var newimage = new FileReader();
            newimage.readAsDataURL(this.files[0]);
            newimage.onload = function (e) {
                $('#image_preview_container').attr('src', e.target.result);
            }
        });

        $(document).on('change', "#identity_type", function () {
            let value = $(this).find('option:selected').val();
            window.location.href = "{{route('user.profile')}}/?identity_type=" + value
        });
    </script>
@endpush

@push('style')
    <style>
        #telephone{
            width: 100%;
            border: none;
            border-radius: 5px;
        }

        #telephone:focus{
            border: 1px solid var(--themecolor);
        }

        .iti--show-flags{
            width: 100%;
        }
        #telephone{
            width: 100% !important;
            height: 50px;
            border-radius: 5px;
            background-color: transparent;
            padding: 15px;
            font-weight: normal;
            font-size: 14px;
            caret-color: #FFFFFF;
            color: var(--fontColor);
            border: 1px solid #a1a1a1
        }

        .iti--inline-dropdown .iti__dropdown-content{
            width: 300px !important;
        }

        #iti-0__dropdown-content{
            background: var(--background-1);
        }
    </style>
@endpush

@extends(template().'layouts.user')
@section('title',trans('Profile Settings'))

@section('content')

    <section class="profile-setting">
        <div class="container-fluid">
            <div class="main row">
                <div class="col-12">
                    <div
                        class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0">@lang('Profile Settings')</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="upload-img">
                                <form method="post" action="" enctype="multipart/form-data">
                                    @csrf
                                    <div class="img-box">
                                        <input
                                            accept="image/*"
                                            name="image"
                                            type="file"
                                            id="image"
                                            onchange="previewImage()"
                                        />
                                        <span class="select-file text-white"
                                        >@lang('Choose image')</span
                                        >
                                        <img
                                            id="frame"
                                            src="{{getFile($user->image_driver,$user->image)}}"
                                            alt="@lang('preview user image')"
                                        />
                                    </div>
                                    @error('image')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <h3 class="golden-text">@lang(ucfirst($user->username)) <sup><sapn class="badge badge-pill bg-outline-success badge_lavel_style text-white border-1">{{ @$user->rank->rank_lavel }}</sapn></sup></h3>
                                    <h4> @lang(@$user->rank->rank_name)</h4>
                                    <p>@lang('Joined At') @lang(dateTime($user->created_at))</p>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="edit-area">
                                <div class="profile-navigator">
                                    <button
                                        tab-id="tab1"
                                        class="darkblue-text-bold tab {{$errors->all() || session('kycForm')?$errors->has('profile') || $errors->has('profileImage') ?'active':'':'active'}}"
                                    >
                                        @lang('Profile Information')
                                    </button>
                                    <button tab-id="tab2" class="darkblue-text-bold tab {{$errors->has('password')? 'active':''}}">
                                        @lang('Password Setting')
                                    </button>
                                    @foreach($kyc as $key => $value)
                                        <button
                                            class="darkblue-text-bold tab {{$errors->has($value->name) || session('kycForm') ==$value->name? 'active':''}} {{session($value->name)?'active':''}}"
                                            tab-id="tab{{$key+3}}"
                                            type="button"
                                        >
                                            <i class="fal fa-id-card"></i>
                                            @lang(ucfirst($value->name))
                                        </button>
                                    @endforeach
                                </div>

                                <div id="tab1" class="content {{$errors->all() || session('kycForm')?$errors->has('profile')|| $errors->has('profileImage')?'show active':'':'show active'}}">
                                    <form action="{{ route('user.profile.update')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label for="firstname" class="golden-text">@lang('First Name')</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="first_name"
                                                    id="firstname"
                                                    value="{{old('first_name')?: $user->firstname }}"
                                                />
                                                @error('first_name')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="lastname" class="golden-text">@lang('Last Name')</label>
                                                <input
                                                    type="text"
                                                    id="lastname"
                                                    name="last_name"
                                                    class="form-control"
                                                    value="{{old('last_name')?: $user->lastname }}"
                                                />
                                                @error('last_name')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="username" class="golden-text">@lang('Username')</label>
                                                <input
                                                    type="text"
                                                    id="username"
                                                    name="username"
                                                    value="{{old('username')?: $user->username }}"
                                                    class="form-control"
                                                />
                                                @error('username')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="email" class="golden-text">@lang('Email Address')</label>
                                                <input
                                                    type="email"
                                                    id="email"
                                                    value="{{ $user->email }}"
                                                    name="email"
                                                    class="form-control"
                                                />
                                                @error('email')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="phone" class="golden-text">@lang('Phone Number')</label>
                                                <div>
                                                    <input type="hidden" name="phone_code" id="phoneCode">
                                                    <input type="hidden" name="country_code" id="countryCode">
                                                    <input type="hidden" name="country" id="countryName">
                                                    <input type="tel" id="telephone" name="phone"
                                                           value="{{old('phone',$user->phone)}}" class="form-control"
                                                           placeholder="e.g : 1976547587" required>
                                                </div>
                                                @error('phone')
                                                <div class="text-danger">{{$message}}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="language_id" class="golden-text">@lang('Preferred language')</label>
                                                <select
                                                    class="form-select"
                                                    name="language"
                                                    id="language_id"
                                                    aria-label="Default select example"
                                                >
                                                    <option value="" disabled>@lang('Select Language')</option>
                                                    @foreach($languages as $la)
                                                        <option value="{{$la->id}}" {{ old('language_id', $user->language_id) == $la->id ? 'selected' : '' }}>
                                                            @lang($la->name)
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('language_id'))
                                                    <div
                                                        class="error text-danger">@lang($errors->first('language_id'))
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-12 mb-4">
                                                <label for="address" class="golden-text">@lang('Address')</label>
                                                <textarea
                                                    class="form-control"
                                                    id="address"
                                                    name="address"
                                                    cols="30"
                                                    rows="3"
                                                >@lang($user->address)</textarea>
                                                @if($errors->has('address'))
                                                    <div
                                                        class="error text-danger">@lang($errors->first('address'))
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                        <button type="submit" class="gold-btn btn-custom">@lang('Update User')</button>
                                    </form>
                                </div>

                                <div id="tab2" class="content {{$errors->has('password')?'active':''}}">
                                    <form method="post" action="{{ route('user.updatePassword') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label for="current_password" class="golden-text">@lang('Current Password')</label>
                                                <input
                                                    type="password"
                                                    id="current_password"
                                                    name="current_password"
                                                    autocomplete="off"
                                                    class="form-control"
                                                    placeholder="@lang('Enter Current Password')"
                                                />
                                                @if($errors->has('current_password'))
                                                    <div class="error text-danger">@lang($errors->first('current_password'))</div>
                                                @endif
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="password" class="golden-text">@lang('New Password')</label>
                                                <input
                                                    type="password"
                                                    id="password"
                                                    name="password"
                                                    autocomplete="off"
                                                    class="form-control"
                                                    placeholder="@lang('Enter New Password')"
                                                />
                                                @if($errors->has('password'))
                                                    <div class="error text-danger">@lang($errors->first('password'))</div>
                                                @endif
                                            </div>

                                            <div class="col-12 mb-4">
                                                <label for="password_confirmation" class="golden-text">@lang('Confirm Password')</label>
                                                <input
                                                    type="password"
                                                    id="password_confirmation"
                                                    name="password_confirmation"
                                                    autocomplete="off"
                                                    class="form-control"
                                                    placeholder="@lang('Confirm Password')"
                                                />
                                                @if($errors->has('password_confirmation'))
                                                    <div class="error text-danger">@lang($errors->first('password_confirmation'))</div>
                                                @endif
                                            </div>
                                        </div>
                                        <button type="submit" class="gold-btn btn-custom">
                                            @lang('Update Password')
                                        </button>
                                    </form>
                                </div>

                                @forelse($kyc as $kyc_key => $item)
                                    @php($check = checkUserKyc($item->id))
                                    <div
                                        class="content {{$errors->has($item->name) || session('kycForm') ==$item->name ?'active':''}}"
                                        id="tab{{$key+3}}"
                                        role="tabpanel"
                                        aria-labelledby="tab-{{$kyc_key}}-tab">
                                        <div class="alert mb-0">
                                            @if($check == 'pending')
                                                <div class="card">
                                                    <div class="card-header bg-white">
                                                        <h4 class="card-header-title">@lang('KYC Information')</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="">
                                                            <div class="img">
                                                                <img src="{{asset(template(true).'img/img/pending.jpg')}}"
                                                                     id="verifiedImg" alt="" srcset="">
                                                            </div>
                                                            <div class="text">
                                                                <span
                                                                    class="KycverifiedMessage text-center text-primary">@lang('Your KYC is Pending')</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($check == true)
                                                <div class="card">
                                                    <div class="card-header bg-white">
                                                        <h4 class="card-header-title">@lang('KYC Information')</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="">
                                                            <div class="img">
                                                                <img src="{{asset(template(true).'img/img/verified.jpg')}}"
                                                                     id="verifiedImg" alt="" srcset="">
                                                            </div>
                                                            <div class="text">
                                                                <span
                                                                    class="KycverifiedMessage text-center text-success">@lang('Your KYC is Verified')</span>
                                                            </div>
                                                        </div>
                                                    </div>
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


                                                        <div class="input-box col-12">
                                                            <button type="submit"
                                                                    class="btn-custom">@lang('Submit')</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('css-lib')
    <link rel="stylesheet" href="{{asset(template(true).'css/bootstrap-fileinput.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/css/intlTelInput.css">
@endpush


@push('js-lib')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/intlTelInput.min.js"></script>
@endpush
@push('script')
    <script src="{{asset(template(true).'js/bootstrap-fileinput.js')}}"></script>
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

        $(document).ready(function () {

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
        $(document).on('change', "#identity_type", function () {
            let value = $(this).find('option:selected').val();
            window.location.href = "{{route('user.profile')}}/?identity_type=" + value
        });
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

        $(document).on('change', '#deleteCheckbox', function () {
            if ($(this).is(':checked')) {
                $('.delete-btn').prop('disabled', false);
            } else {
                $('.delete-btn').prop('disabled', true);
            }
        });
    </script>
@endpush

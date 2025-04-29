@extends(template().'layouts.user')
@section('title',trans('Profile'))
@section('content')
    <!-- profile setting -->
    <section class="profile-setting mt-5 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="header-text-full">
                        <h2>@lang('Profile Settings')</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="upload-img">
                        <form method="post" action="{{ route('user.profile.update.image') }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="profile">
                                <div class="img-box">
                                    <input
                                        accept="image/*"
                                        name="image"
                                        type="file"
                                        id="profileImageInput"
                                    />
                                    <span class="select-file"
                                    >@lang('Choose image')</span
                                    >
                                    <img
                                        id="profile"
                                        src="{{getFile(Auth::user()->image_driver, Auth::user()->image)}}"
                                        alt="@lang('preview user image')"
                                    />

                                </div>
                                <h3 class="golden-text">@lang(ucfirst($user->username)) <sup>
                                        <sapn
                                            class="badge badge-pill bg-outline-success badge_lavel_style text-white">{{ @$user->rank->rank_lavel }}</sapn>
                                    </sup></h3>
                                <h4 class="golden-text">{{ @$user->rank->rank_name }}</h4>
                                <p class="mb-2">@lang('Joined At') {{dateTime($user->created_at)}}</p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="edit-area">
                        <div class="profile-navigator">
                            <button
                                tab-id="tab1"
                                class="golden-text tab {{$errors->all() || session('kycForm')?$errors->has('profile') || $errors->has('profileImage') ?'active':'':'active'}}">
                                @lang('Profile Information')
                            </button>
                            <button tab-id="tab2"
                                    class="golden-text tab {{$errors->has('password')? 'active':''}}">
                                @lang('Password Setting')
                            </button>
                            @foreach($kyc as $key => $value)
                                <button tab-id="tab{{$key+3}}"
                                        class="golden-text tab {{$errors->has($value->name) || session('kycForm') ==$value->name? 'active':''}} {{session($value->name)?'active':''}} ">
                                    @lang(ucfirst($value->name))
                                </button>
                            @endforeach
                        </div>
                        <div id="tab1"
                             class="content {{$errors->all() || session('kycForm')?$errors->has('profile')|| $errors->has('profileImage')?'active':'':'active'}}">
                            <form action="{{ route('user.profile.update')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="first_name" class="golden-text">@lang('First Name')</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="first_name"
                                            id="first_name"
                                            value="{{old('first_name')?: $user->firstname }}"/>
                                        @if($errors->has('first_name'))
                                            <div
                                                class="error text-danger">@lang($errors->first('first_name'))
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="last_name" class="golden-text">@lang('Last Name')</label>
                                        <input
                                            type="text"
                                            id="last_name"
                                            name="last_name"
                                            class="form-control"
                                            value="{{old('last_name')?: $user->lastname }}"
                                        />
                                        @if($errors->has('last_name'))
                                            <div
                                                class="error text-danger">@lang($errors->first('last_name'))
                                            </div>
                                        @endif
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
                                        @if($errors->has('username'))
                                            <div
                                                class="error text-danger">@lang($errors->first('username'))
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="email" class="golden-text">@lang('Email Address')</label>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email',$user->email) }}"
                                            class="form-control"
                                        />
                                        @if($errors->has('email'))
                                            <div
                                                class="error text-danger">@lang($errors->first('email'))
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="phone" class="golden-text">@lang('Phone Number')</label>
                                        <input type="hidden" name="phone_code" id="phoneCode">
                                        <input type="hidden" name="country_code" id="countryCode">
                                        <input type="hidden" name="country" id="countryName">
                                        <input type="tel" id="telephone" name="phone"
                                               value="{{old('phone',$user->phone)}}" class="form-control"
                                               placeholder="e.g : 1976547587" required>
                                        @if($errors->has('phone'))
                                            <div
                                                class="error text-danger">@lang($errors->first('phone'))
                                            </div>
                                        @endif
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
                                                <option
                                                    value="{{$la->id}}" {{ old('language', $user->language_id) == $la->id ? 'selected' : '' }}>
                                                    @lang($la->name)
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('language'))
                                            <div
                                                class="error text-danger">@lang($errors->first('language'))
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
                                        >@lang(old('address',$user->address))</textarea>
                                        @if($errors->has('address'))
                                            <div
                                                class="error text-danger">@lang($errors->first('address'))
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <button type="submit" class="gold-btn">@lang('Update User')</button>
                            </form>
                        </div>
                        <div id="tab2" class="content {{ $errors->has('password') ? 'active' : '' }}">
                            <form method="post" action="{{ route('user.updatePassword') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="current_password"
                                               class="golden-text">@lang('Current Password')</label>
                                        <input
                                            type="password"
                                            id="current_password"
                                            name="current_password"
                                            autocomplete="off"
                                            class="form-control"
                                            placeholder="@lang('Enter Current Password')"
                                        />
                                        @if($errors->has('current_password'))
                                            <div
                                                class="error text-danger">@lang($errors->first('current_password'))</div>
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
                                        <label for="password_confirmation"
                                               class="golden-text">@lang('Confirm Password')</label>
                                        <input
                                            type="password"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            autocomplete="off"
                                            class="form-control"
                                            placeholder="@lang('Confirm Password')"
                                        />
                                        @if($errors->has('password_confirmation'))
                                            <div
                                                class="error text-danger">@lang($errors->first('password_confirmation'))</div>
                                        @endif
                                    </div>
                                </div>
                                <button type="submit" class="gold-btn">
                                    @lang('Update Password')
                                </button>
                            </form>
                        </div>
                        @forelse($kyc as $kyc_key => $item)
                            @php($check = checkUserKyc($item->id))
                            <div
                                id="tab{{$kyc_key+3}}"
                                class="content {{$errors->has($item->name) || session('kycForm') ==$item->name ?'active':''}} "

                            >
                                @if($check == 'pending')
                                    <div class="">
                                        <div class="">
                                            <h4 class="card-header-title">@lang('KYC Information')</h4>
                                        </div>
                                        <div class="">
                                            <div class="">
                                                <div class="img">
                                                    <img src="{{asset('assets/global/img/pending.jpg')}}"
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
                                    <div class="">
                                        <div class="">
                                            <h4 class="card-header-title">@lang('KYC Information')</h4>
                                        </div>
                                        <div class="">
                                            <div class="">
                                                <div class="img">
                                                    <img src="{{asset('assets/global/img/verified.jpg')}}"
                                                         id="verifiedImg" alt="" srcset="">
                                                </div>
                                                <div class="text mt-3">
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
                                        <div class="row">
                                            <input type="hidden" name="type" value="{{ $item->id }}">
                                            @foreach($item->input_form as $k => $value)

                                                @if($value->type == "text")
                                                    <div class="col-md-6 mb-4">
                                                        <label for="{{ $value->field_name }}"
                                                               class="golden-text">{{ $value->field_label }}</label>
                                                        <input type="text" class="form-control"
                                                               name="{{ $value->field_name }}"
                                                               value="{{ old($value->field_name) }}"
                                                               placeholder="{{ $value->field_label }}"
                                                               id="{{ $value->field_name }}"
                                                               autocomplete="off"/>
                                                        @if($errors->has($value->field_name))
                                                            <div
                                                                class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                        @endif
                                                    </div>
                                                @endif
                                                @if($value->type == "number")
                                                    <div class="col-md-6 mb-4">
                                                        <label for="{{ $value->field_name }}"
                                                               class="golden-text">{{ $value->field_label }}</label>
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
                                                    <div class="col-md-6 mb-4">
                                                        <label for="{{ $value->field_name }}"
                                                               class="golden-text">{{ $value->field_label }}</label>
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
                                                    <div class="col-md-6 mb-4">
                                                        <label for="{{ $value->field_name }}"
                                                               class="golden-text">{{ $value->field_label }}</label>
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
                                                    <div class="col-md-6 mb-4">
                                                        <label for="{{ $value->field_name }}"
                                                               class="golden-text">{{ $value->field_label }}</label>
                                                        <div class="attach-file">
                                             <span class="prev"> <i
                                                     class="fa-duotone fa-link"></i> </span>
                                                            <input class="form-control" accept="image/*"
                                                                   name="{{ $value->field_name }}"
                                                                   type="file"/>
                                                        </div>
                                                        @if($errors->has($value->field_name))
                                                            <div
                                                                class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                        @endif
                                                    </div>

                                                @endif

                                            @endforeach


                                            <div class="input-box col-12">
                                                <button type="submit"
                                                        class="gold-btn">@lang('Submit')</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        #telephone {
            height: 50px !important;

        }

    </style>
@endpush

@push('css-lib')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/css/intlTelInput.css">
@endpush

@push('js-lib')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/intlTelInput.min.js"></script>
@endpush

@push('script')
    <script>
        $(document).on('change', '#deleteCheckbox', function () {
            if ($(this).is(':checked')) {
                $('.delete-btn').prop('disabled', false);
            } else {
                $('.delete-btn').prop('disabled', true);
            }
        });
        $(document).on('change', '#profileImageInput', function (event) {
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
    </script>
@endpush

@push('style')
    <style>
        #verifiedImg {
            height: 200px;
            width: 200px;
            display: block;
            margin: auto;
        }

        .KycverifiedMessage {
            font-size: 20px;
            display: block;
            margin: auto;
        }

        .iti--show-flags {
            width: 100%;
        }
    </style>
@endpush



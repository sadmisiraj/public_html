@extends(template().'layouts.user')
@section('title',trans('Profile Settings'))

@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Profile')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Profile')</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <!-- Left side columns -->

        <div class="row">
            <!-- Account-settings -->
            <!-- Account settings navbar start -->
            <div class="account-settings-navbar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link {{$errors->all() || session('kycForm')?$errors->has('profile') || $errors->has('profileImage') ?'active':'':'active'}}"
                           aria-current="page" href="javascript:void(0)"
                           data-target="#tab-profile"
                        ><i
                                class="fa-regular fa-user"></i>@lang('Profile')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$errors->has('password')? 'active':''}}"
                           data-target="#tab-password"
                           href="javascript:void(0)"><i
                                class="fal fa-key"></i>@lang('Password')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           data-target="#tab-rgp"
                           href="javascript:void(0)"><i
                                class="fal fa-chart-network"></i>@lang('RGP')</a>
                    </li>
                    @foreach($kyc as $key => $value)
                        <li class="nav-item">
                            <a class="nav-link {{$errors->has($value->name) || session('kycForm') ==$value->name? 'active':''}} {{session($value->name)?'active':''}}"
                               href="javascript:void(0)"
                               data-target="{{'#tab-'.$key}}"
                            ><i
                                    class="fa-regular fa-link"></i> @lang(ucfirst($value->name))</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- Account settings navbar end -->
            <div id="tab-profile"
                 class="tab-content {{$errors->all() || session('kycForm')?$errors->has('profile')|| $errors->has('profileImage')?'content':'':'content'}}">
                <form action="{{ route('user.profile.update')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="account-settings-profile-section">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Profile Details')
                                </h5>
                                <div class="profile-details-section">
                                    <div class="d-flex gap-3 align-items-center">
                                        <div class="image-area">
                                            <img id="profile-img"
                                                 src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}"
                                                 alt="EstateRise">
                                        </div>
                                        <div class="btn-area">
                                            <div class="btn-area-inner d-flex">
                                                <div class="cmn-file-input">
                                                    <label for="formFile"
                                                           class="form-label">@lang('Upload New Photo')</label>
                                                    <input class="form-control" type="file" id="formFile"
                                                           onchange="previewImage('profile-img')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">

                                <div class="profile-form-section">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="first_name" class="form-label">@lang('First Name')</label>
                                            <input type="text" class="form-control"
                                                   value="{{ old('first_name', $user->firstname) }}" name="first_name"
                                                   id="first_name">
                                            @if($errors->has('first_name'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('first_name')) </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname" class="form-label">@lang('Last Name')</label>
                                            <input type="text" class="form-control"
                                                   value="{{ old('last_name', $user->lastname) }}" name="last_name"
                                                   id="lastname">
                                            @if($errors->has('last_name'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('last_name')) </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="username" class="form-label">@lang('user ID')</label>
                                            <input type="text" name="username"
                                                   value="{{ old('username', $user->username) }}"
                                                   class="form-control" id="username" readonly disabled>
                                            <small class="text-muted">@lang('Username cannot be changed for security reasons.')</small>
                                            @if($errors->has('username'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('username')) </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">@lang('email address')</label>
                                            <input type="text" name="email" value="{{ old('email', $user->email) }}"
                                                   class="form-control" id="email" readonly disabled>
                                            <small class="text-muted">@lang('Email cannot be changed for security reasons.')</small>
                                            @if($errors->has('email'))
                                                <div class="error text-danger">@lang($errors->first('email')) </div>
                                            @endif
                                        </div>
                                        @php
                                            $country_code = old('phone_code',$user->phone_code);
                                            $myCollection = collect(config('country'))->map(function($row) {
                                                return collect($row);
                                            });
                                            $countries = $myCollection->sortBy('code');
                                        @endphp
                                        <div class="col-md-6" style="display: none;">
                                            <input type="hidden" name="country"
                                                   value="{{old('country',$user->country)}}" id="country">
                                            <input type="hidden" name="country_code"
                                                   value="{{old('country_code',$user->country_code)}}"
                                                   id="country_code">
                                            <label class="form-label">@lang('Phone Code')</label>
                                            <select name="phone_code" class="cmn-select2 phone_code">
                                                @foreach(config('country') as $value)
                                                    <option value="{{$value['phone_code']}}"
                                                            data-name="{{$value['name']}}"
                                                            data-code="{{$value['code']}}"
                                                        {{old('phone_code',$user->phone_code) == $value['phone_code'] ? 'selected' : ''}}
                                                    > {{$value['name']}} ({{$value['phone_code']}})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">@lang('Phone Number')</label>
                                            <input type="text" name="phone" value="{{old('phone',$user->phone)}}"
                                                   class="form-control" id="phonenumber" readonly disabled>
                                            <small class="text-muted">@lang('Phone number cannot be changed for security reasons.')</small>
                                            @error('phone')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">@lang('State')</label>
                                            <select name="state" class="cmn-select2 state-select" id="state">
                                                <option value="" disabled>@lang('Select State')</option>
                                                <option value="Andhra Pradesh" {{ (old('state', $user->state) == 'Andhra Pradesh') ? 'selected' : '' }}>Andhra Pradesh</option>
                                                <option value="Arunachal Pradesh" {{ (old('state', $user->state) == 'Arunachal Pradesh') ? 'selected' : '' }}>Arunachal Pradesh</option>
                                                <option value="Assam" {{ (old('state', $user->state) == 'Assam') ? 'selected' : '' }}>Assam</option>
                                                <option value="Bihar" {{ (old('state', $user->state) == 'Bihar') ? 'selected' : '' }}>Bihar</option>
                                                <option value="Chhattisgarh" {{ (old('state', $user->state) == 'Chhattisgarh') ? 'selected' : '' }}>Chhattisgarh</option>
                                                <option value="Goa" {{ (old('state', $user->state) == 'Goa') ? 'selected' : '' }}>Goa</option>
                                                <option value="Gujarat" {{ (old('state', $user->state) == 'Gujarat') ? 'selected' : '' }}>Gujarat</option>
                                                <option value="Haryana" {{ (old('state', $user->state) == 'Haryana') ? 'selected' : '' }}>Haryana</option>
                                                <option value="Himachal Pradesh" {{ (old('state', $user->state) == 'Himachal Pradesh') ? 'selected' : '' }}>Himachal Pradesh</option>
                                                <option value="Jharkhand" {{ (old('state', $user->state) == 'Jharkhand') ? 'selected' : '' }}>Jharkhand</option>
                                                <option value="Karnataka" {{ (old('state', $user->state) == 'Karnataka') ? 'selected' : '' }}>Karnataka</option>
                                                <option value="Kerala" {{ (old('state', $user->state) == 'Kerala') ? 'selected' : '' }}>Kerala</option>
                                                <option value="Madhya Pradesh" {{ (old('state', $user->state) == 'Madhya Pradesh') ? 'selected' : '' }}>Madhya Pradesh</option>
                                                <option value="Maharashtra" {{ (old('state', $user->state) == 'Maharashtra') ? 'selected' : '' }}>Maharashtra</option>
                                                <option value="Manipur" {{ (old('state', $user->state) == 'Manipur') ? 'selected' : '' }}>Manipur</option>
                                                <option value="Meghalaya" {{ (old('state', $user->state) == 'Meghalaya') ? 'selected' : '' }}>Meghalaya</option>
                                                <option value="Mizoram" {{ (old('state', $user->state) == 'Mizoram') ? 'selected' : '' }}>Mizoram</option>
                                                <option value="Nagaland" {{ (old('state', $user->state) == 'Nagaland') ? 'selected' : '' }}>Nagaland</option>
                                                <option value="Odisha" {{ (old('state', $user->state) == 'Odisha') ? 'selected' : '' }}>Odisha</option>
                                                <option value="Punjab" {{ (old('state', $user->state) == 'Punjab') ? 'selected' : '' }}>Punjab</option>
                                                <option value="Rajasthan" {{ (old('state', $user->state) == 'Rajasthan') ? 'selected' : '' }}>Rajasthan</option>
                                                <option value="Sikkim" {{ (old('state', $user->state) == 'Sikkim') ? 'selected' : '' }}>Sikkim</option>
                                                <option value="Tamil Nadu" {{ (old('state', $user->state) == 'Tamil Nadu') ? 'selected' : '' }}>Tamil Nadu</option>
                                                <option value="Telangana" {{ (old('state', $user->state) == 'Telangana') ? 'selected' : '' }}>Telangana</option>
                                                <option value="Tripura" {{ (old('state', $user->state) == 'Tripura') ? 'selected' : '' }}>Tripura</option>
                                                <option value="Uttar Pradesh" {{ (old('state', $user->state) == 'Uttar Pradesh') ? 'selected' : '' }}>Uttar Pradesh</option>
                                                <option value="Uttarakhand" {{ (old('state', $user->state) == 'Uttarakhand') ? 'selected' : '' }}>Uttarakhand</option>
                                                <option value="West Bengal" {{ (old('state', $user->state) == 'West Bengal') ? 'selected' : '' }}>West Bengal</option>
                                                <option value="Andaman and Nicobar Islands" {{ (old('state', $user->state) == 'Andaman and Nicobar Islands') ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                                                <option value="Chandigarh" {{ (old('state', $user->state) == 'Chandigarh') ? 'selected' : '' }}>Chandigarh</option>
                                                <option value="Dadra and Nagar Haveli and Daman and Diu" {{ (old('state', $user->state) == 'Dadra and Nagar Haveli and Daman and Diu') ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                                                <option value="Delhi" {{ (old('state', $user->state) == 'Delhi') ? 'selected' : '' }}>Delhi</option>
                                                <option value="Jammu and Kashmir" {{ (old('state', $user->state) == 'Jammu and Kashmir') ? 'selected' : '' }}>Jammu and Kashmir</option>
                                                <option value="Ladakh" {{ (old('state', $user->state) == 'Ladakh') ? 'selected' : '' }}>Ladakh</option>
                                                <option value="Lakshadweep" {{ (old('state', $user->state) == 'Lakshadweep') ? 'selected' : '' }}>Lakshadweep</option>
                                                <option value="Puducherry" {{ (old('state', $user->state) == 'Puducherry') ? 'selected' : '' }}>Puducherry</option>
                                            </select>
                                            @error('state')
                                            <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="address" class="form-label">@lang('address')</label>
                                            <input type="text" name="address"
                                                   value="{{ old('address', $user->address) }}" class="form-control"
                                                   id="address">
                                            @if($errors->has('address'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('address')) </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="btn-area d-flex g-3">
                                        <button type="submit" class="cmn-btn">@lang('save changes')</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="tab-password" class="tab-content {{$errors->has('password')?'content':''}}">
                <form action="{{ route('user.updatePassword') }}" method="post">
                    @csrf
                    <div class="account-settings-profile-section">
                        <div class="card">
                            <div class="card-body pt-0">

                                <div class="profile-form-section">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="current_password"
                                                   class="form-label">@lang('Current Password')</label>
                                            <input type="password" name="current_password" class="form-control"
                                                   id="current_password" autocomplete="off">
                                            @if($errors->has('current_password'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('current_password')) </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">@lang('New Password')</label>
                                            <input type="password" name="password" class="form-control" id="password">
                                            @if($errors->has('password'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('password')) </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation"
                                                   class="form-label">@lang('Confirm Password')</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                   id="password_confirmation" autocomplete="off">
                                            @if($errors->has('password_confirmation'))
                                                <div
                                                    class="error text-danger">@lang($errors->first('password_confirmation')) </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="btn-area d-flex g-3">
                                        <button type="submit" class="cmn-btn">@lang('save changes')</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div id="tab-rgp" class="tab-content">
                <div class="account-settings-profile-section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">@lang('RGP Details')</h5>
                        </div>
                        <div class="card-body pt-0">
                            <div class="profile-form-section">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="rgp_l" class="form-label">@lang('RGP L')</label>
                                        <input type="text" class="form-control" id="rgp_l" value="{{ $user->rgp_l ?? 'N/A' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="rgp_r" class="form-label">@lang('RGP R')</label>
                                        <input type="text" class="form-control" id="rgp_r" value="{{ $user->rgp_r ?? 'N/A' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="rgp_pair_matching" class="form-label">@lang('RGP Pair Matching')</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="rgp_pair_matching" 
                                                value="{{ min(floatval($user->rgp_l ?? 0), floatval($user->rgp_r ?? 0)) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle mr-2"></i> @lang('RGP values can be credited when Left and Right RGP values are matched.')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @forelse($kyc as $kyc_key => $item)
                <div id="tab-{{$kyc_key}}"
                     class="tab-content {{$errors->has($item->name) || session('kycForm') ==$item->name ?'content':''}}">

                    <div class="account-settings-profile-section">
                        <div class="card">
                            @php($check = checkUserKyc($item->id))
                            @if($check == 'pending')
                                <div class="card-header bg-white">
                                    <h4 class="card-header-title">@lang('KYC Information')</h4>
                                </div>
                                <div class="card-body">
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
                            @elseif($check == true)
                                <div class="card-header">
                                    <h4 class="card-header-title">@lang('KYC Information')</h4>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <div class="img">
                                            <img src="{{asset('assets/global/img/verified.jpg')}}"
                                                 id="verifiedImg" alt="" srcset="">
                                        </div>
                                        <div class="text">
                                                                <span
                                                                    class="KycverifiedMessage text-center text-success">@lang('Your KYC is Verified')</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                            <div class="card-header">
                                    <p class="card-header-title">@lang('Before you submit for KYC verification, please ensure that you have filled in all the profile details correctly. Otherwise, it may take longer to complete the verification.Only one account can be created using one PAN card information. Otherwise, the verification will be rejected.')</p>
                                </div>
                                <form action="{{ route('user.kyc.verification.submit') }}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ $item->id }}">
                                    <div class="card-body pt-0">

                                        <div class="profile-form-section">
                                            <div class="row g-3">
                                                @foreach($item->input_form as $k => $value)
                                                    @if($value->type == "text")
                                                        <div class="col-md-6">
                                                            <label for="{{ $value->field_name }}"
                                                                   class="form-label">{{ $value->field_label }}</label>
                                                            <input type="text" name="{{ $value->field_name }}"
                                                                   class="form-control"
                                                                   value="{{ old($value->field_name) }}"
                                                                   id="{{ $value->field_name }}">
                                                            @if($errors->has($value->field_name))
                                                                <div
                                                                    class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    @if($value->type == "number")
                                                            <div class="col-md-6">
                                                                <label for="{{ $value->field_name }}"
                                                                       class="form-label">{{ $value->field_label }}</label>
                                                                <input type="number" name="{{ $value->field_name }}"
                                                                       class="form-control"
                                                                       value="{{ old($value->field_name) }}"
                                                                       id="{{ $value->field_name }}">
                                                                @if($errors->has($value->field_name))
                                                                    <div
                                                                        class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                                @endif
                                                            </div>
                                                    @endif
                                                        @if($value->type == "date")
                                                            <div class="col-md-6">
                                                                <label for="{{ $value->field_name }}"
                                                                       class="form-label">{{ $value->field_label }}</label>
                                                                <input type="date" name="{{ $value->field_name }}"
                                                                       class="form-control"
                                                                       value="{{ old($value->field_name) }}"
                                                                       id="{{ $value->field_name }}">
                                                                @if($errors->has($value->field_name))
                                                                    <div
                                                                        class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if($value->type == "textarea")
                                                            <div class="col-md-6">
                                                                <label for="{{ $value->field_name }}"
                                                                       class="form-label">{{ $value->field_label }}</label>
                                                                <textarea class="form-control" name="{{ $value->field_name }}"  id="{{ $value->field_name }}"> {{ old($value->field_name) }}</textarea>
                                                                @if($errors->has($value->field_name))
                                                                    <div
                                                                        class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if($value->type == "file")
                                                            <div class="col-md-6">
                                                                <label for="{{ $value->field_name }}"
                                                                       class="form-label">{{ $value->field_label }}</label>
                                                                <input type="file" name="{{ $value->field_name }}"
                                                                       class="form-control"
                                                                       id="{{ $value->field_name }}">
                                                                @if($errors->has($value->field_name))
                                                                    <div
                                                                        class="error text-danger">@lang($errors->first($value->field_name)) </div>
                                                                @endif
                                                            </div>
                                                        @endif

                                                @endforeach

                                            </div>
                                            <div class="btn-area d-flex g-3">
                                                <button type="submit" class="cmn-btn">@lang('submit')</button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>

    </div>

@endsection
@push('script')
    <script>
        "use strict";
        $(document).ready(function(){
            // Initialize state select with search
            $('.state-select').select2({
                placeholder: "@lang('Select State')",
                allowClear: true,
                width: '100%'
            });
            
            $(document).on('click', '.account-settings-navbar .nav-link', function () {
                // Remove 'active' class from all nav links
                $('.account-settings-navbar .nav-link').removeClass('active');

                // Add 'active' class to the clicked element
                $(this).addClass('active');

                // Hide all tab content sections
                $('.tab-content').removeClass('content');

                // Show the target tab content section
                let target = $(this).data('target');
                $(target).removeClass('content').addClass('content');
            });

            $(document).on('change', '#formFile', function () {
                var _this = $(this);
                var newimage = new FileReader();
                newimage.readAsDataURL(this.files[0]);
                newimage.onload = function (e) {
                    $('#profile-img').attr('src', e.target.result);
                }
            });
            
            $(document).on('change', '#formFile', function (event) {
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
            
            $(document).on('change', '.phone_code', function () {
                let selectedOption = $(this).find('option:selected'); // Find the selected option
                let name = selectedOption.data('name');
                let code = selectedOption.data('code');

                $('#country').val(name);
                $('#country_code').val(code);
            });
        });
    </script>
@endpush

@push('style')
    <style>
        .tab-content {
            display: none;
        }

        .content {
            display: block;
        }
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
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        /* Select2 styling */
        .select2-container--default .select2-selection--single {
            height: 45px;
            border-radius: 4px;
            padding: 8px 12px;
            border: 1px solid #ced4da;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
        }
        
        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 8px;
            border-radius: 4px;
        }
        
        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
    </style>
@endpush

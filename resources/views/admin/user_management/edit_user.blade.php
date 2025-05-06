@extends('admin.layouts.app')
@section('page_title',__('Edit User'))
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('User Management')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Edit User')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Edit @'. $user->username . ' Profile')</h1>
                </div>
                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('admin.user.view.profile', $user->id) }}">
                        <i class="bi-eye-fill me-1"></i> @lang('View Profile')
                    </a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-3">
                <div class="navbar-expand-lg navbar-vertical mb-3 mb-lg-5">
                    <div class="d-grid">
                        <button type="button" class="navbar-toggler btn btn-white mb-3" data-bs-toggle="collapse"
                                data-bs-target="#navbarVerticalNavMenu" aria-label="Toggle navigation"
                                aria-expanded="false" aria-controls="navbarVerticalNavMenu">
                                <span class="d-flex justify-content-between align-items-center">
                                  <span class="text-dark">@lang('Menu')</span>
                                  <span class="navbar-toggler-default">
                                    <i class="bi-list"></i>
                                  </span>
                                  <span class="navbar-toggler-toggled">
                                    <i class="bi-x"></i>
                                </span>
                            </span>
                        </button>
                    </div>

                    <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                        <ul id="navbarSettings"
                            class="js-sticky-block js-scrollspy card card-navbar-nav nav nav-tabs nav-lg nav-vertical"
                            data-hs-sticky-block-options='{
                             "parentSelector": "#navbarVerticalNavMenu",
                             "targetSelector": "#header",
                             "breakpoint": "lg",
                             "startPoint": "#navbarVerticalNavMenu",
                             "endPoint": "#stickyBlockEndPoint",
                             "stickyOffsetTop": 20
                           }'>
                            <li class="nav-item">
                                <a class="nav-link active" href="#content">
                                    <i class="bi-person nav-icon"></i> @lang('Basic information')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#emailSection">
                                    <i class="bi-at nav-icon"></i> @lang('Email')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#usernameSection">
                                    <i class="bi bi-person nav-icon"></i>@lang('Username')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#passwordSection">
                                    <i class="bi-key nav-icon"></i> @lang('Password')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#referralNodeSection">
                                    <i class="bi-diagram-3 nav-icon"></i> @lang('Referral Node')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#preferencesSection">
                                    <i class="bi-gear nav-icon"></i> @lang('Preferences')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#twoStepVerificationSection">
                                    <i class="bi-shield-lock nav-icon"></i> @lang('Two-step verification')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#rgpSection">
                                    <i class="bi-diagram-3 nav-icon"></i> @lang('RGP Management')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#recentDevicesSection">
                                    <i class="bi-phone nav-icon"></i> @lang('Recent devices')
                                </a>
                            </li>
                            <li class="nav-item">
                                @if(adminAccessRoute(config('role.user_management.access.delete')))
                                <a class="nav-link" href="#deleteAccountSection">
                                    <i class="bi-trash nav-icon"></i> @lang('Delete account')
                                </a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-lg-9">
                <div class="d-grid gap-3 gap-lg-5">
                    <form action="{{ route('admin.user.update', $user->id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="profile-cover">
                            <div class="profile-cover-img-wrapper">
                                <img id="profileCoverImg" class="profile-cover-img"
                                     src="{{ asset('assets/admin/img/img1.jpg') }}"
                                     alt="Image Description">
                            </div>
                        </div>

                        <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar"
                               for="editAvatarUploaderModal">
                            <img id="editAvatarImgModal" class="avatar-img"
                                 src="{{ getFile($user->image_driver, $user->image) }}"
                                 alt="Image Description">
                            <input type="file" class="js-file-attach avatar-uploader-input" id="editAvatarUploaderModal"
                                   name="image"
                                   data-hs-file-attach-options='{
                                    "textTarget": "#editAvatarImgModal",
                                    "mode": "image",
                                    "targetAttr": "src",
                                    "allowTypes": [".png", ".jpeg", ".jpg"]
                                 }'>
                            <span class="avatar-uploader-trigger">
                          <i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i>
                        </span>
                        </label>

                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title h4">@lang('Basic information')</h2>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <label for="firstNameLabel"
                                           class="col-sm-3 col-form-label form-label">@lang('Full name')</label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-sm-vertical">
                                            <input type="text" class="form-control" name="firstName" id="firstNameLabel"
                                                   placeholder="First name" aria-label="First name"
                                                   value="{{ old('firstName', $user->firstname) }}" autocomplete="off">
                                            <input type="text" class="form-control" name="lastName" id="lastNameLabel"
                                                   placeholder="Last name" aria-label="Last name"
                                                   value="{{ old('lastName', $user->lastname) }}" autocomplete="off">
                                        </div>
                                        @error('firstName')
                                        <span class="invalid-feedback d-inline">{{ $message }}</span>
                                        @enderror
                                        @error('lastName')
                                        <span class="invalid-feedback d-inline">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <label for="phoneLabel"
                                           class="col-sm-3 col-form-label form-label">@lang('Phone')</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="js-input-mask form-control" name="phone"
                                               id="phoneLabel" placeholder="Phone"
                                               aria-label="Phone" value="{{ old('phone', $user->phone) }}"
                                               autocomplete="off">
                                        @error('phone')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label for="locationLabel"
                                           class="col-sm-3 col-form-label form-label">@lang('Country')</label>
                                    <div class="col-sm-9">
                                        <div class="tom-select-custom mb-4">
                                            <select class="js-select form-select" id="locationLabel" name="country">
                                                @forelse($allCountry as $country)
                                                    <option value="{{ $country['name'] }}"
                                                            {{ $country['name'] == $user->country ? 'selected' : '' }}
                                                            data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="{{ asset($country['flag']) }}" alt="Afghanistan Flag" /><span class="text-truncate">{{ $country['name'] }}</span></span>'>
                                                        @lang($country['name'])
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('country')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="city" id="cityLabel"
                                                       placeholder="City" aria-label="City"
                                                       value="{{ old('city', $user->city) }}" autocomplete="off">
                                                <select class="js-select form-select" name="state" id="stateLabel">
                                                    <option value="" disabled>@lang('Select State')</option>
                                                    <option value="Andhra Pradesh" {{ old('state', $user->state) == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh" {{ old('state', $user->state) == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                                                    <option value="Assam" {{ old('state', $user->state) == 'Assam' ? 'selected' : '' }}>Assam</option>
                                                    <option value="Bihar" {{ old('state', $user->state) == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                                                    <option value="Chhattisgarh" {{ old('state', $user->state) == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                                    <option value="Goa" {{ old('state', $user->state) == 'Goa' ? 'selected' : '' }}>Goa</option>
                                                    <option value="Gujarat" {{ old('state', $user->state) == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                                    <option value="Haryana" {{ old('state', $user->state) == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                                                    <option value="Himachal Pradesh" {{ old('state', $user->state) == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                                                    <option value="Jharkhand" {{ old('state', $user->state) == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                                                    <option value="Karnataka" {{ old('state', $user->state) == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                                    <option value="Kerala" {{ old('state', $user->state) == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                                                    <option value="Madhya Pradesh" {{ old('state', $user->state) == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                                    <option value="Maharashtra" {{ old('state', $user->state) == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                                    <option value="Manipur" {{ old('state', $user->state) == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                                                    <option value="Meghalaya" {{ old('state', $user->state) == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                                                    <option value="Mizoram" {{ old('state', $user->state) == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                                                    <option value="Nagaland" {{ old('state', $user->state) == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                                                    <option value="Odisha" {{ old('state', $user->state) == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                                                    <option value="Punjab" {{ old('state', $user->state) == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                                    <option value="Rajasthan" {{ old('state', $user->state) == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                                    <option value="Sikkim" {{ old('state', $user->state) == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                                                    <option value="Tamil Nadu" {{ old('state', $user->state) == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                                    <option value="Telangana" {{ old('state', $user->state) == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                                    <option value="Tripura" {{ old('state', $user->state) == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                                                    <option value="Uttar Pradesh" {{ old('state', $user->state) == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                                    <option value="Uttarakhand" {{ old('state', $user->state) == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                                                    <option value="West Bengal" {{ old('state', $user->state) == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                                    <option value="Andaman and Nicobar Islands" {{ old('state', $user->state) == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                                                    <option value="Chandigarh" {{ old('state', $user->state) == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                                                    <option value="Dadra and Nagar Haveli and Daman and Diu" {{ old('state', $user->state) == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                                                    <option value="Delhi" {{ old('state', $user->state) == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                                    <option value="Jammu and Kashmir" {{ old('state', $user->state) == 'Jammu and Kashmir' ? 'selected' : '' }}>Jammu and Kashmir</option>
                                                    <option value="Ladakh" {{ old('state', $user->state) == 'Ladakh' ? 'selected' : '' }}>Ladakh</option>
                                                    <option value="Lakshadweep" {{ old('state', $user->state) == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                                                    <option value="Puducherry" {{ old('state', $user->state) == 'Puducherry' ? 'selected' : '' }}>Puducherry</option>
                                                </select>

                                                <input type="text" class="js-input-mask form-control" name="zipCode"
                                                       id="zipCodeLabel" placeholder="Zip code" aria-label="Zip code"
                                                       value="{{ old('zipCode', $user->zip_code) }}" autocomplete="off">
                                            </div>
                                            @error('city')
                                            <span class="invalid-feedback d-inline">{{ $message }}</span>
                                            @enderror
                                            @error('state')
                                            <span class="invalid-feedback d-inline">{{ $message }}</span>
                                            @enderror

                                            @error('zipCode')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label for="addressLine1Label" class="col-sm-3 col-form-label form-label">
                                        @lang('Address line 1')</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="addressOne"
                                               id="addressLine1Label" placeholder="Address One"
                                               aria-label="Your address"
                                               value="{{ old('addressOne', $user->address_one) }}" autocomplete="off">
                                        @error('addressOne')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>


                                <div class="row mb-4">
                                    <label for="addressLine2Label" class="col-sm-3 col-form-label form-label">
                                        @lang('Address line 2')
                                        <span class="form-label-secondary">(@lang("Optional"))</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="addressTwo"
                                               id="addressLine2Label"
                                               placeholder="Your address"
                                               aria-label="Your address"
                                               value="{{ old('addressTwo', $user->address_two) }}" autocomplete="off">
                                        @error('addressTwo')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <label class="row form-check form-switch mb-4" for="userStatusSwitch">
                                    <span class="col-8 col-sm-3 ms-0">
                                      <span class="d-block text-dark">@lang('Status')</span>
                                    </span>
                                    <span class="col-4 col-sm-3">
                                         <input type="hidden" name="status" value="0">
                                      <input type="checkbox" class="form-check-input" name="status"
                                             id="userStatusSwitch" value="1" {{ $user->status == 1 ? 'checked' : '' }}>
                                    </span>
                                </label>
                                @error('status')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                                <div class="d-flex justify-content-start">
                                    <button type="submit" class="btn btn-primary">@lang('Save changes')</button>
                                </div>
                            </div>
                        </div>
                        <!-- End Card -->
                    </form>


                    @include('admin.user_management.components.email_section')
                    @include('admin.user_management.components.username_section')
                    @include('admin.user_management.components.password_section')
                    
                    <!-- Referral Node Section -->
                    <div class="card" id="referralNodeSection">
                        <div class="card-header">
                            <h2 class="card-title h4">@lang('Referral Node')</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.user.update', $user->id) }}" method="post">
                                @csrf
                                <div class="row mb-4">
                                    <label class="col-sm-3 col-form-label form-label">
                                        @lang('Binary Position')
                                        <i class="bi-info-circle text-primary ms-1" data-bs-toggle="tooltip" 
                                           title="@lang('Binary placement position (left or right) in the referral structure')"></i>
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="referral_node" id="leftNodeRadio" 
                                                   value="left" {{ $user->referral_node == 'left' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="leftNodeRadio">
                                                <i class="bi bi-arrow-left-circle me-1"></i> @lang('Left')
                                            </label>
                                            
                                            <input type="radio" class="btn-check" name="referral_node" id="rightNodeRadio" 
                                                   value="right" {{ $user->referral_node == 'right' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="rightNodeRadio">
                                                @lang('Right') <i class="bi bi-arrow-right-circle ms-1"></i>
                                            </label>
                                        </div>
                                        <div class="form-text">
                                            @lang('Select the binary placement position for this user in the referral structure')
                                        </div>
                                        @error('referral_node')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Hidden fields to preserve user data -->
                                <input type="hidden" name="firstName" value="{{ old('firstName', $user->firstname) }}">
                                <input type="hidden" name="lastName" value="{{ old('lastName', $user->lastname) }}">
                                <input type="hidden" name="phone" value="{{ old('phone', $user->phone) }}">
                                <input type="hidden" name="addressOne" value="{{ old('addressOne', $user->address_one) }}">
                                <input type="hidden" name="addressTwo" value="{{ old('addressTwo', $user->address_two) }}">
                                <input type="hidden" name="country" value="{{ old('country', $user->country) }}">
                                <input type="hidden" name="city" value="{{ old('city', $user->city) }}">
                                <input type="hidden" name="state" value="{{ old('state', $user->state) }}">
                                <input type="hidden" name="zipCode" value="{{ old('zipCode', $user->zip_code) }}">
                                <input type="hidden" name="status" value="{{ $user->status }}">
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">@lang('Save changes')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Referral Node Section -->

                    @include('admin.user_management.components.badge_section')
                    @include('admin.user_management.components.preferences_section')

                    @include('admin.user_management.components.two_step_verify_section')

                    @include('admin.user_management.components.rgp_section')

                    @include('admin.user_management.components.recent_devices_section')

                    @if(adminAccessRoute(config('role.user_management.access.delete')))
                        @include('admin.user_management.components.delete_account_section')
                    @endif


                </div>
                <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
    </div>
@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/hs-file-attach.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hs-sticky-block.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hs-scrollspy.min.js') }}"></script>
@endpush


@push('script')
    <script>
        $(document).ready(function () {
            $('.delete-btn').prop('disabled', true);
            $('#deleteAccountCheckbox').on('change', function() {
                let checkboxValue = $(this).prop('checked');
                $('.delete-btn').prop('disabled', !checkboxValue);
            });

            HSCore.components.HSTomSelect.init('.js-select', {
                maxOptions: 250
            })

            new HSFileAttach('.js-file-attach')
            new HSStickyBlock('.js-sticky-block', {
                targetSelector: document.getElementById('header').classList.contains('navbar-fixed') ? '#header' : null
            })
            new bootstrap.ScrollSpy(document.body, {
                target: '#navbarSettings',
                offset: 100
            })
            new HSScrollspy('#navbarVerticalNavMenu', {
                breakpoint: 'lg',
                scrollOffset: -20
            })
        })

    </script>
@endpush






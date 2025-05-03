@extends(template().'layouts.user')
@section('title',trans('Team Members'))

@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true).'css/bootstrap-datepicker.css') }}"/>
@endpush

@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Team Members')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Team Members')</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-20">@lang('Invite Team Members')</h4>
                    <h5 class="mb-3">@lang('Referral Links')</h5>
                    <div class="mb-3">
                        <label class="form-label">@lang('Left Placement')</label>
                        <div class="input-group">
                            <input id="leftReferralURL" type="text" class="form-control"
                                   value="{{route('register.sponsor',[Auth::user()->username, 'left'])}}"
                                   aria-label="Left referral link" aria-describedby="copy-left-btn"
                                   readonly>
                            <div class="input-group-text" id="copyLeftBtn"><i
                                    class="fa-regular fa-copy"></i>@lang('copy')
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">@lang('Right Placement')</label>
                        <div class="input-group">
                            <input id="rightReferralURL" type="text" class="form-control"
                                   value="{{route('register.sponsor',[Auth::user()->username, 'right'])}}"
                                   aria-label="Right referral link" aria-describedby="copy-right-btn"
                                   readonly>
                            <div class="input-group-text" id="copyRightBtn"><i
                                    class="fa-regular fa-copy"></i>@lang('copy')
                            </div>
                        </div>
                    </div>
                    <!-- <div class="mt-3">
                        <label class="form-label">@lang('Default Referral Link')</label>
                        <div class="input-group">
                            <input id="referralURL" type="text" class="form-control"
                                   value="{{route('register.sponsor',[Auth::user()->username])}}"
                                   aria-label="Recipient's username" aria-describedby="basic-addon2"
                                   readonly>
                            <div class="input-group-text" id="copyBtn"><i
                                    class="fa-regular fa-copy"></i>@lang('copy')
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- Cmn table section start -->
        <div class="card">
            <div class="card-header d-flex justify-content-between pb-0 border-0">
                <h4>@lang('Team History')</h4>
            </div>
            <div class="card-body">
                <div class="cmn-table">
                    <div class="table-responsive overflow-hidden">
                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('Level')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Phone Number')</th>
                                <th scope="col">@lang('Placement')</th>
                                <th scope="col">@lang('Joined At')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($directReferralUsers as $user)
                                @php
                                    $countUser = count(getDirectReferralUsers($user->id));
                                @endphp
                                <tr id="user-{{ $user->id }}" data-level="0" data-loaded="false">

                                    <td>
                                        <a href="javascript:void(0)"
                                           class="{{ $countUser > 0 ? 'nextDirectReferral' : '' }} text-decoration-none"
                                           data-id="{{ $user->id }}"
                                        >
                                            @if($countUser > 0)
                                                <i class="far fa-circle-down color-primary"></i>
                                            @endif
                                            @lang($user->username)
                                        </a>
                                    </td>
                                    <td data-label="@lang('Level')">
                                        @lang('Level 1')
                                    </td>
                                    <td data-label="@lang('Email')">
                                        {{$user->email}}
                                    </td>

                                    <td data-label="@lang('Phone Number')">
                                        {{$user->phone}}
                                    </td>
                                    
                                    <td data-label="@lang('Placement')">
                                        @if($user->referral_node)
                                            <span class="badge bg-{{ $user->referral_node == 'left' ? 'primary' : 'success' }}">
                                                @lang(ucfirst($user->referral_node))
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td data-label="@lang('Joined At')">
                                        {{dateTime($user->created_at)}}
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cmn table section end -->

    </div>
@endsection

@push('script')

    <script>
        'use strict'
        $(document).on('click', '.nextDirectReferral', function () {
            let _this = $(this);
            let parentRow = _this.closest('tr');

            // Check if the downline is already loaded
            if (parentRow.data('loaded')) {
                return;
            }

            getDirectReferralUser(_this);
        });

        function getDirectReferralUser(_this) {

            Notiflix.Block.standard('.block-statistics');

            let userId = _this.data('id');
            let parentRow = _this.closest('tr');
            let currentLevel = parseInt(parentRow.data('level')) + 1;
            let downLabel = currentLevel + 1;

            setTimeout(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('user.myGetDirectReferralUser') }}",
                    method: 'POST',
                    data: {
                        userId: userId,
                    },
                    success: function (response) {

                        Notiflix.Block.remove('.block-statistics');
                        let directReferralUsers = response.data;

                        let referralData = '';

                        directReferralUsers.forEach(function (directReferralUser) {
                            referralData += `
                        <tr id="user-${directReferralUser.id}" data-level="${currentLevel}">
                            <td data-label="@lang('Username')" style="padding-left: ${currentLevel * 35}px;">
                                <a class="${directReferralUser.count_direct_referral > 0 ? 'nextDirectReferral' : ''} text-decoration-none" href="javascript:void(0)" style="border-bottom: none !important;" data-id="${directReferralUser.id}">
                                    ${directReferralUser.count_direct_referral > 0 ? ' <i class="far fa-circle-down color-primary"></i>' : ''}
                                    ${directReferralUser.username}
                                </a>
                            </td>

                            <td data-label="@lang('Level')">
                                 <span class="text-dark">Level ${downLabel}</span>
                            </td>

                            <td data-label="@lang('Email')">
                                ${directReferralUser.email ? directReferralUser.email : '-'}
                            </td>
                            <td data-label="@lang('Phone Number')">
                                 ${directReferralUser.phone ?? '-'}
                            </td>
                            
                            <td data-label="@lang('Placement')">
                                ${directReferralUser.referral_node ? 
                                    `<span class="badge bg-${directReferralUser.referral_node === 'left' ? 'primary' : 'success'}">
                                        ${directReferralUser.referral_node.charAt(0).toUpperCase() + directReferralUser.referral_node.slice(1)}
                                    </span>` : '-'}
                            </td>

                            <td data-label="Joined At">
                                ${directReferralUser.joined_at}
                            </td>
                            </tr>`;
                        });

                        // Mark this row as having its downline loaded
                        parentRow.data('loaded', true);

                        $(`#user-${userId}`).after(referralData);
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            }, 100);
        }

    </script>
    <script>
        "use strict";
        document.getElementById("copyBtn").addEventListener("click", () => {
            let referralURL = document.getElementById("referralURL");
            referralURL.select();
            navigator.clipboard.writeText(referralURL.value)
            if (referralURL.value) {
                document.getElementById("copyBtn").innerHTML = '<i class="fa-regular fa-circle-check"></i>' + "{{trans('Copied')}}";
                setTimeout(() => {
                    document.getElementById("copyBtn").innerHTML = '<i class="fa-regular fa-copy"></i>' + "{{trans('copy')}}";
                }, 1000)
            }
        })
        
        document.getElementById("copyLeftBtn").addEventListener("click", () => {
            let leftReferralURL = document.getElementById("leftReferralURL");
            leftReferralURL.select();
            navigator.clipboard.writeText(leftReferralURL.value)
            if (leftReferralURL.value) {
                document.getElementById("copyLeftBtn").innerHTML = '<i class="fa-regular fa-circle-check"></i>'+"{{trans('Copied')}}";
                setTimeout(() => {
                    document.getElementById("copyLeftBtn").innerHTML = '<i class="fa-regular fa-copy"></i>'+"{{trans('copy')}}";
                }, 1000)
            }
        })

        document.getElementById("copyRightBtn").addEventListener("click", () => {
            let rightReferralURL = document.getElementById("rightReferralURL");
            rightReferralURL.select();
            navigator.clipboard.writeText(rightReferralURL.value)
            if (rightReferralURL.value) {
                document.getElementById("copyRightBtn").innerHTML = '<i class="fa-regular fa-circle-check"></i>'+"{{trans('Copied')}}";
                setTimeout(() => {
                    document.getElementById("copyRightBtn").innerHTML = '<i class="fa-regular fa-copy"></i>'+"{{trans('copy')}}";
                }, 1000)
            }
        })
    </script>
@endpush

@push('style')
    <style>
        #jobLink:focus {
            box-shadow: none;
        }

        .color-primary {
            color: var(--primary);
        }

        .text-decoration-none {
            color: var(--fontColor);
        }
    </style>
@endpush


@extends(template().'layouts.user')
@section('title',trans('My Referral'))
@section('content')
    @push('navigator')
        <!-- PAGE-NAVIGATOR -->
        <section id="page-navigator">
            <div class="container-fluid">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"
                                                       class="cursor-inherit">{{trans('My Referral')}}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- /PAGE-NAVIGATOR -->
    @endpush

    <section id="dashboard">
        <div class="dashboard-wrapper add-fund pb-50">
            <div id="feature">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card secbg ">
                            <div class="card-header media justify-content-between">
                                <h5 class="card-title mb-3">@lang('My Referral')</h5>
                            </div>

                            <div class="card-body ">
                                <div class="row mb-50">
                                    <div class="col-xl-12">
                                        <div class="form-group form-block br-4">
                                            <h5 class="mb-15">@lang('Referral Link')</h5>
                                            <div class="input-group mb-50">
                                                <input type="text" value="{{route('register.sponsor',[Auth::user()->username])}}"
                                                       class="form-control form-control-lg bg-transparent" id="sponsorURL"
                                                       readonly>
                                                <div class="input-group-append">
                                            <span class="input-group-text copytext" id="copyBoard"
                                                  onclick="copyFunction()">
                                                <i class="fa fa-copy"></i>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-white">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">@lang('Username')</th>
                                            <th scope="col">@lang('Level')</th>
                                            <th scope="col">@lang('Email')</th>
                                            <th scope="col">@lang('Phone Number')</th>
                                            <th scope="col">@lang('Joined At')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($directReferralUsers as $user)

                                            @php
                                                $countUser = count(getDirectReferralUsers($user->id));
                                            @endphp
                                            <tr id="user-{{ $user->id }}" data-level="0"  data-loaded="false">

                                                <td >
                                                    <a href="javascript:void(0)"
                                                       class="{{ $countUser > 0 ? 'nextDirectReferral' : '' }} text-decoration-none"
                                                       data-id="{{ $user->id }}"
                                                    >
                                                        @if($countUser > 0)
                                                            <i class="fas fa-arrow-circle-down"></i>
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
                                                    {{$user->mobile}}
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
                </div>
            </div>
        </div>
    </section>
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

            Notiflix.Block.standard('.table-responsive');

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

                        Notiflix.Block.remove('.table-responsive');
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
                                 Level ${downLabel}
                            </td>

                            <td data-label="@lang('Email')">
                                ${directReferralUser.email ? directReferralUser.email : '-'}
                            </td>
                            <td data-label="@lang('Phone Number')">
                                 ${directReferralUser.phone??'-'}
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
        function copyFunction() {
            var copyText = document.getElementById("jobLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.success(`Copied: ${copyText.value}`);
        }
    </script>
@endpush
@push('script')

    <script>
        "use strict";
        function copyFunction() {
            var copyText = document.getElementById("sponsorURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.success(`Copied: ${copyText.value}`);
        }
    </script>

@endpush

@push('style')
    <style>
        .table-responsive a i{
            color: var(--themecolor);
        }
        .table-responsive a{
            color: #FFFFFF;
        }
    </style>
@endpush

@extends(template().'layouts.user')
@section('title',trans('My Referral'))

@section('content')

    <section class="transaction-history mt-5 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="header-text-full">
                        <h2>{{trans('My Referral link')}}</h2>
                    </div>
                </div>
            </div>

            <section class="refferal-link">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="box text-white">
                                <h4 class="golden-text">@lang('Referral Link')</h4>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        value="{{route('register.sponsor',[Auth::user()->username])}}"
                                        class="form-control"
                                        id="sponsorURL"
                                        readonly
                                    />
                                    <button class="gold-btn copytext" id="copyBoard" onclick="copyFunction()"><i class="fa fa-copy mx-1"></i>@lang('copy link')</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="table-responsive block-statistics">
                                <table class="table table-striped">
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
            </section>

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
                                 <span class="text-white">Level ${downLabel}</span>
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
        #jobLink:focus{
            box-shadow: none;
        }
        .color-primary{
            color: var(--primary);
        }
        .text-decoration-none{
            color: var(--fontColor);
        }
    </style>
@endpush


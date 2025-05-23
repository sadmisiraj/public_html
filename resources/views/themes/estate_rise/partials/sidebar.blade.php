<!-- Sidebar section start -->
<aside id="sidebar" class="sidebar">
    <div class="logo-container">
        <a href="{{route('page')}}" class="logo d-flex align-items-center">
            <img src="{{logo()}}" alt="Site logo">
        </a>
    </div>

    <ul class="sidebar-nav" id="sidebar-nav">
        @php
            $user = auth()->user();
            $user_rankings = getRanking();
        @endphp
        @if($user->last_lavel != null && $user_rankings)
            <div class="level-box">
                <div>
                    <h4>@lang(@$user_rankings->rank_lavel)</h4>
                    <p class="mb-0">@lang(@$user_rankings->rank_name)</p>
                </div>
                <img src="{{ getFile($user_rankings->driver,$user_rankings->rank_icon) }}" alt="@lang('level image')" class="level-badge">
            </div>
        @endif
        <div class="wallet-box">
            <div class="cmn-list">
                <div class="item">
                    <h6>@lang('Account Balance')</h6> <span class="tag">{{basicControl()->base_currency}}</span>
                </div>
                <div class="item">
                    <p class="mb-0"> @lang('Deposit Balance') </p>
                    <p class="mb-0">{{currencyPosition(auth()->user()->balance+0)}}</p>
                </div>
                <div class="item">
                    <p class="mb-0"> @lang('Performance Balance') </p>
                    <p class="mb-0">{{currencyPosition(auth()->user()->profit_balance+0)}}</p>
                </div>
                <div class="item">
                    <p class="mb-0"> @lang('Profit Balance') </p>
                    <p class="mb-0">{{currencyPosition(auth()->user()->interest_balance+0)}}</p>
                </div>
            </div>
        </div>
        <li class="nav-item">
            <a class="nav-link {{menuActive('user.dashboard')}}" href="{{route('user.dashboard')}}">
                <i class="fa-regular fa-grid"></i>
                <span>@lang('Dashboard')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive('user.plan')}}" href="{{route('user.plan')}}">
                <i class="fal fa-layer-group"></i>
                <span>@lang('Purchase Plan')</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.invest-history'])}}" href="{{route('user.invest-history')}}">
                <i class="fal fa-file-medical-alt"></i>
                <span>@lang('Purchase history')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.addFund', 'user.addFund.confirm'])}}" href="{{route('user.addFund')}}">
                <i class="far fa-funnel-dollar"></i>
                <span>@lang('Deposit Wallet')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.fund.index'])}}" href="{{route('user.fund.index')}}">
                <i class="far fa-search-dollar"></i>
                <span>@lang('Deposit History')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.money-transfer'])}}" href="{{route('user.money-transfer')}}">
                <i class="far fa-money-check-alt"></i>
                <span>@lang('Balance Transfer')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.transaction', 'user.transaction.search'])}}" href="{{route('user.transaction')}}">
                <i class="fa-regular fa-arrow-right-arrow-left"></i>
                <span>@lang('transaction')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.payout'])}}" href="{{route('user.payout')}}">
                <i class="fal fa-hand-holding-usd"></i>
                <span>@lang('payout Request')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.payout.index'])}}" href="{{route('user.payout.index')}}">
                <i class="far fa-badge-dollar"></i>
                <span>@lang('payout history')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.referral'])}}" href="{{route('user.referral')}}">
                <i class="fal fa-retweet-alt"></i>
                <span>@lang('my Team')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.referral.bonus', 'user.referral.bonus.search'])}}" href="{{route('user.referral.bonus')}}">
                <i class="fal fa-box-usd"></i>
                <span> @lang('Team bonus') </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.badges'])}}" href="{{route('user.badges')}}">
                <i class="fal fa-badge"></i>
                <span>@lang('Badges')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.profile'])}}" href="{{route('user.profile')}}">
                <i class="fal fa-user"></i>
                <span>@lang('profile settings')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed {{menuActive(['user.ticket.list', 'user.ticket.create', 'user.ticket.view'])}}" href="{{route('user.ticket.list')}}">
                <i class="fa-regular fa-comment"></i>
                <span>@lang('support ticket')</span>
            </a>
        </li>
        <br>
        <br>
    </ul>
</aside>

<!-- Sidebar section end -->

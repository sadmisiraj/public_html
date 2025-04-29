<div id="sidebar">

    @php
        $user = auth()->user();
        $user_rankings = getRanking();
    @endphp

    <div class="sidebar-top">
        <a class="navbar-brand d-none d-lg-block" href="{{route('page')}}"> <img src="{{logo()}}" alt="@lang('brand logo')" /></a>
        <div class="mobile-user-area d-lg-none">
            <div class="thumb">
                <img class="img-fluid user-img" src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}" alt="...">
            </div>
            <div class="content">
                <h5 class="mt-1 mb-1">{{ __(auth()->user()->fullname) }}</h5>
                <span class="">{{ __(auth()->user()->username) }}</span>
            </div>
        </div>
        <button class="sidebar-toggler d-lg-none" onclick="toggleSideMenu()">
            <i class="fal fa-times"></i>
        </button>
    </div>

    @if($user->last_lavel != null && $user_rankings)
        <div class="level-wrapper">
            <div class="level-box">
                <h4>@lang(@$user_rankings->rank_lavel)</h4>
                <p>@lang(@$user_rankings->rank_name)</p>
                <img src="{{ getFile($user_rankings->driver,$user_rankings->rank_icon) }}" alt="@lang('level image')" class="level-badge" />
            </div>
        </div>
    @endif

    <div class="wallet-wrapper">
        <div class="wallet-box d-none d-lg-block">
            <h4>@lang('Account Balance')</h4>
            <h5> @lang('Main Balance') <span>{{ currencyPosition($user->balance+0) }}</span></h5>
            <h5 class="mb-0"> @lang('Interest Balance') <span> {{ currencyPosition($user->interest_balance+0) }}</span></h5>
            <span class="tag">{{ basicControl()->base_currency }}</span>
        </div>
        <div class="d-flex justify-content-between mt-3">
            <a class="gold-btn btn" href="{{ route('user.addFund') }}"><i class="fa fa-wallet"></i> @lang('Deposit')</a>
            <a class="gold-btn btn" href="{{ route('user.plan') }}"><i class="fa fa-usd"></i> @lang('Invest')</a>
        </div>
    </div>
    <ul class="pb-4">
        <!-- list item -->
        <li class="{{menuActive('user.dashboard')}}">
            <a href="{{route('user.dashboard')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/layout.png')}}" alt="@lang('Dashboard')"/>@lang('Dashboard')
            </a>
        </li>
        <li class="{{menuActive(['user.plan'])}}">
            <a href="{{route('user.plan')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/growth-graph.png')}}" alt="@lang('invest history')"/>@lang('Plan')
            </a>
        </li>


        <li class="{{menuActive(['user.invest-history'])}}">
            <a href="{{route('user.invest-history')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/growth-graph.png')}}" alt="@lang('invest history')"/>@lang('invest history')
            </a>
        </li>

        <li class="{{menuActive(['user.addFund', 'user.addFund.confirm'])}}">
            <a href="{{route('user.addFund')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/money-bag.png')}}" alt="@lang('Add Fund')"/>@lang('Add Fund')
            </a>
        </li>
        <li class="{{menuActive(['user.fund.index'])}}">
            <a href="{{route('user.fund.index')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/fund.png')}}" alt="@lang('Fund History')"/>@lang('Fund History')
            </a>
        </li>
        <li class="{{menuActive(['user.money-transfer'])}}">
            <a href="{{route('user.money-transfer')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/money-transfer.png')}}" alt="@lang('transfer')"/>@lang('transfer')
            </a>
        </li>
        <li class="{{menuActive(['user.transaction', 'user.transaction.search'])}}">
            <a href="{{route('user.transaction')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/transaction.png')}}" alt="@lang('transaction')"/>@lang('transaction')
            </a>
        </li>
        <li class="{{menuActive(['user.payout'])}}">
            <a href="{{route('user.payout')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/payout.png')}}" alt="@lang('payout')"/>@lang('payout')
            </a>
        </li>
        <li class="{{menuActive(['user.payout.index','user.payout.confirm'])}}">
            <a href="{{route('user.payout.index')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/pay-history.png')}}" alt="@lang('payout history')"/>@lang('payout history')
            </a>
        </li>
        <li class="{{menuActive(['user.referral'])}}">
            <a href="{{route('user.referral')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/refferal.png')}}" alt="@lang('my referral')"/>@lang('my referral')
            </a>
        </li>
        <li class="{{menuActive(['user.referral.bonus', 'user.referral.bonus.search'])}}">
            <a href="{{route('user.referral.bonus')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/bonus.png')}}" alt="@lang('referral bonus')"/>@lang('referral bonus')
            </a>
        </li>

        <li class="{{menuActive(['user.badges'])}}">
            <a href="{{route('user.badges')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/refferal.png')}}" alt="@lang('badge icon')"/>@lang('Badges')
            </a>
        </li>

        <li class="{{menuActive(['user.ticket.list', 'user.ticket.create', 'user.ticket.view'])}}">
            <a href="{{route('user.ticket.list')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/support.png')}}" alt="@lang('support ticket')"/>@lang('support ticket')
            </a>
        </li>


        <li class="{{menuActive(['user.profile'])}}">
            <a href="{{route('user.profile')}}" class="sidebar-link">
                <img src="{{asset(template(true).'img/icon/setting.png')}}" alt="@lang('profile settings')"/>@lang('profile settings')
            </a>
        </li>

        <li>
            <a href="{{route('user.twostep.security')}}">
                <img src="{{asset(template(true).'img/icon/padlock.png')}}" alt="2FA Security"> @lang('2FA Security')
            </a>
        </li>


    </ul>
</div>

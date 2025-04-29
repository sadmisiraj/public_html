<div id="sidebar" class="">
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
        <div class="level-box">
            <h4>@lang(@$user->rank->rank_lavel)</h4>
            <p>@lang(@$user->rank->rank_name)</p>
            <img src="{{ getFile($user->rank->driver,$user->rank->rank_icon) }}" alt="" class="level-badge"/>
        </div>
    @endif

    <div class="wallet-wrapper  ">
        <div class="wallet-box d-none d-lg-block">
            <h4>@lang('Account Balance')</h4>
            <h5> @lang('Main Balance') <span>{{ currencyPosition($user->balance) }}</span></h5>
            <h5 class="mb-0"> @lang('Interest Balance')
                <span>{{currencyPosition($user->interest_balance) }}</span></h5>
            <span class="tag">{{ @basicControl()->base_currency }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <a class="btn-custom" href="{{ route('user.addFund') }}"><i class="fal fa-wallet"></i> @lang('Deposit')</a>
            <a class="btn-custom" href="{{ route('user.plan') }}"><i class="fal fa-usd-circle"></i> @lang('Invest')</a>
        </div>
    </div>


    <ul class="main tabScroll">
        <li>
            <a class="{{menuActive('user.dashboard')}}" href="{{route('user.dashboard')}}">
                <i class="fal fa-border-all"></i> @lang('Dashboard')
            </a>
        </li>
        <li>
            <a href="{{route('user.plan')}}" class="sidebar-link {{menuActive(['plan'])}}">
                <i class="fal fa-layer-group"></i> @lang('Plan')
            </a>
        </li>

        <li>
            <a href="{{route('user.invest-history')}}" class="sidebar-link {{menuActive(['user.invest-history'])}}">
                <i class="fal fa-file-medical-alt"></i> @lang('invest history')
            </a>
        </li>

        <li>
            <a href="{{route('user.addFund')}}"
               class="sidebar-link {{menuActive(['user.addFund', 'user.addFund.confirm'])}}">
                <i class="far fa-funnel-dollar"></i> @lang('Add Fund')
            </a>
        </li>
        <li>
            <a href="{{route('user.fund.index')}}"
               class="sidebar-link {{menuActive(['user.fund.index'])}}">
                <i class="far fa-search-dollar"></i> @lang('Fund History')
            </a>
        </li>
        <li>
            <a href="{{route('user.money-transfer')}}" class="sidebar-link {{menuActive(['user.money-transfer'])}}">
                <i class="far fa-money-check-alt"></i> @lang('transfer')
            </a>
        </li>
        <li>
            <a href="{{route('user.transaction')}}"
               class="sidebar-link {{menuActive(['user.transaction', 'user.transaction.search'])}}">
                <i class="far fa-sack-dollar"></i> @lang('transaction')
            </a>
        </li>
        <li>
            <a href="{{route('user.payout')}}"
               class="sidebar-link {{menuActive(['user.payout'])}}">
                <i class="fal fa-hand-holding-usd"></i> @lang('payout')
            </a>
        </li>
        <li>
            <a href="{{route('user.payout.index')}}"
               class="sidebar-link {{menuActive(['user.payout.index'])}}">
                <i class="far fa-badge-dollar"></i> @lang('payout history')
            </a>
        </li>
        <li>
            <a href="{{route('user.referral')}}" class="sidebar-link {{menuActive(['user.referral'])}}">
                <i class="fal fa-retweet-alt"></i> @lang('my referral')
            </a>
        </li>
        <li>
            <a href="{{route('user.referral.bonus')}}"
               class="sidebar-link {{menuActive(['user.referral.bonus', 'user.referral.bonus.search'])}}">
                <i class="fal fa-box-usd"></i>  @lang('referral bonus')
            </a>
        </li>
        <li>
            <a href="{{route('user.badges')}}" class="sidebar-link {{menuActive(['user.badges'])}}">
                <i class="fal fa-badge"></i> @lang('Badges')
            </a>
        </li>
        <li>
            <a href="{{route('user.profile')}}" class="sidebar-link {{menuActive(['user.profile'])}}">
                <i class="fal fa-user"></i> @lang('profile settings')
            </a>
        </li>
        <li>
            <a href="{{route('user.ticket.list')}}"
               class="sidebar-link {{menuActive(['user.ticket.list', 'user.ticket.create', 'user.ticket.view'])}}">
                <i class="fal fa-user-headset"></i> @lang('support ticket')
            </a>
        </li>

        <li class="d-lg-none">
            <a href="{{route('user.twostep.security')}}">
                <i class="fal fa-lock"></i> @lang('2FA Security')
            </a>
        </li>
    </ul>
</div>

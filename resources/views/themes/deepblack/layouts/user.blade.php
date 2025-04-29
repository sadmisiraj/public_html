<!DOCTYPE html>
<html class="no-js" lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif >
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="{{ getFile(basicControl()->favicon_driver??'local', basicControl()->favicon??null) }}" rel="icon">


    <title>@yield('title') | @lang(basicControl()->site_title??"HYIP PRO") </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/fontawesome.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'assets/bootstrap/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'assets/plugins/owlcarousel/animate.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset(template(true).'assets/plugins/owlcarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset(template(true).'assets/plugins/owlcarousel/owl.theme.default.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'assets/plugins/aos/aos.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset(template(true).'assets/plugins/radial-progress/radialprogress.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'assets/jquery/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'scss/flags.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'scss/style.css')}}">
    <script src="{{asset(template(true).'js/modernizr.custom.js')}}"></script>
@stack('css-lib')
@stack('style')

<body @if(session()->get('rtl') == 1) class="rtl" @endif>

<!-- bottom navbar -->
<div class="bottom-nav fixed-bottom d-lg-none">
    <div class="link-item">
        <button onclick="toggleSideMenu()">
            <span class="icon"><i class="fas fa-bars"></i></span>
            <span class="text">@lang('Menus')</span>
        </button>
    </div>
    <div class="link-item">
        <a href="{{ route('user.plan') }}">
            <span class="icon"><i class="fas fa-layer-group" aria-hidden="true"></i></span>
            <span class="text">@lang('Plan')</span>
        </a>
    </div>
    <div class="link-item {{menuActive(['page'])}}">
        <a href="{{ route('page') }}">
            <span class="icon"><i class="fas fa-home"></i></span>
            <span class="text">@lang('Home')</span>
        </a>
    </div>
    <div class="link-item {{menuActive(['user.addFund'])}}">
        <a href="{{ route('user.addFund') }}">
            <span class="icon"><i class="fas fa-funnel-dollar" aria-hidden="true"></i></span>
            <span class="text">@lang('Deposit')</span>
        </a>
    </div>
    <div class="link-item {{menuActive(['user.profile'])}}">
        <a href="{{ route('user.profile') }}">
            <span class="icon"><i class="fas fa-user"></i></span>
            <span class="text">@lang('Profile')</span>
        </a>
    </div>
</div>

<div class="wrapper">
    <!------ sidebar ------->
    @include(template().'partials.sidebar')

    <!------- Nav + Content ---------->
    <div id="content">
        <div class="overlay">
            <!----- navbar ------>
            <nav class="navbar navbar-expand-lg fixed-top">
                <div class="container-fluid">
                    <a class="navbar-brand golden-text" href="{{route('page')}}">
                        <img src="{{logo()}}"
                             alt="{{basicControl()->site_title??"HYIP PRO"}}">
                    </a>

                    <button
                        type="button"
                        id="sidebarCollapse"
                        class="sidebar-toggler p-0 d-none d-lg-block"
                    >
                        <img src="{{asset(template(true).'img/icon/hamburger.png')}}" alt="@lang('hamburger image')"/>
                    </button>

                    <span class="navbar-text" id="pushNotificationArea">
                       <!---- notification panel ---->
                       @include(template().'partials.pushNotify')

                        <!---- user panel ---->
                       <div class="notification-panel user-panel d-none d-lg-block">
                            <button class="dropdown-toggle">
                                <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}"
                                     class="user-image" alt="@lang('user img')"/>
                            </button>
                            <ul class="notification-dropdown user-dropdown">
                                <li>
                                    <a class="dropdown-item" href="{{route('user.dashboard')}}">
                                        <img src="{{asset(template(true).'img/icon/layout.png')}}"
                                             alt="@lang('Dashboard')"/>
                                        <span class="golden-text">{{trans('Dashboard')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                                        <img src="{{asset(template(true).'img/icon/profile.png')}}"
                                             alt="@lang('My Profile')"/>
                                        <span class="golden-text">@lang('My Profile')</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{route('user.twostep.security')}}">
                                        <img src="{{asset(template(true).'/img/icon/padlock.png')}}"
                                             alt="@lang('2FA Security')"/>
                                        <span class="golden-text">@lang('2FA Security')</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <img src="{{asset(template(true).'/img/icon/log-out.png')}}" alt="@lang('Logout')"/>
                                        <span class="golden-text">@lang('Logout')</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                       </div>
                    </span>
                </div>
            </nav>

            <!------------- others main dashboard body content ------------>
            @yield('content')

        </div>
    </div>
</div>


<!-- scroll top icon -->
<a href="#" class="scroll-top">
    <img src="{{asset(template(true).'img/icon/up-arrow2.png')}}" alt="@lang('scroll to top')"/>
</a>

<!-- start preloader -->
<div id="preloader">
    <img src="{{asset(template(true).'img/bitcoin.gif')}}" alt="@lang('preloader')" class="loader"/>
</div>
<!-- end preloader -->

<script src="{{asset(template(true).'assets/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset(template(true).'assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset(template(true).'assets/jquery/jquery-ui.js')}}"></script>
<script src="{{asset(template(true).'assets/plugins/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset(template(true).'assets/plugins/counterup/jquery.waypoints.min.js')}}"></script>
<script src="{{asset(template(true).'assets/plugins/counterup/jquery.counterup.min.js')}}"></script>
<script src="{{asset(template(true).'assets/plugins/aos/aos.js')}}"></script>
<script src="{{asset(template(true).'js/jquery.flagstrap.min.js')}}"></script>
<script src="{{asset(template(true).'assets/fontawesome/fontawesome.min.js')}}"></script>
<!-- custom script -->
<script src="{{asset(template(true).'js/script.js')}}"></script>


<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
@stack('js-lib')

@stack('script')
<script>
    "use strict";
    $(document).on('click', '.investNow', function () {
        var planModal = new bootstrap.Modal(document.getElementById('investModal'));
        planModal.show()
        let data = $(this).data('resource');
        console.log(data);
        let price = $(this).data('price');
        let symbol = "{{basicControl()->currency_symbol}}";
        let currency = "{{basicControl()->base_currency}}";
        $('.price-range').text(`@lang('Invest'): ${price}`);

        if (data.fixed_amount == '0') {
            $('.invest-amount').val('');
            $('#amount').attr('readonly', false);
        } else {
            $('.invest-amount').val(data.fixed_amount);
            $('#amount').attr('readonly', true);
        }

        $('.profit-details').html(`@lang('Interest'): ${(data.profit_type == '1') ? `${data.profit} %` : `${data.profit} ${currency}`}`);
        $('.profit-validity').html(`@lang('Per') ${data.schedule} @lang('hours') ,  ${(data.is_lifetime == '0') ? `${data.repeatable} @lang('times')` : `@lang('Lifetime')`}`);
        $('.plan-name').text(data.name);
        $('.plan-id').val(data.id);
        $('.show-currency').text("{{basicControl()->base_currency}}");
    });
</script>
@include('plugins')


@if (session()->has('success'))
    <script>
        Notiflix.Notify.success("@lang(session('success'))");
    </script>
@endif

@if (session()->has('error'))
    <script>
        Notiflix.Notify.failure("@lang(session('error'))");
    </script>
@endif

@if (session()->has('warning'))
    <script>
        Notiflix.Notify.warning("@lang(session('warning'))");
    </script>
@endif

</body>
</html>







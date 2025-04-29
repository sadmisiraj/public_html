<!DOCTYPE html>
<html class="no-js" lang="en"  @if(session()->get('rtl') == 1) dir="rtl" @endif >
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@lang(basicControl()->site_title??"HYIP PRO") | @if(isset($pageSeo['page_title']))@lang($pageSeo['page_title'])@else
            @yield('title')@endif
    </title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons -->
    <link href="{{ getFile(basicControl()->favicon_driver??'local', basicControl()->favicon??null) }}" rel="icon">

    <meta content="{{ isset($pageSeo['meta_description']) ? $pageSeo['meta_description'] : '' }}" name="description">
    <meta content="{{ is_array(@$pageSeo['meta_keywords']) ? implode(', ', @$pageSeo['meta_keywords']) : @$pageSeo['meta_keywords'] }}"
          name="keywords">
    <meta name="theme-color" content="{{ basicControl()->primary_color }}">
    <meta name="author" content="{{basicControl()->site_title??"HYIP PRO"}}">
    <meta name="robots" content="{{ isset($pageSeo['meta_robots']) ? $pageSeo['meta_robots'] : '' }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ isset(basicControl()->site_title) ? basicControl()->site_title??"HYIP PRO" : '' }}">
    <meta property="og:title" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta property="og:description" content="{{ isset($pageSeo['og_description']) ? $pageSeo['og_description'] : '' }}">
    <meta property="og:image" content="{{ isset($pageSeo['meta_image']) ? $pageSeo['meta_image'] : '' }}">

    <meta name="twitter:card" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta name="twitter:title" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta name="twitter:description" content="{{ isset($pageSeo['meta_description']) ? $pageSeo['meta_description'] : '' }}">
    <meta name="twitter:image" content="{{ isset($pageSeo['meta_image']) ? $pageSeo['meta_image'] : '' }}">

    <!-- css files-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/fontawesome.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'assets/bootstrap/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'assets/plugins/owlcarousel/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'assets/plugins/owlcarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'assets/plugins/owlcarousel/owl.theme.default.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'assets/plugins/aos/aos.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'assets/plugins/radial-progress/radialprogress.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'scss/flag-icon.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'scss/style.css')}}">
    <script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
    <script src="{{asset(template(true).'js/modernizr.custom.js')}}"></script>

    @stack('css-lib')
    @stack('style')

</head>
<body>

<header id="header-section">
    <div class="overlay">
        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid ">
                <a class="navbar-brand golden-text" href="{{url('/')}}">
                    <img src="{{logo()}}"
                         alt="{{basicControl()->site_title??"HYIP PRO"}}">
                </a>
                <button class="navbar-toggler p-0 " type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <img src="{{asset(template(true).'img/icon/hamburger.png')}}" alt="@lang('hamburger image')" />
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        {!! renderHeaderMenu(getHeaderMenuData()) !!}
                    </ul>
                </div>
                <span class="navbar-text" id="pushNotificationArea">
                    @auth
                        <!-- notification panel -->
                        @include(template().'partials.pushNotify')
                    @endauth

                    <!-- user panel -->
                    <div class="notification-panel user-panel">
                        <button class="dropdown-toggle">
                            @guest()
                                <img src="{{asset(template(true).'img/icon/profile.png')}}" class="user-image" alt="@lang('profile')" />
                            @else
                                <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}" class="user-image" alt="@lang('user img')" />
                            @endguest
                        </button>
                        @guest
                            <ul class="notification-dropdown user-dropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        <img src="{{asset(template(true).'img/icon/profile.png')}}" alt="@lang('Login')" />
                                        <span class="golden-text">@lang('Login')</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('register') }}">
                                        <img src="{{asset(template(true).'img/icon/profile.png')}}" alt="@lang('Register')" />
                                        <span class="golden-text">@lang('Register')</span>
                                    </a>
                                </li>
                            </ul>
                        @else
                            <ul class="notification-dropdown user-dropdown">
                                <li>
                                    <a class="dropdown-item" href="{{route('user.dashboard')}}">
                                        <img src="{{asset(template(true).'img/icon/layout.png')}}" alt="@lang('Dashboard')"/>
                                        <span class="golden-text">{{trans('Dashboard')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                                        <img src="{{asset(template(true).'img/icon/profile.png')}}" alt="@lang('My Profile')"/>
                                        <span class="golden-text">@lang('My Profile')</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{route('user.twostep.security')}}">
                                        <img src="{{asset(template(true).'/img/icon/padlock.png')}}" alt="@lang('2FA Security')"/>
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
                        @endguest
                    </div>
                </span>
            </div>
        </nav>
        <!--/ NAVBAR -->
    </div>
</header>


@include(template().'partials.banner')

@yield('content')

@include(template().'partials.footer')

<!-- scroll top icon -->
<a href="#" class="scroll-top">
    <img src="{{asset(template(true).'img/icon/up-arrow2.png')}}" alt="@lang('scroll to top')" />
</a>

<!-- start preloader -->
<div id="preloader">
    <img src="{{asset(template(true).'img/bitcoin.gif')}}" alt="@lang('preloader')" class="loader" />
</div>
<!-- end preloader -->
<script src="{{asset(template(true).'assets/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset(template(true).'assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset(template(true).'assets/plugins/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset(template(true).'assets/plugins/counterup/jquery.waypoints.min.js')}}"></script>
<script src="{{asset(template(true).'assets/plugins/counterup/jquery.counterup.min.js')}}"></script>
<script src="{{asset(template(true).'assets/plugins/aos/aos.js')}}"></script>
<script src="{{asset(template(true).'assets/fontawesome/fontawesome.min.js')}}"></script>
<script src="{{asset('assets/admin/js/fontawesomepro.min.js')}}"></script>
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
        var planModal = new bootstrap.Modal(document.getElementById('investNowModal'));
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

<script>
    'use strict'

    document.addEventListener('DOMContentLoaded', function() {
        AOS.init();
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



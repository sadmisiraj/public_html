<!DOCTYPE html>
<html class="no-js" lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif >
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@lang(basicControl()->site_title??"HYIP PRO") | @if(isset($pageSeo['page_title']))@lang($pageSeo['page_title'])@else
            @yield('title')@endif
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons -->
    <link href="{{ getFile(basicControl()->favicon_driver??'local', basicControl()->favicon??null) }}" rel="icon">

    <!-- css files-->
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
    <meta property="og:image" content="{{ getFile(@$pageSeo['meta_image_driver'], @$pageSeo['meta_image']) }}">

    <meta name="twitter:card" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta name="twitter:title" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta name="twitter:description" content="{{ isset($pageSeo['meta_description']) ? $pageSeo['meta_description'] : '' }}">
    <meta name="twitter:image" content="{{ isset($pageSeo['meta_image']) ? $pageSeo['meta_image'] : '' }}">

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Open+Sans&family=Ubuntu:wght@300;400;500;700&display=swap">

    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/jquery-ui.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/all.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/icofont.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/animate.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/flags.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/slick.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/slick-theme.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/owl.theme.default.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/radialprogress.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset(template(true).'css/color.php')}}?primaryColor={{str_replace('#','',primaryColor())}}">
    <script src="{{asset(template(true).'js/modernizr.custom.js')}}"></script>
    <script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/css/intlTelInput.css">
    <style>
        @media  only screen and (max-width: 423px) {
            .xs-dropdown-menu {
                transform: translateX(-20px) !important;
            }

        }
        #hero {
            position: relative;
            padding: 170px 0;
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
            background-color: #ffffff;
        }
        .captcha{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #a1a1a1;
            border-radius: 4px;
            margin-top: 0;
            height: 51px;
        }

        .captcha img{
            width: 120px;
            padding: 10px;
            margin-top: -10px;
        }

        .captcha .input-group-append{
            width: 55px;
            height: 59px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: transparent;
            color: #ffff;
            border: none;
        }

        .captcha .input-group-append i{
            position: absolute;
            top: 15px;
            right: 21px;
        }
        .manual-recaptcha-icon {
            background: #000;
            border: #000;
            color: #fff;
        }
        .manual-recaptcha-icon:hover{
            color: #FFFFFF;
        }

        #telephone{
            width: 100%;
            border: none;
            border-radius: 5px;
        }

        #telephone:focus{
            border: 1px solid var(--themecolor);
        }

        .iti--show-flags{
            width: 100%;
        }
        #telephone{
            width: 100% !important;
            height: 58px;
            border-radius: 8px;
            background-color: transparent;
            padding: 15px;
            font-weight: normal;
            font-size: 14px;
            caret-color: #FFFFFF;
            color: var(--fontColor);
            border: 1px solid #a1a1a1
        }

        .iti--inline-dropdown .iti__dropdown-content{
            width: 300px !important;
        }
        .mt_120{
            margin-top: 120px;
        }
        .terms_condition {
            padding-bottom: 100px;
        }
        .privacy_policy_text {
            border-radius: 12px;
            border: 1px solid rgba(8, 5, 33, 0.12);
            -webkit-border-radius: 12px;
            -moz-border-radius: 12px;
            -ms-border-radius: 12px;
            -o-border-radius: 12px;
            padding: 10px 50px 50px 50px;
        }

        .privacy_policy_text p,
        .privacy_policy_text span,
        .privacy_policy_text h4,
        .privacy_policy_text li{
            color: #222222!important;
        }
        .privacy_policy_text h4 {
            font-size: 20px;
        }

        .privacy_policy_text h1, .privacy_policy_text h2, .privacy_policy_text h3, .privacy_policy_text h4, .privacy_policy_text h5, .privacy_policy_text h6 {
            font-weight: 450;
            letter-spacing: -0.8px;
            text-transform: uppercase;
            margin-top: 35px!important;
        }

        .privacy_policy_text p {
            line-height: 24px;
            margin-top: 25px;
        }

        .cookies-allert {
            display: none;
            position: fixed;
            left: 15px;
            bottom: 50px;
            padding: 2rem;
            max-width: 360px;
            cursor: pointer;
            border-radius: 24px;
            box-shadow: inset 0 0 0 2px rgba(0, 0, 0, 0.2);
            z-index: 10000;
            background: #ffffff;
            text-align: center;
        }

        .cookies-allert img {
            width: 20% !important;
            display: block;
            margin: auto;
        }
        .cookies-allert h4,
        .cookies-allert span{
            color: #000000;
        }

        .cookieButton {
            display: flex;
            height: 55px;
            line-height: 55px;
            color: #000000;
            font-size: 17px;
            padding: 0 2rem;
            align-items: center;
            background: var(--themecolor);
            width: auto;
            border-radius: 24px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
            justify-content: center;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease-in-out;
            white-space: nowrap;
        }
        .cookieButton:hover{
            color: #fff;
        }

        .cookieClose {
            color: #2d2d2d;
            text-decoration: none;
            transition: all 0.01s ease-in-out;
            border-bottom: 1px solid rgba(45, 45, 45, 0.3);
        }

        .cookieClose:hover {
            border-bottom: 3px solid rgba(3, 3, 3, 0.3);
        }

        .cookies-allert .seemoreButton {
            text-decoration: underline;
            display: inline-block;
            font-size: 14px;
            color: var(--themecolor);
        }




    </style>

    @stack('css-lib')
    @stack('style')

</head>
<body @if(session()->get('rtl') == 1) class="rtl" @endif>

@guest
    @include(template().'partials.topbar')
@else
    @include(template().'partials.topbar-auth')
@endguest

@guest
    <nav id="navbar">
        <div class="container">
            <div class="navbar navbar-expand-md flex-wrap">
                <a class="navbar-brand" href="{{url('/')}}">
                    <img src="{{logo()}}"
                         alt="{{basicControl()->site_title??"HYIP PRO"}}">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#investmentnavbar">
					<span class="menu-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
                </button>

                <div class="collapse navbar-collapse" id="investmentnavbar">
                    <ul class="navbar-nav">
                        {!! renderHeaderMenu(getHeaderMenuData()) !!}
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user.dashboard')}}">@lang('Dashboard')</a>
                            </li>
                        @endauth
                    </ul>
                    <ul class="navbar-nav nav-registration  d-none d-md-block">
                        @guest
                            <li class="nav-item login-signup"><a
                                    href="javascript:void(0)"><span>@lang('Login')</span></a>
                            </li>
                        @endguest

                        @auth
                            <li class="nav-item">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span>@lang('Logout')</span></a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
@endguest

@auth

    <!-- NAVBAR | NAVBAR-LOGGEDIN -->
    <nav id="navbar" class="navbar-loggedin">
        <div class="container">
            <div class="navbar navbar-expand-md flex-wrap" id="pushNotificationArea">
                <div class="d-flex">

                    <a class="navbar-brand" href="{{route('page')}}">
                        <img src="{{logo()}}" alt="homepage">
                    </a>
                </div>

                <div class="account d-flex d-md-none">
                    <div class="d-flex">
                        <div class="dropdown account-dropdown responsive-menus">
                            <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">
                                <i class="icofont-home"></i>
                            </a>
                            <div class="xs-dropdown-menu xs-dropdown-menu1 dropdown-menu dropdown-right">
                                <div class="dropdown-content">
                                    {!! renderDropdownMenu(getHeaderMenuData()) !!}

                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="d-flex ml-20">
                        @include(template().'partials.pushNotify')
                        @include(template().'partials.profile-menus')
                    </ul>
                </div>

                <div class="collapse navbar-collapse justify-content-end justify-content-md-between"
                     id="investmentnavbar">
                    <ul class="navbar-nav d-none d-md-flex">
                        {!! renderHeaderMenu(getHeaderMenuData()) !!}
                    </ul>
                    <div class="account">
                        <ul class="d-flex">
                            @include(template().'partials.pushNotify')
                            @include(template().'partials.profile-menu')
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- /NAVBAR -->
@endauth


@include(template().'partials.banner')

@yield('content')


@include(template().'partials.footer')


@include(template().'partials.modal-form')
<!-- bootstrap -->
<script src="{{asset(template(true).'js/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset(template(true).'js/fontawesome.min.js')}}"></script>
<script src="{{asset(template(true).'js/wow.min.js')}}"></script>
<script src="{{asset(template(true).'js/jquery.flagstrap.min.js')}}"></script>
<script src="{{asset(template(true).'js/slick.min.js')}}"></script>
<script src="{{asset(template(true).'js/owl.carousel.min.js')}}"></script>
<script src="{{asset(template(true).'js/multi-animated-counter.js')}}"></script>
<script src="{{asset(template(true).'js/radialprogress.js')}}"></script>
<script src="{{asset(template(true).'js/script.js')}}"></script>

<script src="{{asset('assets/global/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/global/js/popper.min.js')}}"></script>
<script src="{{asset('assets/global/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/intlTelInput.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@stack('js-lib')
@stack('script')

<script>
    "use strict";
    (function ($) {
        $(document).on('click', '.investNow', function () {
            $("#investment-modal").toggleClass("modal-open");
            let data = $(this).data('resource');
            let price = $(this).data('price');
            let symbol = "{{trans(basicControl()->currency_symbol)}}";
            let currency = "{{trans(basicControl()->base_currency)}}";
            $('.price-range').text(`@lang('Invest'): ${price}`);

            if (data.fixed_amount == '0') {
                $('.invest-amount').val('');
                $('#amount').attr('readonly', false);
            } else {
                $('.invest-amount').val(data.fixed_amount);
                $('#amount').attr('readonly', true);
            }

            $('.profit-details').html(`<strong> @lang('Interest'): ${(data.profit_type == '1') ? `${data.profit} %` : `${data.profit} ${currency}`}  </strong>`);
            $('.profit-validity').html(`<strong>  @lang('Per') ${data.schedule} @lang('hours') ,  ${(data.is_lifetime == '0') ? `${data.repeatable} @lang('times')` : `@lang('Lifetime')`} </strong>`);
            $('.plan-name').text(data.name);
            $('.plan-id').val(data.id);
        });



        $(".btn-close-investment").on('click',function(){
            $("#investment-modal").removeClass("modal-open");
        });


        $("#investment-modal .modal-wrapper").on('click', function(e) {
            e.preventDefault();
            $("#modal-login").removeClass("modal-open");
        });


    })(jQuery);
</script>

<script>

    function refreshCaptcha() {
        let img = document.images['captcha_image'];
        img.src = img.src.substring(
            0, img.src.lastIndexOf("?")
        ) + "?rand=" + Math.random() * 1000;
    }

    function refreshCaptcha1() {

        let img = document.images['captcha_image1'];
        img.src = img.src.substring(
            0, img.src.lastIndexOf("?")
        ) + "?rand=" + Math.random() * 1000;
    }

    function refreshCaptcha2() {
        let img = document.images['captcha_image2'];
        img.src = img.src.substring(
            0, img.src.lastIndexOf("?")
        ) + "?rand=" + Math.random() * 1000;
    }

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
<script>
    $(document).ready(function () {
        $(".language").find("select").change(function () {
            let value = $(this).val().toLowerCase();
            if(value === 'US'){
                value = 'en';
            }
            window.location.href = "{{route('language')}}/" + $(this).val()
        })
    })

</script>
</body>
</html>



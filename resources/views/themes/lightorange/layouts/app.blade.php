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
    <meta property="og:image" content="{{ isset($pageSeo['meta_image']) ? $pageSeo['meta_image'] : '' }}">

    <meta name="twitter:card" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta name="twitter:title" content="{{ isset($pageSeo['meta_title']) ? $pageSeo['meta_title'] : '' }}">
    <meta name="twitter:description" content="{{ isset($pageSeo['meta_description']) ? $pageSeo['meta_description'] : '' }}">
    <meta name="twitter:image" content="{{ isset($pageSeo['meta_image']) ? $pageSeo['meta_image'] : '' }}">

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap">


    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/jquery-ui.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/magnific-popup.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/flags.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/icofont.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/style.css')}}">
    <script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
    <script src="{{asset(template(true).'js/modernizr.custom.js')}}"></script>

    <style>
        @media only screen and (max-width: 423px) {
            .xs-dropdown-menu {
                transform: translateX(-20px) !important;
            }

        }
    </style>

    @stack('css-lib')
    @stack('style')

</head>
<body>
<!-- start preloader -->
<div class="preloader" id="preloader">
    <div class="preloader-thumb">
        <img src="{{asset('assets/themes/lightorange/images/preloader.gif')}}" alt="@lang('preloader')">
    </div>
</div>
<!-- end preloader -->

<a href="#" class="scrollToTop"><i class="icofont-simple-up"></i></a>

<header id="header-section">
    <div class="overlay">

        <!-- TOPBAR -->
        @include(template().'partials.topbar')
        <!-- /TOPBAR -->

        <!-- NAVBAR -->
        <nav id="navbar" class="navbar navbar-expand-lg navbar-light header-bottom sticky nav-lightorange">
            <div class="container ">

                <div class="nav-area">
                    <div class="logo-section">
                        <a class="site-logo site-title" href="{{route('page')}}">
                            <img src="{{logo()}}"
                                 alt="{{basicControl()->site_title??"HYIP PRO"}}">
                        </a>
                    </div>
                    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <i class="icofont-navigation-menu"></i>
                    </button>

                    <div class="collapse navbar-collapse nav-main justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav main-menu ml-auto">
                            {!! renderHeaderMenu(getHeaderMenuData()) !!}
                        </ul>
                    </div>

                    @guest
                        <div class="right-btn">
                            <a class="cmn-btn" href="{{ route('register') }}">{{trans('join now')}}</a>
                        </div>
                    @else
                        <div class="right-btn">
                            <a class="cmn-btn" href="{{route('user.dashboard')}}">{{trans('Dashboard')}}</a>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>
        <!--/ NAVBAR -->
    </div>
</header>


@include(template().'partials.banner')

@yield('content')

@include(template().'partials.footer')


<script src="{{asset(template(true).'js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset(template(true).'js/jquery.magnific-popup.js')}}"></script>
<script src="{{asset(template(true).'js/slick.js')}}"></script>
<script src="{{asset(template(true).'js/wow.js')}}"></script>
<script src="{{asset(template(true).'js/jquery.flagstrap.min.js')}}"></script>
<script src="{{asset(template(true).'js/script.js')}}"></script>

<script src="{{asset('assets/global/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/global/js/popper.min.js')}}"></script>
<script src="{{asset('assets/global/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>

@stack('js-lib')
@stack('script')

@if(basicControl()->theme == 'lightorange')
    <script>
        "use strict";
        (function ($) {
            $(document).on('click', '.investNow', function () {
                $("#investNowModal").toggleClass("modal-open");
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
                $("#investNowModal").removeClass("modal-open");
            });

        })(jQuery);


    </script>
@else
    <script>
        "use strict";
        (function ($) {
            $(document).on('click', '.investNow', function () {
                $("#modal-login").toggleClass("modal-open");
                let data = $(this).data('resource');
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

                $('.profit-details').html(`<strong> @lang('Interest'): ${(data.profit_type == '1') ? `${data.profit} %` : `${data.profit} ${currency}`}  </strong>`);
                $('.profit-validity').html(`<strong>  @lang('Per') ${data.schedule} @lang('hours') ,  ${(data.is_lifetime == '0') ? `${data.repeatable} @lang('times')` : `@lang('Lifetime')`} </strong>`);
                $('.plan-name').text(data.name);
                $('.plan-id').val(data.id);
            });
        })(jQuery);


    </script>
@endif

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
    var root = document.querySelector(':root');
    root.style.setProperty('--main-color', '{{primaryColor()??'#ff5400'}}');
</script>
</body>
</html>



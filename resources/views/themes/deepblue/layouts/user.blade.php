<!DOCTYPE html>
<html class="no-js" lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif >
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="{{ getFile(basicControl()->favicon_driver??'local', basicControl()->favicon??null) }}" rel="icon">


    <title>@yield('title') | @lang(basicControl()->site_title??"HYIP PRO") </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- bootstrap 5 -->
    <link rel="stylesheet" href="{{asset(template(true).'css/bootstrap.min.css')}}">
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
    <script src="{{asset(template(true).'js/perfect-scrollbar.js')}}"></script>
    <link rel="stylesheet" href="{{asset(template(true).'css/color.php')}}?primaryColor={{str_replace('#','',primaryColor())}}">
    <script src="{{asset(template(true).'js/modernizr.custom.js')}}"></script>

<style>

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
    .cookies-allert h4,
    .cookies-allert span{
        color: #222222;
    }

    .cookies-allert img {
        width: 20% !important;
        display: block;
        margin: auto;
    }

    .cookieButton {
        display: flex;
        height: 55px;
        line-height: 55px;
        color: #fff;
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
    .alert{
        padding: 15px 20px;
        border-left: 2px solid var(--themecolor);
    }

    .dataTables-image {
        width: 10rem;
    }
    #no-data-image {
        margin: 40px 0 2rem 0;
        width: 10rem;
    }
    .checkout-section .side-bar .side-box .form-control,
    #paymentModalBody .form-control
    {
        height: 45px;
        background-color: var(--white);
        border: 1px solid var(--white) !important;
        padding: 10px;
        padding-left: 15px;
        font-weight: normal;
        caret-color: var(--themecolor);
        color: var(--textcolor);
    }
    .checkout-section .side-bar .side-box .select2-container--default .select2-selection--single {
        height: 45px;
        background-color: var(--white);
        border: 1px solid var(--white);
    }

    .checkout-section .side-bar .side-box .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 45px;
        padding-left: 10px;
        padding-right: 10px;
    }


    .checkout-section .side-bar .side-box .input-group .form-control:focus {
        color: var(--textcolor);
        box-shadow: 0 0 0 0rem var(--white);
        border: 1px solid var(--themecolor);
    }

    .checkout-section .side-bar .side-box .input-group .form-control::-moz-placeholder {
        color: var(--textcolor);
    }

    .checkout-section .side-bar .side-box .input-group .form-control::placeholder {
        color: var(--textcolor);
    }

    .rtl .checkout-section .side-bar .side-box ul li span {
        float: left;
    }

    .checkout-section .side-bar .side-box {
        background: transparent;
        box-shadow: 0 0.375rem 0.75rem rgba(140, 152, 164, .075);
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid var(--bordercolor);
        margin-top: 48px!important;
    }

    .checkout-section .side-bar .side-box h4 {
        text-transform: capitalize;
        margin-bottom: 15px;
        position: relative;
    }
    .payment-container-list{
        height: 500px;
        overflow: auto;
    }
    .payment-container-list .form-check-label .image-area img {
        width: 50px;
        height: 50px;
        min-width: 50px;
        min-height: 50px;
        border-radius: 50%;
    }
    .checkout-section .card{
        background: transparent;
        border-radius: 10px;
        box-shadow: 0 0.375rem 0.75rem rgba(140, 152, 164, .075);

        border: 1px solid var(--bordercolor);
    }
    .checkout-section .item{
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        margin-right: 5px;
    }

    .checkout-section{
        margin-top: 55px;
    }
    .payment-container-list .form-check-input {
        position: absolute;
        right: 15px;
    }
    .checkout-section h5{
        font-size: 20px;
        margin-bottom: 5px!important;
        font-weight: 600;
    }

    .checkout-section .item label{
        display: flex;
        align-items: center;
        width: 100%;
        height: 100%;
        padding: 15px;
        cursor: pointer;
        box-shadow: 0 0.375rem 0.75rem rgba(140, 152, 164, .075);
        border-radius: 5px;
        transition: 0.5s;
        gap: 15px;
        border: 1px solid var(--bordercolor);
    }
    .checkout-section .form-check-input:checked {
        background-color: var(--themecolor)!important;
        border-color: var(--themecolor)!important;
    }

    .checkout-section .content-area {
        padding-right: 15px;
    }
    .checkout-section .content-area span {
        font-size: 14px;
    }

    .side-box select,input  {
        background: transparent!important;
    }

    .side-box select option{
        background: var(--background-1)!important;
        color: #FFFFFF!important;
    }

    .list-group-item {
        background-color: transparent!important;
        border: none;
    }

    /* width */
    .payment-container-list::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    .payment-container-list::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    /* Handle */
    .payment-container-list::-webkit-scrollbar-thumb {
        background: var(--bordercolor);
        border-radius: 2px;
    }



</style>

@stack('css-lib')
@stack('style')
<body>

<!-- DASHBOARD-PAGE-LAYOUT -->
<div id="dashboard-page-layout" class="theme-dark">
    <!-- DASHBOARD-HEADER -->
    <header id="dashboard-header">
        @include(template().'partials.topbar-auth')

        <!-- NAVBAR | NAVBAR-LOGGEDIN -->
        <nav id="navbar" class="navbar-loggedin">
            <div class="container-fluid">
                <div class="navbar navbar-expand-md flex-wrap" id="pushNotificationArea">
                    <div class="d-flex">
                        <button class="sidenavbar-toggler mr-15 d-lg-none" type="button">
                            <div class="menu-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </button>
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
                            @include(template().'partials.profile-menu')
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


        <!-- SIDENAVBAR -->
        <div id="sidenavbar">
            <div class="sidenav-header">
                <p class="sidenav-close">&times;</p>
            </div>
            <div class="sidenavbar-wrapper">
                <div class="dashboard-nav">
                    @include(template().'partials.sidebar')
                </div>
            </div>
        </div>
        <!-- /SIDENAVBAR -->

        @stack('navigator')
    </header>
    <!-- DASHBOARD-HEADER -->

    <main id="page-container">


        <aside id="sidebar">
            <div class="dashboard-nav wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.35s">
                @include(template().'partials.sidebar')
            </div>
        </aside>


        @yield('content')
    </main>
</div>
<!-- /DASHBOARD-PAGE-LAYOUT -->

<script src="{{asset(template(true).'js/jquery-3.5.1.min.js')}}"></script>

<script src="{{asset('assets/global/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/global/js/popper.min.js')}}"></script>
<script src="{{asset('assets/global/js/bootstrap.min.js')}}"></script>


<script src="{{asset(template(true).'js/fontawesome.min.js')}}"></script>
<script src="{{asset(template(true).'js/wow.min.js')}}"></script>
<script src="{{asset(template(true).'js/jquery.flagstrap.min.js')}}"></script>
<script src="{{asset(template(true).'js/slick.min.js')}}"></script>
<script src="{{asset(template(true).'js/owl.carousel.min.js')}}"></script>
<script src="{{asset(template(true).'js/multi-animated-counter.js')}}"></script>
<script src="{{asset(template(true).'js/script.js')}}"></script>


<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
@stack('js-lib')

@stack('script')

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







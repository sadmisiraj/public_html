<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | @lang(basicControl()->site_title??"HYIP PRO") </title>
    <!-- Favicon-link -->
    <link href="{{ getFile(basicControl()->favicon_driver??'local', basicControl()->favicon??null) }}" rel="icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fontawesome-6 Js link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset(template(true).'css/fontawesome.min.css')}}">
    <!-- Bootstrap 5 Css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/bootstrap.min.css')}}">
    <!-- Owl carousel Css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset(template(true).'css/owl.theme.default.min.css')}}">
    <!-- Swiper Css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/swiper-bundle.min.css')}}">
    <!-- select2 Css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/select2.min.css')}}">
    <!-- Jquery UI Css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/jquery-ui.theme.min.css')}}">
    <link rel="stylesheet" href="{{asset(template(true).'css/jquery-ui.structure.min.css')}}">
    <!-- Line progressbar Css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/jquery.lineProgressbar.css')}}">
    <!-- Style Css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/dashboard.css')}}">
    <!-- Custom RGP Css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/custom-rgp.css')}}">
    @stack('css-lib')
    @stack('style')

</head>
<body onload="preloaderFunction()" class="">
    <div class="dashboard-wrapper">
        <!-- Preloader section start -->
        <div id="preloader">
            <img src="{{asset(template(true).'img/preloader/camera.gif')}}" alt="">
        </div>
        <!-- Preloader section end -->

        <!-- Header section start -->
        @include(template().'partials.user_header')
        <!-- Header section end -->

        <!-- Bottom Mobile Tab nav section start -->
        <ul class="nav bottom-nav fixed-bottom d-xl-none">
            <li class="nav-item">
                <a class="nav-link  toggle-sidebar-btn" aria-current="page">
                    <i class="fa-regular fa-list"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('user.plan')}}"><i class="fa-regular fa-planet-ringed"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{route('user.dashboard')}}"><i class="fa-regular fa-house"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('user.profile')}}"><i class="fa-regular fa-user"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa-regular fa-sign-out"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
        <!-- Bottom Mobile Tab nav section end -->

        <!-- Sidebar section start -->
        @include(template().'partials.sidebar')
        <!-- Sidebar section end -->

        <main id="main" class="main bg-color2">
            @yield('content')
        </main>
    </div>


<!-- Jquery Js link -->
<!-- <script src="assets/js/jquery-3.6.1.min.js"></script> -->
<script src="{{asset(template(true).'js/jquery-3.7.1.min.js')}}"></script>
<!-- Bootstrap Js link -->
<script src="{{asset(template(true).'js/bootstrap.bundle.min.js')}}"></script>
<!-- select2_Js_link -->
<script src="{{asset(template(true).'js/select2.min.js')}}"></script>
<!-- Owl carousel Js link -->
<script src="{{asset(template(true).'js/owl.carousel.min.js')}}"></script>
<!-- Jquery UI Js link -->
<script src="{{asset(template(true).'js/jquery-ui.min.js')}}"></script>
<!-- Jquery Apexcharts Js link -->
<script src="{{asset(template(true).'js/apexcharts.min.js')}}"></script>
<!-- Jquery Apexcharts Js link -->
<script src="{{asset(template(true).'js/circle-progress.min.js')}}"></script>
<!-- Line progressbar Js link -->
<script src="{{asset(template(true).'js/jquery.lineProgressbar.js')}}"></script>
<!-- Main Js slink -->
<script src="{{asset(template(true).'js/dashboard.js')}}"></script>

<!-- Global Js slink -->
<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>

@stack('js-lib')
@stack('script')

    <script>
        var root = document.querySelector(':root');
        root.style.setProperty('--primary-color', '{{hex2rgba(primaryColor(),false,true)??'#ffb300'}}');
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

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

    <!-- font awesome 6 -->
    <link rel="stylesheet" href="{{asset(template(true).'css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset(template(true).'css/fontawesome.min.css')}}">
    <!-- aos animation -->
    <link rel="stylesheet" href="{{asset(template(true).'css/aos.css')}}">
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{asset(template(true).'css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset(template(true).'css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/radialprogress.css')}}">
    <!-- select 2 -->
    <link rel="stylesheet" href="{{asset(template(true).'css/select2.min.css')}}">
    <!-- fancybox -->
    <link rel="stylesheet" href="{{asset(template(true).'css/fancybox.css')}}">
    <!-- custom css -->
    <link rel="stylesheet" href="{{asset(template(true).'css/dashboard.css')}}">
    <script src="{{asset(template(true).'js/modernizr.custom.js')}}"></script>
@stack('css-lib')
@stack('style')

<body @if(session()->get('rtl') == 1) class="rtl" @endif>

<div class="bottom-nav fixed-bottom d-lg-none">
    <div class="link-item">
        <button onclick="toggleSideMenu()">
            <span class="icon"><i class="fal fa-ellipsis-v-alt"></i></span>
            <span class="text">@lang('Menus')</span>
        </button>
    </div>
    <div class="link-item">
        <a href="{{ route('user.plan') }}">
            <span class="icon"><i class="fal fa-clipboard-list"></i></span>
            <span class="text">@lang('Plan')</span>
        </a>
    </div>

    <div class="link-item {{menuActive(['user.dashboard'])}}">
        <a href="">
            <span class="icon"><i class="fal fa-house"></i></span>
            <span class="text">@lang('Home')</span>
        </a>
    </div>

    <div class="link-item {{menuActive(['user.addFund'])}}">
        <a href="">
            <span class="icon"><i class="fal fa-funnel-dollar" aria-hidden="true"></i></span>
            <span class="text">@lang('Deposit')</span>
        </a>
    </div>

    <div class="link-item {{menuActive(['user.profile'])}}">
        <a href="">
            <span class="icon"><i class="fal fa-user"></i></span>
            <span class="text">@lang('Profile')</span>
        </a>
    </div>
</div>


<div class="dashboard-wrapper">

    <!------ sidebar ------->
    @include(template().'partials.sidebar')
    <!-- content -->
    <div id="content">
        <div class="overlay">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand d-lg-none" href="{{route('page')}}"> <img
                            src="{{logo()}}"
                            alt="{{basicControl()->site_title??"HYIP PRO"}}"></a>
                    <button class="sidebar-toggler d-none d-lg-block" onclick="toggleSideMenu()">
                        <i class="fa-sharp fa-light fa-bars-staggered"></i>
                    </button>
                    <!-- navbar text -->
                    <!-- navbar text -->
                    <div class="navbar-text">
                        <!-- notification panel -->
                        @include(template().'partials.pushNotify')
                        <!-- user panel -->
                        @include(template().'partials.userDropdown')
                    </div>
                </div>
            </nav>
            @yield('content')
        </div>
    </div>
</div>

<!-- bootstrap -->
<script src="{{ asset(template(true). 'js/bootstrap.bundle.min.js') }}"></script>
<!-- jquery cdn -->
<script src="{{ asset(template(true) . 'js/jquery-3.6.0.min.js') }}"></script>

<!-- select 2 -->
<script src="{{ asset('assets/admin/js/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset(template(true) . 'js/select2.min.js') }}"></script>
<script src="{{asset(template(true).'js/aos.js')}}"></script>
<script src="{{asset(template(true).'js/owl.carousel.min.js')}}"></script>
<script src="{{asset(template(true).'js/socialSharing.js')}}"></script>
<script src="{{ asset(template(true) . 'js/script.js') }}"></script>


<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
@stack('js-lib')
@stack('script')

@include('plugins')
<script>
    var root = document.querySelector(':root');
    root.style.setProperty('--primary', '{{primaryColor()??'#ffb300'}}');
    root.style.setProperty('--secondary', '{{secondaryColor()??'#ffb300'}}');
</script>
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







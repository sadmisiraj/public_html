<!DOCTYPE html>
<html class="no-js" lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif >
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="{{ getFile(basicControl()->favicon_driver??'local', basicControl()->favicon??null) }}" rel="icon">


    <title>@yield('title') | @lang(basicControl()->site_title??"HYIP PRO") </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/bootstrap.min.css')}}"/>
    <!-- owl carousel -->
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/owl.theme.default.min.css')}}">
    <!-- select 2 -->
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/radialprogress.css')}}">
    <script src="{{asset(template(true).'js/fontawesomepro.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/dashboard.css')}}">
    <script src="{{asset(template(true).'js/modernizr.custom.js')}}"></script>
    @stack('css-lib')
    @stack('style')
</head>
<body @if(session()->get('rtl') == 1) class="rtl" @endif>

<!-- bottom navbar -->
<div class="bottom-nav fixed-bottom d-lg-none">
    <div class="link-item">
        <button onclick="toggleSideMenu()">
            <span class="icon"><i class="fal fa-ellipsis-v-alt"></i></span>
            <span class="text">@lang('Menus')</span>
        </button>
    </div>
    <div class="link-item">
        <a href="{{ route('user.plan') }}">
            <span class="icon"><i class="fal fa-layer-group" aria-hidden="true"></i></span>
            <span class="text">@lang('Plan')</span>
        </a>
    </div>
    <div class="link-item {{menuActive(['user.dashboard'])}}">
        <a href="{{ route('user.dashboard') }}">
            <span class="icon"><i class="fal fa-house"></i></span>
            <span class="text">@lang('Home')</span>
        </a>
    </div>
    <div class="link-item {{menuActive(['user.addFund'])}}">
        <a href="{{ route('user.addFund') }}">
            <span class="icon"><i class="fal fa-funnel-dollar" aria-hidden="true"></i></span>
            <span class="text">@lang('Deposit')</span>
        </a>
    </div>
    <div class="link-item {{menuActive(['user.profile'])}}">
        <a href="{{ route('user.profile') }}">
            <span class="icon"><i class="fal fa-user"></i></span>
            <span class="text">@lang('Profile')</span>
        </a>
    </div>
</div>

<div class="dashboard-wrapper">
    <!-- sidebar -->
    @include(template().'partials.sidebar')
    <!-- content -->
    <div id="content">
        <div class="overlay">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="d-lg-none" href="{{route('page')}}">
                        <img src="{{getFile(basicControl()->logo_driver,basicControl()->logo)}}"
                             alt="{{basicControl()->site_title??"HYIP PRO"}}" width="160">
                    </a>

                    <button class="sidebar-toggler d-none d-lg-block" onclick="toggleSideMenu()">
                        <i class="fal fa-bars"></i>
                    </button>

                    <span class="navbar-text" id="pushNotificationArea">
                       <!---- notification panel ---->
                       @include(template().'partials.pushNotify')

                        <!-- user panel -->
                        <div class="notification-panel user-panel d-none d-lg-inline-block">
                           <span class="profile">
                              <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}" class="img-fluid" alt="@lang('user img')"/>
                           </span>
                           <ul class="user-dropdown">
                              <li>
                                 <a href="{{route('user.dashboard')}}"> <i class="fal fa-border-all" aria-hidden="true"></i> @lang('Dashboard') </a>
                              </li>
                              <li>
                                 <a href="{{ route('user.profile') }}"> <i class="fal fa-user"></i> @lang('My Profile') </a>
                              </li>
                              <li>
                                 <a href="{{route('user.twostep.security')}}"> <i class="fal fa-key"></i> @lang('2FA Security') </a>
                              </li>
                              <li>
                                 <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"> <i class="fal fa-sign-out-alt"></i> @lang('Log Out') </a>
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


<script src="{{asset(template(true).'js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset(template(true).'js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset(template(true).'js/owl.carousel.min.js')}}"></script>
<script src="{{asset(template(true).'js/select2.min.js')}}"></script>
<script src="{{asset(template(true).'js/apexcharts.min.js')}}"></script>
<script src="{{asset(template(true).'js/radialprogress.js')}}"></script>
<script src="{{asset(template(true).'js/script.js')}}"></script>

<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
@include('plugins')
@stack('js-lib')
@stack('script')



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
    'use strict';
    var root = document.querySelector(':root');
    root.style.setProperty('--primary', '{{primaryColor()??'#9ff550'}}');

</script>
</body>
</html>

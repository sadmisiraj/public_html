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
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/aos.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/radialprogress.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/style_dashboard.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/fontawesome.min.css') }}">
    <script src="{{asset(template(true).'js/modernizr.custom.js')}}"></script>
    <style>
        .notify_description {
            width: 200px;
        }
    </style>
@stack('css-lib')
@stack('style')

<body  @if(session()->get('rtl') == 1) class="rtl" @endif onload="preloder_function()"  class="">



<!-- bottom navbar -->
<div class="bottom-nav fixed-bottom d-lg-none">
    <div class="link-item">
        <button onclick="toggleSideMenu()">
            <span class="icon"><i class="fal fa-ellipsis-v-alt"></i></span>
            <span class="text">Menus</span>
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
            <span class="text">Home</span>
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
<!-- preloader_area_start -->
<div id="preloader">
</div>
<!-- preloader_area_end -->


<div class="dashboard-wrapper">
    <!------ sidebar ------->
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
                        <!-- notification panel -->
                        @include(template().'partials.pushNotify')
                        <!-- user panel -->
                        @include(template().'partials.userDropdown')
                     </span>
                </div>
            </nav>
            @yield('content')
        </div>
    </div>
</div>
<script src="{{asset(template(true).'js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset(template(true).'js/jquery-3.6.1.min.js')}}"></script>
<script src="{{asset(template(true).'js/jquery-ui.js')}}"></script>
<script src="{{asset(template(true).'js/aos.js')}}"></script>
<script src="{{asset(template(true).'js/radialprogressOld.js')}}"></script>
<script src="{{asset(template(true).'js/select2.min.js')}}"></script>
<script src="{{asset(template(true).'js/fontawesomepro.js')}}"></script>
<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<!-- custom script -->
<script src="{{asset(template(true).'js/dashboard.js')}}"></script>

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

<script>
    var root = document.querySelector(':root');
    root.style.setProperty('--primary', '{{primaryColor()??'#46aeeb'}}');
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







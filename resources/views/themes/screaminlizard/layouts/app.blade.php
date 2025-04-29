<!DOCTYPE html>
<html lang="en" class="no-js"  @if(session()->get('rtl') == 1) dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@lang(basicControl()->site_title??"HYIP PRO") | @if(isset($pageSeo['page_title']))@lang($pageSeo['page_title'])@else
            @yield('title')@endif
    </title>
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


    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/bootstrap.min.css')}}"/>
    <!-- owl carousel -->
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/owl.theme.default.min.css')}}">
    <!-- select 2 -->
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/select2.min.css')}}">
    <script src="{{asset(template(true).'js/fontawesomepro.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/style.css')}}">
    <script src="{{asset(template(true).'js/modernizr.custom.js')}}"></script>
    <script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>


    @stack('css-lib')
    @stack('style')

</head>
<body>

<!-- navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('page') }}"> <img
                src="{{logo()}}" alt=""/></a>
        <button class="navbar-toggler p-0 " type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="fal fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                {!! renderHeaderMenu(getHeaderMenuData()) !!}
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            @lang('Login')
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
        <!-- navbar text -->

        <span class="navbar-text" id="pushNotificationArea">
             @auth
                <!-- notification panel -->
                <div class="d-none d-lg-block">
                @include(template().'partials.pushNotify')
            </div>
            @endauth

            @auth
                <!-- user panel -->
                <div class="notification-panel user-panel">
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
            @endauth
        </span>
    </div>
</nav>

@include(template().'partials.banner')

@yield('content')

@include(template().'partials.footer')

<script src="{{asset(template(true).'js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset(template(true).'js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset(template(true).'js/owl.carousel.min.js')}}"></script>
<script src="{{asset(template(true).'js/select2.min.js')}}"></script>
<script src="{{asset(template(true).'js/apexcharts.min.js')}}"></script>
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
    (function ($) {
        $(document).on('click', '.investNow', function () {
            var planModal = new bootstrap.Modal(document.getElementById('investNowModal'))
            planModal.show()
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

            $('.profit-details').html(`@lang('Interest'): ${(data.profit_type == '1') ? `${data.profit} %` : `${data.profit} ${currency}`}`);
            $('.profit-validity').html(`@lang('Per') ${data.schedule} @lang('hours') ,  ${(data.is_lifetime == '0') ? `${data.repeatable} @lang('times')` : `@lang('Lifetime')`}`);
            $('.plan-name').text(data.name);
            $('.plan-id').val(data.id);
            $('.show-currency').text("{{basicControl()->base_currency}}");
        });

    })(jQuery);
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
    "use strict";
    var root = document.querySelector(':root');
    root.style.setProperty('--primary', '{{primaryColor()??'#9ff550'}}');
</script>

</body>
</html>



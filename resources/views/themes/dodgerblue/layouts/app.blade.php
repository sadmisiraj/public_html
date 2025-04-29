<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif >

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>@lang(basicControl()->site_title??"HYIP PRO") | @if(isset($pageSeo['page_title']))@lang($pageSeo['page_title'])@else
            @yield('title')@endif
    </title>


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

    @stack('css-lib')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/fontawesome.min.css')}}" />
    <!-- owl carousel -->
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/owl.theme.default.min.css')}}">

    <!-- select 2 -->
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/fancybox.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/fontawesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'css/style.css')}}">
    <script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
    <script src="{{asset(template(true).'js/modernizr.custom.js')}}"></script>

    @stack('style')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="application/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script type="application/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>


<!-- main top navbar big device -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('page') }}"> <img
                src="{{logo()}}" alt=""></a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                {!! renderHeaderMenu(getHeaderMenuData()) !!}

                @guest
                    <li class="nav-item">
                        <a class="nav-link {{Request::routeIs('login') ? 'active' : ''}}" href="{{ route('login') }}">
                            @lang('Login')
                        </a>
                    </li>
                @endguest
            </ul>

        </div>
        <!-- navbar text -->
        <div class="navbar-text" id="pushNotificationArea">
            @auth
                <!-- notification panel -->
                {{--                <div class="d-none d-lg-block">--}}
                @include(template().'partials.pushNotify')
                {{--                </div>--}}
            @endauth

            @auth
                <div class="notification-panel user-panel">
               <span class="profile">
                  <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}" class="img-fluid"
                       alt="@lang('user img')"/>
               </span>
                    <ul class="user-dropdown">
                        <li>
                            <a href="{{route('user.dashboard')}}"> <i class="fal fa-border-all"
                                                                 aria-hidden="true"></i> @lang('Dashboard') </a>
                        </li>
                        <li>
                            <a href="{{ route('user.profile') }}"> <i class="fal fa-user"></i> @lang('My Profile') </a>
                        </li>
                        <li>
                            <a href="{{route('user.twostep.security')}}"> <i
                                    class="fal fa-key"></i> @lang('2FA Security') </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"> <i
                                    class="fal fa-sign-out-alt"></i> @lang('Log Out') </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</nav>


@include(template().'partials.banner')

@yield('content')

@include(template().'partials.footer')

<script src="{{asset(template(true).'js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset(template(true).'js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset(template(true).'js/owl.carousel.min.js')}}"></script>
<script src="{{asset(template(true).'js/select2.min.js')}}"></script>
<script src="{{asset(template(true).'js/fancybox.umd.js')}}"></script>
<script src="{{asset(template(true).'js/socialSharing.js')}}"></script>
<script src="{{asset(template(true).'js/apexcharts.min.js')}}"></script>
<!-- counter up -->
<script src="{{asset(template(true).'js/jquery.counterup.min.js')}}"></script>

<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<script src="{{asset(template(true).'js/script.js')}}"></script>

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

<script>
    var root = document.querySelector(':root');
    root.style.setProperty('--primary', '{{primaryColor()??'#46aeeb'}}');
    root.style.setProperty('--secondary', '{{secondaryColor()??'#46aeeb'}}');
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

@include('plugins')

</body>

</html>

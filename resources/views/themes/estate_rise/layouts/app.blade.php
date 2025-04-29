<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang(basicControl()->site_title??"HYIP PRO") | @if(isset($pageSeo['page_title']))@lang($pageSeo['page_title'])@else
            @yield('title')@endif</title>
    <!-- Favicon-link -->
    <link rel="shortcut icon" href="{{ getFile(basicControl()->favicon_driver??'local', basicControl()->favicon??null) }}" type="image/x-icon">
    <!-- Fontawesome6-Js-link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/all.min.css')}}">
    <!-- <link rel="stylesheet" href="assets/css/fontawesome.min.css"> -->
    <!-- Bootstrap5-Css-link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/bootstrap.min.css')}}">
    <!-- Owl-carousel-Css-link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset(template(true).'css/owl.theme.default.min.css')}}">
    <!-- Slick slider Css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/slick.css')}}">
    <link rel="stylesheet" href="{{asset(template(true).'css/slick-theme.css')}}">
    <!-- Slick swiper Css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/swiper-bundle.min.css')}}">
    <!-- select2-Css-link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/select2.min.css')}}">
    <!-- fancybox css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/fancybox.css')}}">
    <!-- magnific popup css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/magnific-popup.css')}}">
    <!-- aos css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/aos.css')}}">
    <!-- Style Css link -->
    <link rel="stylesheet" href="{{asset(template(true).'css/style.css')}}">

    <script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
    @stack('css-lib')
    @stack('style')
</head>
<body onload="preloaderFunction()" class="">
<!-- Preloader section start -->
<div id="preloader">
    <img src="{{asset(template(true).'img/preloader/camera.gif')}}" alt="">
</div>
<!-- Preloader section end -->

<!-- Nav section start -->
    @include(template().'partials.header')
<!-- Nav section end -->

<!-- Banner section start -->
@include(template().'partials.banner')
<!-- Banner section end -->

<!-- Content section start -->
        @yield('content')
<!-- Content section end -->

<!-- Footer Section start -->
    @include(template().'partials.footer')
<!-- Footer Section end -->
<!-- Jquery Js link -->
<script src="{{asset(template(true).'js/jquery-3.7.1.min.js')}}"></script>
<!-- Bootstrap Js link -->
<script src="{{asset(template(true).'js/bootstrap.bundle.min.js')}}"></script>
<!-- Owl carausel Js link -->
<script src="{{asset(template(true).'js/owl.carousel.min.js')}}"></script>
<!-- Swiper Js link -->
<script src="{{asset(template(true).'js/swiper-bundle.min.js')}}"></script>
<!-- Slick slider js link -->
<script src="{{asset(template(true).'js/slick.min.js')}}"></script>
<!-- select2 Js link -->
<script src="{{asset(template(true).'js/select2.min.js')}}"></script>
<!-- fancybox Js link -->
<script src="{{asset(template(true).'js/fancybox.umd.js')}}"></script>
<!-- parallax scroll Js link -->
<script src="{{asset(template(true).'js/parallax-scroll.js')}}"></script>
<!-- counterup Js link -->
<script src="{{asset(template(true).'js/jquery.counterup.min.js')}}"></script>
<script src="{{asset(template(true).'js/jquery.waypoints.min.js')}}"></script>
<!-- isotope Js link -->
<!-- <script src="assets/js/isotope.pkgd.min.js"></script> -->
<script src="{{asset(template(true).'js/isotope.js')}}"></script>
<!-- Magnifc popup Js link -->
<script src="{{asset(template(true).'js/jquery.magnific-popup.min.js')}}"></script>
<!-- aos Js link -->
<script src="{{asset(template(true).'js/aos.js')}}"></script>
<!-- Main Js link -->
<script src="{{asset(template(true).'js/main.js')}}"></script>

<!-- Global Js link -->
<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
@stack('js-lib')
@stack('script')

<!-- include plugin -->
@include('plugins')

<script>
    $(document).on('click', '.investNow', function () {
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
    root.style.setProperty('--primary-color', '{{hex2rgba(primaryColor(),false,true)??'#ffb300'}}');
</script>

<!-- Toast Notification script -->
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

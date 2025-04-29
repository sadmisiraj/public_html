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
    
    <link rel="stylesheet" href="{{asset(template(true).'css/bootstrap.min.css')}}"/>
    <!-- font awesome 6 -->
    <link rel="stylesheet" href="{{asset(template(true).'css/all.min.css')}}"/>
    <link rel="stylesheet" href="{{asset(template(true).'css/fontawesome.min.css')}}"/>
    <!-- aos animation -->
    <link rel="stylesheet" href="{{asset(template(true).'css/aos.css')}}"/>
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{asset(template(true).'css/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset(template(true).'css/owl.theme.default.min.css')}}"/>
    <!-- select 2 -->
    <link rel="stylesheet" href="{{asset(template(true).'css/select2.min.css')}}"/>
    <!-- fancybox -->
    <link rel="stylesheet" href="{{asset(template(true).'css/fancybox.css')}}"/>
    <!-- custom css -->
    <link rel="stylesheet" href="{{asset(template(true).'css/style.css')}}"/>
    <script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>

    @stack('css-lib')
    @stack('style')

</head>
<body>

<!-- pre loader -->
<div id="preloader">
    <img src="{{ asset(template(true).'img/icon/plant.gif') }}" alt="" class="loader"/>
</div>
<!-- preloader_area_end -->

<!-- Header -->
@include(template().'partials.header')
<!-- End Header -->
@if(!request()->is('/'))
    <!-- banner section -->
    @if (isset($pageSeo) && $pageSeo)
<!-- banner section -->
        <section class="banner-section" style="background: url({{$pageSeo['breadcrumb_image']}});">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>{!! $pageSeo['page_title'] !!}</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('page') }}">@lang('Home')</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{!! $pageSeo['page_title'] !!}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif

@yield('content')

@include(template().'partials.footer')





<!-- bootstrap -->
<script src="{{asset(template(true).'js/bootstrap.bundle.min.js')}}"></script>
<!-- jquery cdn -->
<script src="{{asset(template(true).'js/jquery-3.6.0.min.js')}}"></script>
<!-- counter up -->
<script src="{{asset(template(true).'js/jquery.counterup.min.js')}}"></script>
<script src="{{asset(template(true).'js/jquery.waypoints.min.js')}}"></script>
<!-- aos animation -->
<script src="{{asset(template(true).'js/aos.js')}}"></script>
<!-- owl carousel -->
<script src="{{asset(template(true).'js/owl.carousel.min.js')}}"></script>
<!-- select 2 -->
<script src="{{asset(template(true).'js/select2.min.js')}}"></script>
<!-- fancy box -->
<script src="{{asset(template(true).'js/fancybox.umd.js')}}"></script>
<!-- social js -->
<script src="{{asset(template(true).'js/socialSharing.js')}}"></script>
<!-- custom js -->
<script src="{{asset(template(true).'js/script.js')}}"></script>

<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>

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
    'use strict'

    // pre loader
    const preloader = document.getElementById("preloader");
    window.addEventListener("load", () => {
        setTimeout(() => {
            preloader.style.cssText = `opacity: 0; visibility: hidden;`;
        }, 300);
    });

    // COUNTER UP
    $(".counter").counterUp({
        delay: 10,
        time: 3000,
    });
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init();
    });
</script>

@include('plugins')

<script>
    var root = document.querySelector(':root');
    root.style.setProperty('--primary', '{{primaryColor()??'#ffb300'}}');
    root.style.setProperty('--secondary', '{{secondaryColor()??'#7cb342'}}');
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



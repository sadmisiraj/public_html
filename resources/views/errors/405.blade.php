<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang(basicControl()->site_title??"HYIP PRO") | @lang('Method Not Allowed')</title>
    <!-- Favicon-link -->
    <link rel="shortcut icon" href="{{ getFile(basicControl()->favicon_driver??'local', basicControl()->favicon??null) }}" type="image/x-icon">
    <!-- Fontawesome6 Js link -->
    <link rel="stylesheet" href="{{asset('assets/themes/estate_rise/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/themes/estate_rise/css/fontawesome.min.css')}}">
    <!-- Bootstrap5 Css link -->
    <link rel="stylesheet" href="{{asset('assets/themes/estate_rise/css/bootstrap.min.css')}}">
    <!-- Owl_carousel Css link -->
    <link rel="stylesheet" href="{{asset('assets/themes/estate_rise/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/themes/estate_rise/css/owl.theme.default.min.css')}}">
    <!-- Swiper Css link -->
    <link rel="stylesheet" href="{{asset('assets/themes/estate_rise/css/swiper-bundle.min.css')}}">
    <!-- select2 Css link -->
    <link rel="stylesheet" href="{{asset('assets/themes/estate_rise/css/select2.min.css')}}">


    <!-- Style Css link -->
    <link rel="stylesheet" href="{{asset('assets/themes/estate_rise/css/style.css')}}">

</head>

<body onload="preloaderFunction()" class="pb-0">
<!-- Preloader section start -->
<div id="preloader">
    <img src="{{asset('assets/themes/estate_rise/img/preloader/camera.gif')}}" alt="">
</div>
<!-- Preloader section end -->



<!-- ---------------------------------------------------- -->
<!-- Error section start -->
<!-- ---------------------------------------------------- -->
<section class="error-section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-sm-6">
                <div class="error-thum">
                    <img src="{{asset('assets/themes/estate_rise/img/error/error.png')}}" alt="EstateRise">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="error-content">
                    <div class="error-title">405</div>
                    <div class="error-info">@lang('Method Not Allowed')!</div>
                    <div class="btn-area">
                        <a href="{{route('page')}}" class="cmn-btn">@lang('Back to Homepage')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ---------------------------------------------------- -->
<!-- Error section end -->
<!-- ---------------------------------------------------- -->



<!-- Jquery_Js_link -->
<!-- <script src="assets/js/jquery-3.6.1.min.js"></script> -->
<script src="{{asset('assets/themes/estate_rise/js/jquery-3.7.1.min.js')}}"></script>

<!-- Bootstrap_Js_link -->
<script src="{{asset('assets/themes/estate_rise/js/bootstrap.bundle.min.js')}}"></script>
<!-- Owl_carausel_Js_link -->
<script src="{{asset('assets/themes/estate_rise/js/owl.carousel.min.js')}}"></script>
<!-- Swiper_Js_link -->
<script src="{{asset('assets/themes/estate_rise/js/swiper-bundle.min.js')}}"></script>
<!-- select2_Js_link -->
<script src="{{asset('assets/themes/estate_rise/js/select2.min.js')}}"></script>
<script src="{{asset('assets/themes/estate_rise/js/aos.js')}}"></script>


<!-- Main_Js_link -->
<script src="{{asset('assets/themes/estate_rise/js/main.js')}}"></script>

</body>

</html>

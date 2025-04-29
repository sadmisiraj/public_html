<!-- Header_area_start -->
<div class="header_area fixed-to" id="header_top">
    <!-- Header_top_area_start -->
    <div class="header_top_area" >
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-md-7 text-center">
                    <div class="header_top_left  d-none d-sm-block">
                        <ul class="d-flex justify-content-md-start justify-content-center">
                            <li><i class="fa-solid fa-envelope"></i> <a href="mailto:{{$footer['single']['email']??''}})">{{$footer['single']['email']??''}}</a> </li>
                            <li><i class="fa-solid fa-phone"></i> <a href="tel:{{$footer['single']['telephone']??''}}">{{$footer['single']['telephone']??''}}</a> </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5 ">
                    <div
                        class="header_top_right d-flex justify-content-md-end justify-content-center align-items-center">
                        <div class="language_select_area">
                            <div class="dropdown">
                                <button class="custom_dropdown dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    @lang('Lang')
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($languages as $language)
                                        <li>
                                            <a class="dropdown-item" href="{{route('language',$language->short_name)}}">
                                            <span class="flag-icon flag-icon-{{$language->short_name}}">
                                            </span> {{$language->name}}
                                            </a>
                                        </li>
                                    @endforeach



                                </ul>
                            </div>
                        </div>
                        <div class="login_area">
                            <ul class="social_area d-flex">
                                @foreach(collect($footer['multiple']) as $data)

                                    <li><a href="{{$data['media']->social_link??''}}" target="_blank" class="">{!! icon($data['media']->social_link) !!}</a></li>
                                @endforeach
{{--                                    {{session()->get('trans') == $key ? 'lang_active' : ''}}--}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header_top_area_end -->

    <!-- Nav_area_start -->
    <div class="nav_area">
        <nav class="navbar navbar-expand-lg">
            <div class="container custom_nav">
                <a class="logo" href="{{route('page')}}"><img src="{{ logo() }}"
                                                         alt="{{basicControl()->site_title??"HYIP PRO"}}"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="bars"><i class="fa-solid fa-bars-staggered"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto text-center align-items-center align-items-center">
                        {!! renderHeaderMenu(getHeaderMenuData()) !!}
                        @guest
                            <li class="nav-item">
                                <a class="login_btn" href="{{ route('login') }}"><i class="fa-regular fa-user"></i> @lang('Login')</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="login_btn" href="{{ route('user.dashboard') }}"><i class="fa-regular fa-user"></i> @lang('Dashboard')</a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- Nav_area_end -->
</div>
<!-- Header_area_end -->




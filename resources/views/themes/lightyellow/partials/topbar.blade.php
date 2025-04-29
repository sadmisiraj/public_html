<!-- nav_area_start -->
<div id="nav_area" class="nav_area shadow1">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand site_logo" href="{{url('/')}}"><img src="{{logo()}}"
                                                                       alt="{{basicControl()->site_title??"HYIP PRO"}}"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar">
                <span class="bars"><i class="fa fa-bars"></i></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                 aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title site_logo" id="offcanvasNavbarLabel"></h5>
                    <button type="button" class="btn_close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="far fa-times"></i></button>
                </div>
                <div class="offcanvas-body fs-6">
                    <ul class="navbar-nav ms-auto pe-3 align-items-center">
                        {!! renderHeaderMenu(getHeaderMenuData()) !!}
                        @guest
                            <li class="nav-item">
                                <a class="nav-link login_btn" href="{{ route('login') }}">@lang('Login')</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link login_btn" href="{{route('user.dashboard')}}">@lang('Dashboard')</a>
                            </li>
                        @endguest
                    </ul>
                    <ul class="navbar-nav justify-content-end  pe-3 align-items-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <img src="{{ asset(template(true).'img/lang/translation.png') }}" alt=""> @lang('Lang')
                            </a>
                            <ul class="dropdown-menu shadow1 language" >
                                @foreach($languages as $language)
                                    <li >
                                        <a class="dropdown-item {{$language->short_name === app()->getLocale()? 'lang_active':''}}" href="{{route('language',$language->short_name)}}">
                                            <span class="flag-icon flag-icon-us"></span> {{$language->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- nav_area_end -->




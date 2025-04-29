<!-- Nav section start -->
<nav class="navbar fixed-top navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand logo" href="{{route('page')}}"><img src="{{logo()}}" alt="EstateRise" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
            <i class="fa-light fa-list"></i>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbar">
            <div class="offcanvas-header">
                <a class="navbar-brand" href="{{route('page')}}"><img class="logo" src="{{logo()}}"
                                                               alt="EstateRise" /></a>

                <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
                        class="fa-light fa-arrow-right"></i></button>
            </div>
            <div class="offcanvas-body align-items-center justify-content-between">
                <ul class="navbar-nav m-auto">
                    {!! renderHeaderMenu(getHeaderMenuData()) !!}
                </ul>
            </div>
        </div>
        <div class="nav-right">
            <ul class="custom-nav">
                <li class="nav-item">
                    @include(template().'partials.pushNotify')
                </li>
                <li class="nav-item">
                    @auth
                        <div class="profile-box">
                        <div class="profile">
                            <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}" class="img-fluid" alt="EstateRise" />
                        </div>
                        <ul class="user-dropdown">
                            <li>
                                <a href="{{route('user.dashboard')}}"> <i class="fal fa-border-all"></i> @lang('Dashboard') </a>
                            </li>
                            <li>
                                <a href="{{ route('user.profile') }}"> <i class="fal fa-user"></i> @lang('View Profile') </a>
                            </li>
                            <li>
                                <a href="{{route('user.twostep.security')}}"> <i class="fal fa-lock"></i> @lang('2FA Security') </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fal fa-sign-out-alt"></i> @lang('Logout')
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endauth
                    @guest
                            <a href="{{route('login')}}" class="cmn-btn"><span>@lang('Login')</span></a>
                    @endguest
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Nav section end -->

<!-- Bottom Mobile Tab nav section start -->
<ul class="nav bottom-nav fixed-bottom d-lg-none">
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="offcanvas" role="button" aria-controls="offcanvasNavbar"
           href="#offcanvasNavbar" aria-current="page"><i class="fa-light fa-list"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fa-light fa-planet-ringed"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link active"><i class="fa-light fa-house"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fa-light fa-address-book"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fa-light fa-user"></i></a>
    </li>
</ul>
<!-- Bottom Mobile Tab nav section end -->

<!-- navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{route('page')}}"> <img src="{{logo()}}"
                                                          alt=""/></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fal fa-bars-staggered"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                {!! renderHeaderMenu(getHeaderMenuData()) !!}
            </ul>
        </div>


        <!-- navbar text -->
        <div class="navbar-text" id="pushNotificationArea">
            <!-- notification panel -->

            @include(template().'partials.pushNotify')

            <!-- user panel -->
            @auth
                <div class="notification-panel user-panel">
                    <div class="profile">
                        <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}" class="img-fluid" alt="@lang('user img')"/>
                    </div>
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


            @guest
                <a class="btn-custom" href="{{ route('login') }}">@lang('Login')</a>
            @endguest
        </div>
    </div>
</nav>

<!-- navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{route('page')}}"> <img src="{{logo()}}"
                                                          alt="{{basicControl()->site_title??"HYIP PRO"}}"/></a>
        <button
            class="navbar-toggler p-0"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <i class="far fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                {!! renderHeaderMenu(getHeaderMenuData()) !!}
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{Request::routeIs('login') ? 'active' : ''}}"
                           href="{{ route('login') }}">@lang('Login')</a>
                    </li>
                @endguest
            </ul>
        </div>

        @auth
            <span class="navbar-text">

           @include(template().'partials.pushNotify')
                <!-- user panel -->
               <div class="user-panel">
                  <span class="profile">
                     <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}" alt="@lang('user img')"
                          class="img-fluid"/>
                  </span>
                  <ul class="user-dropdown">
                      <li>
                            <a href="{{route('user.dashboard')}}"><i class="fal fa-border-all" aria-hidden="true"></i> {{trans('Dashboard')}}</a>
                      </li>

                      <li>
                        <a href="{{ route('user.profile') }}"><i class="far fa-user"></i> @lang('My Profile')</a>
                      </li>

                      <li>
                        <a href="{{route('user.twostep.security')}}"><i
                                class="far fa-key"></i> @lang('2FA Security')</a>
                      </li>
                      <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="far fa-sign-out-alt"></i>
                             @lang('Logout')
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                      </li>
                  </ul>
               </div>
            </span>
        @endauth
    </div>
</nav>

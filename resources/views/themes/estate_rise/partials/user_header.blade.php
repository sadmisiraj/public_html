<!-- Header section start -->
<header id="header" class="header">
    <button class="toggle-sidebar-btn d-none d-xl-block"><i class="fa-light fa-list"></i></button>
    <!-- End Logo -->
    <!-- Start Icons Navigation -->
    <nav class="header-nav ms-auto">
        <ul class="nav-icons">
            @auth
                @if(basicControl()->in_app_notification)
                    <li class="nav-item dropdown" id="pushNotificationArea">
                        <a class="nav-link nav-icon" href="javascript:void(0)" data-bs-toggle="dropdown">
                            <i class="fa-light fa-bell"></i>
                            <span class="badge badge-number">@{{items.length}}</span>
                        </a>
                        <!-- Start Notification Dropdown Items -->
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                            <div class="dropdown-header">
                                @lang('You have') @{{items.length}} @lang('new notifications')
                            </div>
                            <div class="dropdown-body">
                                <div class="notification-item" v-for="(item, index) in items" @click.prevent="readAt(item.id, item.description.link)">
                                    <a href="">
                                        <i class="fal fa-bell text-warning"></i>
                                        <div>
                                            <p>@{{item.description.text}}</p>
                                            <p>@{{ item.formatted_date }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown-footer">
                                <a href="javascript:void(0)" v-if="items.length == 0"
                                >@lang('You have no notifications')</a>
                                <a href="javascript:void(0)" v-if="items.length > 0" @click.prevent="readAll">@lang('Clear all')</a>
                            </div>
                        </div>
                        <!-- End Notification Dropdown Items -->

                    </li><!-- End Notification Nav -->
                @endif
            @endauth

            <!-- Notification section end -->
            
            
    
            <li class="nav-item dropdown">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                   data-bs-toggle="dropdown">
                    <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-xl-block dropdown-toggle ps-2">{{auth()->user()->fullname}}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header d-flex justify-content-center align-items-center text-start">
                        <div class="profile-thum">
                            <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}" alt="user image">
                        </div>
                        <div class="profile-content">
                            <h6>{{auth()->user()->fullname}}</h6>
                            <span>{{'@'.auth()->user()->username}}</span>
                        </div>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('user.dashboard')}}">
                            <i class="fal fa-border-all"></i>
                            <span>@lang('Dashboard')</span>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('user.profile') }}">
                            <i class="fal fa-user"></i>
                            <span>@lang('My Profile')</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('user.twostep.security')}}">
                            <i class="fal fa-lock"></i>
                            <span>@lang('2FA Security')</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fal fa-sign-out-alt"></i>
                            <span>@lang('Logout')</span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </li>

                </ul>
            </li>
            <!-- Nav Profile section end -->

        </ul>
    </nav>
    <!-- End Icons Navigation -->

</header>
<!-- Header section start -->

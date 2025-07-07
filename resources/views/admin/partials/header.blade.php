<div class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <nav class="navbar navbar-expand-lg navbar-light px-0 justify-content-between">
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        <img src="{{ getFile(basicControl()->logo_driver ?? 'local', basicControl()->logo ?? null) }}" alt="Logo">
                    </a>

                    <div class="dashboard_log d-flex align-items-center">
                        <div class="profile_log dropdown">
                            <div class="user" data-toggle="dropdown">
                                <span class="thumb">
                                    <img src="{{ getFile(auth()->guard('admin')->user()->image_driver ?? 'local', auth()->guard('admin')->user()->image ?? null) }}" alt="Profile Image">
                                </span>
                                <span class="name">{{ auth()->guard('admin')->user()->name }}</span>
                                <span class="arrow"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('admin.profile') }}" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i> Profile
                                </a>
                                <a href="{{ route('admin.password.update') }}" class="dropdown-item">
                                    <i class="fas fa-key"></i> Change Password
                                </a>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div> 
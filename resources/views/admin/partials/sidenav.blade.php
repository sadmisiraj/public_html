<li class="sidebar-menu-item {{menuActive('admin.users*')}}">
    <a href="{{route('admin.users.all')}}" class="nav-link">
        <i class="menu-icon las la-users"></i>
        <span class="menu-title">@lang('Manage Users')</span>
    </a>
</li>

<li class="sidebar-menu-item {{menuActive('admin.rgp.transactions')}}">
    <a href="{{route('admin.rgp.transactions')}}" class="nav-link">
        <i class="menu-icon las la-chart-network"></i>
        <span class="menu-title">@lang('RGP Transactions')</span>
    </a>
</li> 
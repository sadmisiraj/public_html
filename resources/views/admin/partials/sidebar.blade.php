<div class="sidebar">
    <div class="menu">
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-home"></i></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.security.index') }}" class="{{ request()->routeIs('admin.security.*') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-shield-alt"></i></span>
                    <span class="text">Security Settings</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.offer-images.index') }}" class="{{ request()->routeIs('admin.offer-images.*') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-images"></i></span>
                    <span class="text">Offer Images</span>
                </a>
            </li>
        </ul>
    </div>
</div> 
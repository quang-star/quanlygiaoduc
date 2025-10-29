<div class="dropdown" style="position: relative;">
    <img src="{{ asset(Auth::user()->avatar ? Auth::user()->avatar : 'images/kirito.jpg') }}" alt="Avatar"
        class="dropdown-toggle shadow-sm" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false"
        style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; cursor: pointer; border: 2px solid #ddd; transition: 0.3s;">
    
    <ul class="dropdown-menu dropdown-menu-end shadow border-0" 
        aria-labelledby="userMenu"
        style="min-width: 180px; border-radius: 15px; overflow: hidden;">
        <li class="px-3 py-2 text-center">
            <div class="fw-bold">{{ Auth::user()->name }}</div>
            <div class="text-muted" style="font-size: 13px;">{{ Auth::user()->email }}</div>
        </li>
        <li><hr class="dropdown-divider m-0"></li>
        <li>
            <a class="dropdown-item py-2" href="{{ url('admin/profile/index') }}">
                <i class="fa fa-user me-2"></i> Thông tin cá nhân
            </a>
        </li>
        <li>
            <a class="dropdown-item text-danger py-2" href="{{ url('logout') }}">
                <i class="fa fa-sign-out-alt me-2"></i> Đăng xuất
            </a>
        </li>
    </ul>
</div>

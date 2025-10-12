<div class="sidebar" id="sidebar">
    <div id="toggleContainer">
        <img class="toggle-btn" id="toggleBtn" src="{{ asset('images/avt.png') }}" alt="" height="100" width="100">
    </div>

    <nav class="nav flex-column">
        <a class="nav-link" href="{{ url('/hopdong') }}"><i class="bi bi-house"></i> <span class="link-text">Thống kê</span></a>

        <!-- Dropdown Học viên -->
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="toggleDropdown(event)">
                <i class="bi bi-person-lines-fill"></i> <span class="link-text">Học viên</span>
                <i class="bi bi-chevron-down ms-auto toggle-icon"></i>
            </a>
            <ul class="submenu list-unstyled">
                <li><a class="nav-link sub-link" href="{{ url('/hocvien') }}">Danh sách học viên</a></li>
                <li><a class="nav-link sub-link" href="{{ url('/hocvienchoxeplop') }}">Học viên chờ xếp lớp</a></li>
                <li><a class="nav-link sub-link" href="{{ url('/hocvienchotest') }}">Học viên chờ test</a></li>
            </ul>
        </li>

        {{-- <a class="nav-link" href="#"><i class="bi bi-journal-bookmark"></i> <span class="link-text">Học viên chờ xếp lớp</span></a> --}}
        <a class="nav-link" href="{{ url('/hopdong') }}"><i class="bi bi-person"></i> <span class="link-text">Hợp đồng</span></a>
         <a class="nav-link" href="{{ url('/khoahoc') }}"><i class="bi bi-person"></i> <span class="link-text">Khóa học</span></a>
        <a class="nav-link" href="{{ url('/lophoc') }}"><i class="bi bi-gear"></i> <span class="link-text">Lớp học</span></a>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="toggleDropdown(event)">
                <i class="bi bi-person-lines-fill"></i> <span class="link-text">Cài đặt</span>
                <i class="bi bi-chevron-down ms-auto toggle-icon"></i>
            </a>
            <ul class="submenu list-unstyled">
                <li><a class="nav-link sub-link" href="hocvien_list.html">Cấu hình chung</a></li>
                <li><a class="nav-link sub-link" href="hocvien_add.html">Ngôn ngữ</a></li>
                
            </ul>
        </li>
    </nav>
</div>

<style>
    /* Sidebar */
    .sidebar {
        background-color: #1e293b;
        color: #fff;
        width: 240px;
        transition: all 0.3s ease;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 20px;
    }

    .sidebar.collapsed {
        width: 70px;
    }

    .sidebar .toggle-btn {
        width: 100px;
        height: 100px;
        cursor: pointer;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    #toggleContainer {
        width: 100%;
        display: flex;
        justify-content: center;
        cursor: pointer;
    }

    /* Nav styles */
    .sidebar .nav {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .sidebar .nav-link {
        color: #fff;
        display: flex;
        align-items: center;
        padding: 10px 15px;
        width: 100%;
        transition: background-color 0.3s;
        text-decoration: none;
    }

    .sidebar .nav-link:hover {
        background-color: #334155;
    }

    .sidebar i {
        font-size: 20px;
        width: 30px;
        text-align: center;
    }

    /* Dropdown submenu */
    .submenu {
        display: none;
        background-color: #243447;
        transition: all 0.3s ease;
    }

    .submenu.open {
        display: block;
    }

    .sub-link {
        padding-left: 45px;
        font-size: 14px;
    }

    .sub-link:hover {
        background-color: #3b4b61;
    }

    /* Collapsed sidebar */
    .sidebar.collapsed .link-text {
        display: none;
    }

    .sidebar.collapsed .nav-link {
        justify-content: center;
    }

    .sidebar.collapsed .submenu {
        display: none !important;
    }

    .toggle-icon {
        margin-left: auto;
        transition: transform 0.3s;
    }

    .submenu.open + .toggle-icon {
        transform: rotate(180deg);
    }
</style>

<script>
    const toggleBtn = document.getElementById('toggleContainer');
    const sidebar = document.getElementById('sidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
    });

    function toggleDropdown(e) {
        e.preventDefault();
        const parentLi = e.target.closest('li');
        const submenu = parentLi.querySelector('.submenu');

        // Đóng các submenu khác
        document.querySelectorAll('.submenu').forEach(menu => {
            if (menu !== submenu) menu.classList.remove('open');
        });

        submenu.classList.toggle('open');
    }
</script>

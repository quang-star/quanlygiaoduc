<div class="sidebar" id="sidebar">
    <div id="toggleContainer">
        <img class="toggle-btn" id="toggleBtn" src="{{ asset(setting('logo', 'images/default-logo.png')) }}" alt="" height="100" width="100">
    </div>
    <nav class="nav flex-column">

        <a class="nav-link" href="{{ url('/student/all-schedule') }}">
            <i class="fa-solid fa-file-signature"></i>
            <span class="link-text">Lịch học</span>
        </a>
        <a class="nav-link" href="{{ url('/student/class-learned') }}">
            <i class="fa-solid fa-chalkboard-user"></i>
            <span class="link-text">Lớp theo học</span>
        </a>
        <a class="nav-link" href="{{ url('/student/bill-history') }}">
            <i class="fa-solid fa-chalkboard-user"></i>
            <span class="link-text">Lịch sử thanh toán</span>
        </a>

      
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
    .submenu {
        padding-left: 20px;
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

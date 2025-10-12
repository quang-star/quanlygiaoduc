<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('dist/calendar.js.css') }}">
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Layout chính */
        .main-container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        #header-content {
            height: 60px;
            width: 100%;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            align-items: center;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
            background-color: #f8f9fa;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            /* ✅ Cuộn dọc */
            padding: 20px;
            background-color: #fff;
            height: calc(100vh - 60px);
            /* ✅ Trừ header-content */
            box-sizing: border-box;
        }

        .w-90 {
            width: 98%;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <div id="header">
        @include('admin.layouts.header')
    </div>

    {{-- Phần chính: sidebar + content --}}
    <div class="main-container">
        @include('admin.layouts.sidebar')
        <div class="main-content">
            <div id="header-content">
                @yield('header-content')
            </div>
            <div class="content" id="content">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
</body>

</html>

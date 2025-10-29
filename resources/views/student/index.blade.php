<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
 <link rel="icon" href="{{ asset(setting('favicon', 'images/default-favicon.png')) }}" type="image/png">
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
        @include('student.layouts.header')
    </div>

    {{-- Phần chính: sidebar + content --}}
    <div class="main-container">
        @include('student.layouts.sidebar')
        <div class="main-content">
            <div id="header-content">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 d-flex align-items-center justify-content-left">

                            <h3 style="padding-left: 45px;"> @yield('header-content')</h3>
                        </div>

                        <div class="col-md-6 text-end" style="padding-right: 45px;">
                            @include('student.layouts.profile-menu')
                        </div>

                    </div>
                </div>
            

            </div>
            <div class="content" id="content">
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" id="flashMessage" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" id="flashMessage" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
    <script>
        // Khi rời trang — lưu URL hiện tại vào localStorage (dạng mảng)
        window.addEventListener('beforeunload', function() {
            const currentUrl = window.location.href;
            let historyStack = JSON.parse(localStorage.getItem('urlHistory')) || [];

            // Nếu mảng rỗng hoặc phần tử cuối khác URL hiện tại thì mới push
            if (historyStack.length === 0 || historyStack[historyStack.length - 1] !== currentUrl) {
                historyStack.push(currentUrl);
            }

            // Giới hạn tối đa số URL lưu (tùy chọn)
            if (historyStack.length > 20) {
                historyStack.shift(); // xóa phần tử cũ nhất
            }

            localStorage.setItem('urlHistory', JSON.stringify(historyStack));
        });

        // Khi trang load xong — xử lý nút Back
        document.addEventListener('DOMContentLoaded', function() {
            const backButton = document.getElementById('backBtn');

            if (backButton) {
                backButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    let historyStack = JSON.parse(localStorage.getItem('urlHistory')) || [];
                    if (historyStack.length > 1) {
                        // Xóa URL hiện tại (cuối mảng)
                        historyStack.pop();
                        // Lấy URL trước đó
                        const previousUrl = historyStack[historyStack.length - 1];

                        // Cập nhật lại stack sau khi lùi
                        localStorage.setItem('urlHistory', JSON.stringify(historyStack));

                        // Chuyển trang
                        window.location.href = previousUrl;
                    } else {
                        // Nếu không còn URL trong lịch sử thì quay lại mặc định
                        window.history.back();
                    }
                });
            }

            // ✅ Nếu phát hiện vào trang mới hoàn toàn (không nằm trong stack cũ)
            const currentUrl = window.location.href;
            let historyStack = JSON.parse(localStorage.getItem('urlHistory')) || [];
            if (historyStack.length === 0 || historyStack[historyStack.length - 1] !== currentUrl) {
                // Reset lại mảng (tránh giữ lịch sử cũ của session khác)
                localStorage.setItem('urlHistory', JSON.stringify([currentUrl]));
            }
        });
    </script>

    <script>
        // Ẩn thông báo sau 3 giây
        document.addEventListener("DOMContentLoaded", function() {
            const alertBox = document.getElementById("flashMessage");
            if (alertBox) {
                setTimeout(() => {
                    alertBox.classList.remove("show");
                    alertBox.classList.add("fade");
                    alertBox.style.transition = "opacity 0.5s ease";
                    alertBox.style.opacity = 0;
                    setTimeout(() => alertBox.remove(), 500); // Xóa hẳn khỏi DOM sau khi ẩn
                }, 3000); // 3 giây
            }
        });
    </script>



</body>

</html>

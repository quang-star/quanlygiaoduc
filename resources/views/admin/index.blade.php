<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('site_name', 'Default Site') }}</title>


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

        .mr-3 {
            margin-right: 3px;
        }

        .ml-3 {
            margin-left: 3px;
        }
    </style>
    <link rel="icon" href="{{ asset(setting('favicon', 'images/default-favicon.png')) }}" type="image/png">

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

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 d-flex align-items-center">

                            <h3 style="padding-left: 45px; padding-top: 10px;"> @yield('header-content')</h3>
                        </div>


                        <div class="col-md-6 text-end" style="padding-right: 45px;">
                            @include('admin.layouts.profile-menu')
                        </div>

                    </div>
                </div>
                {{-- Hiển thị từng thông báo lỗi --}}
               

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const alerts = Array.from(document.querySelectorAll('#flashContainer .flashMessage'));
                        const groupSize = 1; // số alert hiển thị mỗi lượt
                        const groupDelay = 1000; // delay giữa các alert (ms)
                        const displayTime = 4000; // thời gian hiển thị mỗi alert (ms)

                        for (let i = 0; i < alerts.length; i += groupSize) {
                            const group = alerts.slice(i, i + groupSize);

                            group.forEach((el, index) => {
                                setTimeout(() => {
                                    el.style.display = 'block';
                                    el.classList.add('show');

                                    // Tự ẩn sau displayTime
                                    setTimeout(() => {
                                        el.classList.remove('show');
                                        el.classList.add('hide');
                                        setTimeout(() => el.remove(), 500); // xóa hẳn sau fade
                                    }, displayTime);
                                }, Math.floor(i / groupSize) * groupDelay);
                            });
                        }
                    });
                </script>




            </div>
            <div class="content" id="content">
                 <div id="flashContainer">
                    {{-- Blade chỉ xuất ra nội dung, JS sẽ điều khiển hiển thị --}}
                    @if (session('error_messages'))
                        @foreach (session('error_messages') as $err)
                            <div class="alert alert-danger alert-dismissible fade flashMessage" role="alert"
                                style="display:none;">
                                {!! $err !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endforeach
                    @endif

                    @if (session('success_messages'))
                        @foreach (session('success_messages') as $msg)
                            <div class="alert alert-success alert-dismissible fade flashMessage" role="alert"
                                style="display:none;">
                                {!! $msg !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endforeach
                    @endif
                    {{-- Hiển thị error nếu có --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show flashMessage" role="alert">
                            {!! session('error') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Hiển thị success nếu có --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show flashMessage" role="alert">
                            {!! session('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                </div>
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

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                document.querySelectorAll('.flashMessage').forEach(el => {
                    el.classList.remove('show');
                    el.classList.add('hide');
                    setTimeout(() => el.remove(), 500); // xóa hẳn sau khi fade
                });
            }, 5000); // 5 giây
        });
    </script> --}}


    <script>
        document.body.addEventListener('submit', e => {
            console.log("🟢 Submit form:", e.target);
            const btn = e.target.querySelector('button[type="submit"], input[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = 'Đang xử lý... ⏳';
            }
        }, true);
    </script>







</body>

</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chào mừng đến với Trung tâm Ngoại ngữ!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            margin: 30px auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .header {
            background-color: #007bff;
            color: white;
            text-align: center;
            border-radius: 10px 10px 0 0;
            padding: 15px 0;
        }
        .content {
            margin-top: 20px;
            line-height: 1.6;
        }
        .info-box {
            background: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
            text-align: center;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
            margin-top: 15px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Tài khoản của bạn đã được tạo!</h2>
        </div>
        <div class="content">
            <p>Xin chào <strong>{{ $user->name }}</strong>,</p>
            <p>Chào mừng bạn đến với <b>Trung tâm Ngoại ngữ </b>! Dưới đây là thông tin tài khoản của bạn:</p>

            <div class="info-box">
                <p><b>Email đăng nhập:</b> {{ $user->email }}</p>
                <p><b>Mật khẩu mặc định:</b>123456</p>
            </div>

            <p>Vui lòng đăng nhập vào hệ thống để đổi mật khẩu và cập nhật thông tin cá nhân của bạn:</p>
            <a href="{{ url('/login') }}" class="btn">Đăng nhập ngay</a>

            <p>Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ bộ phận hỗ trợ của trung tâm.</p>
        </div>
        <div class="footer">
            <p>© 2025 Trung tâm Ngoại ngữ . Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>

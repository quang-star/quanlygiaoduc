<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      padding: 20px;
      color: #333;
    }
    .container {
      background: white;
      max-width: 500px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h2 {
      color: #444;
    }
    p {
      font-size: 15px;
      line-height: 1.5;
    }
    .btn {
      display: inline-block;
      background: #007bff;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      margin-top: 15px;
    }
    .btn:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Xin chào {{ $user->name ?? 'bạn' }},</h2>
    <p>Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản của mình.</p>
    <p>Vui lòng nhấn vào nút dưới đây để đặt lại mật khẩu:</p>

    <a href="{{ $resetLink }}" class="btn">Đặt lại mật khẩu</a>

    <p style="margin-top:20px;">Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
    <hr>
    <p style="font-size:13px; color:#888;">Email này được gửi tự động, vui lòng không trả lời.</p>
  </div>
</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quên mật khẩu</title>
  <style>
    * {margin:0; padding:0; box-sizing:border-box; font-family:"Open Sans",sans-serif;}
    body {
      display:flex; align-items:center; justify-content:center;
      min-height:100vh;
      background:url("{{ asset('images/kirito.jpg') }}") no-repeat center center/cover;
      overflow:hidden; position:relative;
    }
    .overlay {
      position:absolute; top:0; left:0; width:100%; height:100%;
      background:rgba(0,0,0,0.45);
    }
    .wrapper {
      position:relative; z-index:2; width:380px;
      background:rgba(255,255,255,0.1);
      border-radius:12px; backdrop-filter:blur(12px);
      border:1px solid rgba(255,255,255,0.3);
      box-shadow:0 8px 25px rgba(0,0,0,0.25);
      padding:40px 35px; color:#fff;
      animation:fadeIn 0.6s ease-in-out;
    }
    @keyframes fadeIn {from{opacity:0; transform:translateY(-20px);} to{opacity:1; transform:translateY(0);}}
    h2 {text-align:center; margin-bottom:25px; font-weight:600; font-size:1.8rem;}
    .input-field {position:relative; margin:25px 0;}
    .input-field input {
      width:100%; height:45px; background:transparent;
      border:none; outline:none; border-bottom:2px solid rgba(255,255,255,0.5);
      color:#fff; font-size:16px; padding:10px 5px;
    }
    .input-field label {
      position:absolute; left:5px; top:12px; color:#ccc; font-size:15px;
      pointer-events:none; transition:0.3s ease;
    }
    .input-field input:focus+label,
    .input-field input:not(:placeholder-shown)+label {
      top:-20px; font-size:13px; color:#fff;
    }
    button {
      width:100%; background:#fff; color:#000; font-weight:600;
      border:none; border-radius:6px; padding:12px 0; cursor:pointer; font-size:16px;
      transition:0.3s;
    }
    button:hover {background:transparent; border:2px solid #fff; color:#fff;}
    .msg {text-align:center; font-size:14px; margin-bottom:15px;}
    .back {text-align:center; margin-top:10px;}
    .back a {color:#ccc; text-decoration:none;}
    .back a:hover {text-decoration:underline;}
  </style>
</head>
<body>
  <div class="overlay"></div>
  <div class="wrapper">
    <form method="POST" action="{{ url('/forgot-password') }}">
      @csrf
      <h2>Quên mật khẩu</h2>

      @if(session('error')) <p class="msg" style="color:#ff8080">{{ session('error') }}</p> @endif
      @if(session('success')) <p class="msg" style="color:#90ee90">{{ session('success') }}</p> @endif

      <div class="input-field">
        <input type="email" name="email" placeholder=" " required>
        <label>Nhập email đăng ký</label>
      </div>

      <button type="submit">Gửi liên kết đặt lại</button>

      <div class="back">
        <a href="{{ url('/login') }}">← Quay lại đăng nhập</a>
      </div>
    </form>
  </div>
</body>
</html>

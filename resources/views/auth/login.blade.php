<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đăng nhập</title>
 
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Open Sans", sans-serif;
    }

    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
       background: url("images/kirito.jpg") no-repeat center center/cover;
      overflow: hidden;
      position: relative;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.45);
    }

    .wrapper {
      position: relative;
      z-index: 2;
      width: 380px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
      padding: 40px 35px;
      color: #fff;
      animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
      font-size: 1.8rem;
    }

    .input-field {
      position: relative;
      margin: 25px 0;
    }

    .input-field input {
      width: 100%;
      height: 45px;
      background: transparent;
      border: none;
      outline: none;
      border-bottom: 2px solid rgba(255, 255, 255, 0.5);
      color: #fff;
      font-size: 16px;
      padding: 10px 5px;
    }

    .input-field label {
      position: absolute;
      left: 5px;
      top: 12px;
      color: #ccc;
      font-size: 15px;
      pointer-events: none;
      transition: 0.3s ease;
    }

    .input-field input:focus + label,
    .input-field input:not(:placeholder-shown) + label {
      top: -20px;
      font-size: 13px;
      color: #fff;
    }

    .options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 20px 0 30px;
      font-size: 14px;
    }

    .options label {
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .options input {
      accent-color: #fff;
      margin-right: 8px;
    }

    a {
      color: #fff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    button {
      width: 100%;
      background: #fff;
      color: #000;
      font-weight: 600;
      border: none;
      border-radius: 6px;
      padding: 12px 0;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s;
    }

    button:hover {
      background: transparent;
      border: 2px solid #fff;
      color: #fff;
    }

    .register {
      text-align: center;
      margin-top: 25px;
      font-size: 15px;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <div class="wrapper">
    <form action="{{ url('/login') }}" method="post">
        @csrf
          @if (session('error'))
            <div style="background-color: rgba(255,0,0,0.2); border: 1px solid red; color: #fff; padding: 10px; border-radius: 5px; text-align:center; margin-bottom:15px;">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div style="background-color: rgba(0,255,0,0.2); border: 1px solid limegreen; color: #fff; padding: 10px; border-radius: 5px; text-align:center; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif
      <h2>Đăng nhập</h2>

      <div class="input-field">
        <input type="text" name="email" placeholder=""  required />
        <label>Email đăng nhập</label>
      </div>

      <div class="input-field">
        <input type="password" name="password"  placeholder=" " required />
        <label>Mật khẩu</label>
      </div>

      <div class="options">
        <label><input type="checkbox" name="remember" /> Ghi nhớ</label>

        <a href="{{ url('forgot-password') }}">Quên mật khẩu?</a>
      </div>

      <button type="submit">Đăng nhập</button>

      <div class="register">
        {{-- <p>Chưa có tài khoản? <a href="#">Đăng ký ngay</a></p> --}}
      </div>
    </form>
  </div>
</body>
<script>
  setTimeout(() => {
    document.querySelectorAll('div[style*="background-color"]').forEach(el => {
      el.style.transition = "opacity 0.5s";
      el.style.opacity = 0;
      setTimeout(() => el.remove(), 500);
    });
  }, 3000); // 3 giây
</script>

</html>

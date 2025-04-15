<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập & Đăng Ký</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .auth-container {
            background-color: #fff;
            padding: 30px 40px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex; /* Sử dụng flexbox */
            gap: 40px; /* Khoảng cách giữa 2 form */
            max-width: 800px; /* Giới hạn chiều rộng */
            width: 90%;
            border-radius: 5px;
        }
        .form-section {
            flex: 1; /* Chia đều không gian cho 2 form */
        }
        .form-section h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 0.9em;
            color: #555;
        }
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Quan trọng để padding không làm tăng width */
        }
         .form-group input:focus {
            border-color: #5b9dd9;
            outline: none;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }
        .form-button {
            width: 100%;
            padding: 12px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 10px;
            transition: background-color 0.2s ease;
        }
        .form-button:hover {
            background-color: #333;
        }
        .error-message {
            color: red;
            font-size: 0.85em;
            margin-top: 5px;
            display: block; /* Hiển thị lỗi dưới input */
        }
         /* Hiển thị lỗi chung của form login */
        .login-error-container {
            color: red;
            background-color: #ffebee;
            border: 1px solid #ef9a9a;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 0.9em;
            text-align: center;
        }
         /* CSS cho dấu * bắt buộc */
        label abbr[title="required"] {
            color: red;
            text-decoration: none; /* Bỏ gạch chân mặc định */
            margin-left: 2px;
        }

        .admin-login-link {
    display: block;
    margin-top: 15px;
    text-align: center;
    font-size: 0.9em;
    text-decoration: none;
    color: #555;
    transition: color 0.2s ease;
}

.admin-login-link:hover {
    color: #000;
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="auth-container">

        {{-- Phần Đăng Nhập --}}
        <div class="form-section login-section">
            <h2>ĐĂNG NHẬP</h2>

            {{--ĐOẠN NÀY SẼ HIỂN THỊ ĐÚNG THÔNG BÁO TỪ CONTROLLER--}}
            @if ($errors->login->has('login_error'))
            <div class="login-error-container">
                {{ $errors->login->first('login_error') }}
            </div>
        @endif

            <form method="POST" action="{{ route('login.perform') }}">
                @csrf
                <div class="form-group">
                    <label for="login_email">Địa chỉ email <abbr title="required">*</abbr></label>
                    <input type="email" id="login_email" name="email" value="{{ old('email') }}" required autofocus>
                    {{-- Hiển thị lỗi của trường email trong 'login' error bag --}}
                    @error('email', 'login')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="login_password">Mật khẩu <abbr title="required">*</abbr></label>
                    <input type="password" id="login_password" name="password" required>
                     {{-- Hiển thị lỗi của trường password trong 'login' error bag --}}
                    @error('password', 'login')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="form-group"> --}}
                    {{-- Thêm checkbox Remember me nếu muốn --}}
                    {{-- <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ghi nhớ đăng nhập</label> --}}
                {{-- </div> --}}

                <button type="submit" class="form-button">Đăng Nhập</button>
            </form>
            <a href="{{ route('login') }}" class="admin-login-link">Đăng nhập bằng tài khoản admin</a>
        </div>

        {{-- Phần Đăng Ký --}}
        <div class="form-section register-section">
            <h2>ĐĂNG KÝ</h2>

             {{-- Hiển thị lỗi chung của form register (nếu có từ session) --}}
             @if(session('error'))
                <div class="login-error-container" style="background-color: #fff3e0; border-color: #ffcc80; color: #e65100;">
                    {{ session('error') }}
                </div>
             @endif
             {{-- Hoặc hiển thị tất cả lỗi validation của register bag nếu muốn --}}
             {{-- @if ($errors->register->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->register->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}

            <form method="POST" action="{{ route('register.perform') }}">
                @csrf
                 {{-- Sử dụng first_name và last_name --}}
                 <div class="form-group">
                    <label for="first_name">Tên <abbr title="required">*</abbr></label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                    @error('first_name', 'register')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                 <div class="form-group">
                    <label for="last_name">Họ <abbr title="required">*</abbr></label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                    @error('last_name', 'register')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="register_email">Địa chỉ email <abbr title="required">*</abbr></label>
                    <input type="email" id="register_email" name="email" value="{{ old('email') }}" required>
                     @error('email', 'register')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="register_password">Mật khẩu <abbr title="required">*</abbr></label>
                    <input type="password" id="register_password" name="password" required autocomplete="new-password">
                     @error('password', 'register')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Xác nhận mật khẩu <abbr title="required">*</abbr></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    {{-- Lỗi confirmed của password sẽ hiển thị ở @error('password') trên --}}
                </div>

                <button type="submit" class="form-button">Đăng Ký</button>
            </form>
        </div>

    </div>
</body>
</html>
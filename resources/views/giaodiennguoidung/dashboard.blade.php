<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
     <style>
        body { font-family: sans-serif; padding: 20px; }
        .logout-button {
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        .logout-button:hover { background-color: #c82333; }
        .success-message {
            color: green;
            background-color: #e9f5e9;
            border: 1px solid #a3d9a5;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    {{-- Hiển thị thông báo thành công (ví dụ: sau khi đăng ký) --}}
    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <h1>Chào mừng bạn đến Dashboard, {{ $userFullName }}!</h1>
    <p>Đây là khu vực dành cho thành viên đã đăng nhập.</p>

    {{-- Form đăng xuất --}}
    <form method="POST" action="{{ route('logout') }}" style="margin-top: 30px;">
        @csrf
        <button type="submit" class="logout-button">Đăng Xuất</button>
    </form>

</body>
</html>
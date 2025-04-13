<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
   /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

/* Banner Container */
.baner-container {
    width: 100%;
    height: 150px; /* Độ cao vừa phải cho banner */
    overflow: hidden;
}

.baner-container img {
    width: 100%;
    height: auto;
}

/* Header Styles */
.header {
    background-color: #d4edda; /* Màu xanh lá cây nhạt hơn */
    color: white;
    padding: 20px;
    display: flex; /* Sử dụng flexbox để dễ dàng canh chỉnh */
    justify-content: space-between; /* Căn giữa khoảng cách giữa các phần tử */
    align-items: center; /* Căn chỉnh theo chiều dọc */
}

.logo-container {
    flex: 0 0 auto; /* Để logo không thay đổi kích thước */
}

.logo-container img {
    max-width: 80px; /* Kích thước logo vừa phải */
    height: auto;
}

.header-title {
    margin: 0 20px; /* Khoảng cách giữa tiêu đề và logo */
    font-size: 24px;
    font-weight: bold; /* In đậm chữ "ADMIN OOPS" */
    color: red; /* Màu chữ đỏ */
    margin-bottom: 50px;
}

/* User Info Styling */
.user-info {
    display: flex; /* Sử dụng flexbox để căn chỉnh ngang */
    align-items: center; /* Căn giữa theo chiều dọc */
}

.admin-id {
    font-size: 14px;
    margin-right: 10px; /* Khoảng cách giữa tên người dùng và nút đăng xuất */
    color: black; /* Màu chữ cho tên người dùng */
    background-color: #b3d1ff; /* Màu nền khung cho tên người dùng */
    border: 1px solid #ced4da; /* Viền cho khung tên người dùng */
    border-radius: 5px; /* Bo góc cho khung */
    padding: 8px 15px; /* Padding cho khung tên người dùng */
}

.btn-danger {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 8px 15px; /* Điều chỉnh padding để vừa hơn */
    cursor: pointer;
    border-radius: 5px;
}

.btn-danger:hover {
    background-color: #c82333;
}

/* Main Container */
.main-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 20px;
    margin-top: 50px;
}

/* Card Styles */
.card {
    background-color: #ff6f61; /* Màu hồng cho các thẻ */
    border: none;
    border-radius: 10px;
    margin: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 250px;
    cursor: pointer;
    transition: transform 0.2s;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.card a {
    text-decoration: none;
    color: white; /* Màu chữ trắng */
    font-size: 18px;
    font-weight: bold; /* In đậm chữ */
}

/* Responsive Design */
@media (max-width: 600px) {
    .main-container {
        flex-direction: column;
        align-items: center;
    }

    .card {
        width: 90%;
    }
}
    </style>
</head>
<body>

<div class="header">
<div class="logo-container">
        <a href="{{ route('admin.index') }}"> <!-- Thêm thẻ <a> để tạo đường dẫn cho logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </a>
    </div>
    <div class="left-section">
        <a href="{{ route('admin.index') }}" class="header-title">ADMIN OOPS</a> <!-- Thêm thẻ <a> để tạo đường dẫn -->
    </div>
    <div class="user-info">
        <div class="admin-id">{{ session('username', 'khách') }}</div>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Đăng Xuất</button>
        </form>
    </div>
</div>
    

    
   
</body>
</html>
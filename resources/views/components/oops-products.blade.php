<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{$title}}</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    
  <script src="https://code.jquery.com/jquery-3.7.1.js" ></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap4.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap4.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
   /* General Styles */
/* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4; /* Màu nền cho toàn bộ trang */
    margin: 0;
    padding: 0;
}

/* Header Styles */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #d4edda; /* Màu nền header */
    padding: 10px;
    border-bottom: 2px solid #007bff; /* Đường viền dưới */
}

.left-section {
    display: flex;
    align-items: center;
}

.header-title {
    font-size: 24px;
    font-weight: bold;
    color: #ff4d4d; /* Màu chữ tiêu đề */
    margin-right: 20px; /* Khoảng cách giữa tiêu đề và logo */
}

/* Logo Styles */
.logo-container img {
    max-width: 80px; /* Kích thước logo */
    height: auto;
}

/* Danh sách sản phẩm */
.danh-sach {
    font-size: 40px; /* Kích thước danh sách sản phẩm */
    color: #FF8C00; /* Màu cam đậm */
    font-weight: bold; /* In đậm chữ */
    flex: 1; /* Để danh sách sản phẩm chiếm không gian còn lại */
    text-align: center; /* Căn giữa nội dung */
}

/* Button Styles */
.btn {
    background-color: #28a745; /* Màu xanh lá cây cho nút */
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none; /* Xóa gạch chân */
}

.btn:hover {
    background-color: #218838; /* Màu khi hover */
}

/* Input Search Styles */
input[type="text"] {
    width: 300px; /* Kích thước rộng hơn cho ô tìm kiếm */
    padding: 10px; /* Khoảng cách bên trong */
    border: 1px solid #ccc; /* Đường viền cho ô tìm kiếm */
    border-radius: 4px; /* Bo góc cho ô tìm kiếm */
    margin-left: 10px; /* Khoảng cách giữa chữ "Search" và ô input */
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ cho ô input */
}

/* Table Styles */
.table-responsive {
    margin: 20px auto; /* Giúp căn giữa bảng */
    background-color: white;
    border-radius: 8px; /* Bo góc cho bảng */
    overflow: auto; /* Hỗ trợ cuộn dọc mà không bị kéo ngang */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Đổ bóng cho bảng */
    max-width: 100%; /* Đảm bảo không vượt quá chiều rộng của khung cha */
    width: 90%; /* Chiều rộng tối đa cho bảng */
}

.table {
    width: 100%;
    border-collapse: collapse; /* Gộp các viền */
}

.table th, .table td {
    padding: 15px;
    text-align: center; /* Căn giữa cho chữ */
    border-bottom: 1px solid #ddd; /* Viền giữa các hàng */
}

.table th {
    background-color: #ffb3c1; /* Màu hồng nhạt cho tiêu đề bảng */
    color: #000; /* Màu chữ đen cho tiêu đề */
    vertical-align: middle; /* Canh giữa theo chiều dọc */
}

.table tbody tr:hover {
    background-color: #f1f1f1; /* Màu nền khi hover trên row */
}

.btn-group {
    display: flex; /* Dùng flexbox cho nhóm nút */
}

/* Responsive Design */
@media (max-width: 600px) {
    .header {
        flex-direction: column; /* Chuyển thành cột trên màn hình nhỏ */
        align-items: flex-start; /* Căn trái */
    }
    .danh-sach {
        font-size: 18px; /* Giảm kích thước chữ trên màn hình bé */
    }
    .table {
        font-size: 12px; /* Giảm kích thước chữ trong bảng */
    }
}
  </style>
  </head>
<body>
<div class="header">
    <div class="left-section">
        <a href="{{ route('admin.index') }}" class="header-title">ADMIN OOPS</a> <!-- Thêm thẻ <a> để tạo đường dẫn -->
    </div>
    <div class="danh-sach">DANH SÁCH SẢN PHẨM</div>
    <div class="logo-container">
        <a href="{{ route('admin.index') }}"> <!-- Thêm thẻ <a> để tạo đường dẫn cho logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </a>
    </div>
</div>

        
        
</body>
</html>


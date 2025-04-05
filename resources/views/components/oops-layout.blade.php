<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa; /* Màu nền nhẹ cho body */
        }
        /* Bọc toàn bộ trang để giới hạn chiều rộng và căn giữa */
        .page-wrapper {
             max-width: 1000px; /* Chiều rộng tối đa */
             margin: 0 auto;    /* Căn giữa */
             background-color: #ffffff; /* Nền trắng cho nội dung */
             box-shadow: 0 0 15px rgba(0,0,0,0.05);
             min-height: 100vh; /* Chiều cao tối thiểu bằng màn hình */
             display: flex;
             flex-direction: column;
        }
        header {
            /* Phần header không cần style riêng nhiều nếu chỉ chứa banner và nav */
        }
        .page-banner {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 100%;
            height: auto;
        }
        .navbar.custom-navbar {
            background-color: #ff5850; /* Màu đỏ cam đặc trưng */
            font-weight: bold;
            border-radius: 0; /* Bỏ bo góc nếu nằm trong wrapper */
        }
        .navbar.custom-navbar .nav-item .nav-link {
            color: #fff !important;
            padding: 0.75rem 1rem; /* Tăng padding cho dễ click */
            transition: background-color 0.2s ease;
        }
         .navbar.custom-navbar .nav-item .nav-link:hover,
         .navbar.custom-navbar .nav-item.active .nav-link {
            color: #fff !important; /* Giữ màu trắng khi active/hover */
            background-color: rgba(0,0,0,0.1); /* Nền tối nhẹ khi active/hover */
         }
         /* Style cho user dropdown */
         .navbar.custom-navbar .dropdown-toggle::after {
            color: #fff; /* Màu mũi tên dropdown */
         }
         .dropdown-menu {
             border-radius: 0 0 .25rem .25rem; /* Bo góc dưới dropdown */
             border: 1px solid rgba(0,0,0,.1);
         }
         .dropdown-menu .dropdown-item {
            color: black !important; /* Màu chữ item mặc định */
            padding: .5rem 1.5rem; /* Điều chỉnh padding */
         }
         .dropdown-menu .dropdown-item:hover,
         .dropdown-menu .dropdown-item:focus,
         .dropdown-menu .dropdown-item.active {
            color: #16181b !important; /* Màu chữ đậm hơn khi hover/active */
            background-color: #f8f9fa; /* Màu nền hover */
         }
         .dropdown-item.btn-logout { /* Nút logout trong dropdown */
            border: none; background: none; cursor: pointer; width: 100%;
            text-align: left; padding: .5rem 1.5rem; /* Đồng bộ padding */
             color: black !important; display: block;
         }
         .dropdown-item.btn-logout:hover, .dropdown-item.btn-logout:focus {
              color: #16181b !important; background-color: #f8f9fa;
         }

        /* Khu vực nội dung chính */
        main.main-container {
            flex-grow: 1; /* Cho phép main content chiếm không gian còn lại */
            padding: 20px 15px;
        }

        /* Footer */
        footer.page-footer {
            text-align: center;
            padding: 20px 15px;
            background-color: #e9ecef;
            margin-top: auto; /* Đẩy footer xuống dưới cùng nếu nội dung ngắn */
            /* border-top: 1px solid #dee2e6; */
        }
        footer.page-footer h5 { color: #495057; margin-bottom: 10px; }
        footer.page-footer p, footer.page-footer a { color: #6c757d; font-size: 0.9em; }
        footer.page-footer a:hover { color: #343a40; text-decoration: none; }

        /* CSS cho product grid (nếu trang chủ hay trang khác cần) */
        .product-grid {
             display: grid;
             grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
             gap: 15px;
         }
         .product-item {
             border: 1px solid #eee; padding: 10px; text-align: center;
             background-color: #fff; transition: box-shadow 0.2s ease-in-out;
         }
         .product-item:hover { box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
         .product-item img { max-width: 100%; height: 150px; object-fit: contain; margin-bottom: 10px; }
         .product-item h6 { font-size: 0.95em; margin-bottom: 5px; height: 40px; overflow: hidden; }
         .product-item .price { font-weight: bold; color: #dc3545; margin-bottom: 10px; }
         .product-item .btn { font-size: 0.85em; }
    </style>
</head>
<body>
    <header>
    <img src="{{ asset('images/banner.jpg') }}" alt="Website Banner" class="page-banner img-fluid">
        {{-- Navigation Menu --}}
        <nav class="navbar navbar-light navbar-expand-sm custom-navbar">
            <div class='container d-flex justify-content-between'>
                {{-- Left Navigation (Brands) --}}
                <ul class="navbar-nav ">
                    <li class="nav-item {{ Request::is('/') || Request::is('trangchu') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">Trang chủ</a> {{-- Nên dùng route name --}}
                    </li>
                    <li class="nav-item {{ Request::is('trangchu/phone_brands/1*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('trangchu/phone_brands/1') }}">Apple</a>
                    </li>
                    <li class="nav-item {{ Request::is('trangchu/phone_brands/2*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('trangchu/phone_brands/2') }}">Oppo</a>
                    </li>
                    <li class="nav-item {{ Request::is('trangchu/phone_brands/3*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('trangchu/phone_brands/3') }}">Redmi</a>
                    </li>
                    <li class="nav-item {{ Request::is('trangchu/phone_brands/4*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('trangchu/phone_brands/4') }}">Samsung</a>
                    </li>
                    {{-- Thêm các link khác nếu cần --}}
                </ul>

                {{-- Right Navigation (User Auth) --}}
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        {{-- Link đến trang đăng nhập / đăng ký --}}
                        <a class="nav-link" href="{{ route('login_register.show') }}"> {{-- Thay 'login_register.show' bằng tên route thực tế --}}
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập / Đăng ký
                        </a>
                    </li>
                    @else
                    {{-- User Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i> Chào, {{ Auth::user()->first_name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            {{-- Link đến trang tài khoản (trang này) --}}
                            <a class="dropdown-item {{ Request::routeIs('account.edit') ? 'active' : '' }}" href="{{ route('account.edit') }}"> {{-- Đặt tên route là 'account.edit' --}}
                                Tài khoản của tôi
                            </a>
                            {{-- Thêm các link khác nếu cần (VD: Đơn hàng của tôi) --}}
                            {{-- <a class="dropdown-item" href="#">Đơn hàng của tôi</a> --}}
                            <div class="dropdown-divider"></div>
                            {{-- Logout Form --}}
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="dropdown-item btn-logout">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </header>

    <main class="main-container">
        {{$slot}}
    </main>

    <footer class="page-footer">
        <div class="container">
            <div class='row'>
                <div class='col-md-4 mb-3 mb-md-0'>
                    <h5>TRỤ SỞ</h5>
                    <p>123 Đường ABC, Quận 1<br>TP. Hồ Chí Minh, Việt Nam</p>
                </div>
                <div class='col-md-4 mb-3 mb-md-0'>
                    <h5>THÔNG TIN CHUNG</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Về chúng tôi</a></li>
                        <li><a href="#">Liên hệ</a></li>
                        <li><a href="#">Điều khoản dịch vụ</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                    </ul>
                </div>
                <div class='col-md-4'>
                    <h5>BẢN ĐỒ</h5>
                    {{-- Thay bằng iframe Google Maps hoặc ảnh bản đồ --}}
                    <p>[Nhúng bản đồ vào đây]</p>
                    {{-- <iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy"></iframe> --}}
                </div>
            </div>
            <div class="row mt-3 pt-3 border-top">
                 <div class="col text-muted text-center">
                     © {{ date('Y') }} Tên Cửa Hàng Của Bạn. Bảo lưu mọi quyền.
                 </div>
            </div>
        </div>
    </footer>
</body>
</html>

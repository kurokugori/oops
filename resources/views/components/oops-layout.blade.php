<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .page-banner {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 100%; /* Hoặc kích thước banner của bạn */
            height: auto;
            /* margin-bottom: 15px; */ /* Khoảng cách dưới banner nếu cần */
        }

        .navbar.custom-navbar { /* Navbar chính màu đỏ */
            background-color: #ff5850;
            max-width: 100%;
            font-weight: bold;
            margin: 0 auto; /* Căn giữa navbar */
            border-radius: 0 0 5px 5px; /* Bo góc dưới nếu muốn */
        }

        .navbar.custom-navbar .nav-item .nav-link {
            color: #fff !important; /* Màu chữ menu */
        }
         .navbar.custom-navbar .nav-item .nav-link:hover,
         .navbar.custom-navbar .nav-item.active .nav-link {
            color: #eee !important; /* Màu chữ khi hover hoặc active */
            /* background-color: rgba(0,0,0,0.1); */ /* Nền nhẹ khi active/hover */
         }

        .main-container { /* Vùng nội dung chính */
            width: 100%; /* Chiếm toàn bộ chiều rộng bên trong */
            max-width: 90%; /* Giới hạn chiều rộng tối đa */
            margin: 20px auto; /* Căn giữa và tạo khoảng cách trên/dưới */
            min-height: 450px; /* Chiều cao tối thiểu */
            background-color: #ffffff; /* Nền trắng cho nội dung */
            padding: 20px; /* Padding bên trong vùng nội dung */
            border-radius: 5px; /* Bo góc nhẹ */
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); /* Đổ bóng nhẹ */
        }

        /* Dropdown menu styling */
        .dropdown-menu .dropdown-item {
            color: black !important;
        }
        .dropdown-menu .dropdown-item:hover,
        .dropdown-menu .dropdown-item:focus,
        .dropdown-menu .dropdown-item.active { /* Thêm active state */
            color: #333 !important;
            background-color: #f8f9fa;
        }
        .dropdown-item.btn-logout { /* Style nút logout */
            border: none; background: none; cursor: pointer; width: 100%;
            text-align: left; padding: .25rem 1.5rem; color: black !important; display: block;
        }
        .dropdown-item.btn-logout:hover, .dropdown-item.btn-logout:focus {
             color: #333 !important; background-color: #f8f9fa;
        }

        .page-footer { /* Footer */
            text-align: center;
            padding: 20px 0;
            background-color: #e9ecef; /* Màu nền footer */
            margin-top: 30px;
            /* border-top: 1px solid #dee2e6; */
            max-width: 100%; /* Giới hạn chiều rộng giống navbar */
            margin-left: auto;
            margin-right: auto;
            border-radius: 5px 5px 0 0; /* Bo góc trên nếu muốn */
        }
        .page-footer h5 {
             color: #495057;
             margin-bottom: 10px;
        }
        .page-footer p, .page-footer a {
             color: #6c757d;
             font-size: 0.9em;
        }
         .page-footer a:hover {
            color: #343a40;
            text-decoration: none;
         }
    </style>
</head>
<body>
    <header>
    <img src="{{ asset('images/banner.jpg') }}" alt="Website Banner" class="page-banner img-fluid">
        {{-- Navigation Menu --}}
        <nav class="navbar navbar-light navbar-expand-sm custom-navbar">
            <div class='container d-flex justify-content-between'>
                {{-- Left Navigation (Brands) --}}
                <ul class="navbar-nav">
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

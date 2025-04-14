<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" ></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto...lay=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa; /* Màu nền nhẹ cho body */
        }
        /* CSS cho thanh tìm kiếm */
        .top-search-bar {
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        .top-search-bar input.form-control {
            border-radius: 20px;
        }
        .top-search-bar button.btn {
            border-radius: 20px;
        }
        .logo-container {
            width: 180px; /* Chiều rộng cố định cho container logo */
            height: 60px; /* Chiều cao cố định cho container logo */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        .logo {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* giữ nguyên tỉ lệ ảnh */
        }
        .search-container {
            flex: 1; /* Cho phép search form mở rộng để lấp đầy không gian còn lại */
            max-width: 800px;
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
        /* CSS cho banner */
        .carousel-item img {
            max-width: 100%;
            height: auto;
            max-height: 500px; /* Điều chỉnh chiều cao tối đa phù hợp với thiết kế */
            object-fit: cover; /* Đảm bảo ảnh che đủ không gian nhưng không bị méo */
        }

        /* Tùy chọn: Làm cho indicators (chấm tròn) dễ nhìn hơn */
        .carousel-indicators li {
            background-color: rgba(255, 255, 255, 0.5);
            height: 10px;
            width: 10px;
            border-radius: 50%;
        }
        .carousel-indicators .active {
            background-color: white;
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
        /*CSS cho ảnh sản phẩm*/
        .product-frame {
            border: 6px solid  #ffffff;        /* Viền trắng như mẫu */
            background-color:rgb(228, 194, 194);        /* Màu khung  */
            padding: 10px;                    /* Tạo khoảng cách giữa ảnh và khung */
            border-radius: 20px;              /* Bo tròn khung */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); /* Đổ bóng nhẹ */
            display: inline-block;
        }

        .product-image {
            width: 180px;
            height: 180px;
            border-radius: 20px;              /* Bo tròn viền ảnh bên trong */
            display: block;
        }

        .product-text {
            position: static; /* không cần position: absolute nữa */
            text-align: center;
            color: #ff5850;
            font-family: 'Arial', sans-serif;
        }

        .product-text h5 {
            font-size: 1.5em;
            font-weight: bold;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgb(0, 106, 255),rgb(198, 43, 255));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .product-name {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            height: 3em;
            font-weight: bold;
            font-size: 15px;
            text-align: center;
            margin-top: 8px;
            margin-left:20px;
            margin-right:20px;
        }

        /* Footer */
        footer.page-footer {
            text-align: center;
            padding: 20px 15px;
            background-color: #e9ecef;
            margin-top: auto; /* Đẩy footer xuống dưới cùng nếu nội dung ngắn */
            /* border-top: 1px solid #dee2e6; */
        }
        footer.page-footer h5 { color:rgb(240, 36, 73); margin-bottom: 10px; }
        footer.page-footer p, footer.page-footer a { color:rgb(124, 54, 75); font-size: 0.9em; }
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

        .product-table 
        {
            border-collapse: collapse;
            width: 70%;
            margin: 0 auto;
        }
    </style>
</head>
<script>
    $(document).ready(function(){
        // Thay đổi thời gian chuyển đổi thành 5 giây (5000ms)
        $('#bannerCarousel').carousel({
            interval: 5000
        });
    });
</script>
<body>
    <div class="top-search-bar bg-light py-2 border-bottom">
    <div class="container d-flex align-items-center">
                <div class="logo-container">
                    <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo"></a>
                </div>
                <div class="search-container">
                    <form action="{{ route('search') }}" method="GET" class="d-flex">
                        <input type="text" name="query" class="form-control mr-2 flex-grow-1" placeholder="Tìm kiếm sản phẩm...">
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
    </div>
    <header>
        {{-- Navigation Banner --}}
            <div id="bannerCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators (chấm tròn điều hướng) -->
                <ol class="carousel-indicators">
                    <li data-target="#bannerCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#bannerCarousel" data-slide-to="1"></li>
                    <li data-target="#bannerCarousel" data-slide-to="2"></li>
                </ol>
            
                <!-- Slides (các ảnh banner) -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/banner1.jpg') }}" class="d-block w-100" alt="Banner 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/banner2.jpg') }}" class="d-block w-100" alt="Banner 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/banner3.jpg') }}" class="d-block w-100" alt="Banner 3">
                    </div>
                </div>
            
                <!-- Điều khiển trước/sau -->
                <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#bannerCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        {{-- Navigation Menu --}}
        <nav class="navbar navbar-light navbar-expand-sm custom-navbar">
            <div class='container d-flex justify-content-between'>
                {{-- Left Navigation (Brands) --}}
                <ul class="navbar-nav ">
                    <li class="nav-item {{ Request::is('/') || Request::is('trangchu') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('trangchu') }}" >Trang chủ</a> {{-- Nên dùng route name --}}
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
<!-- biểu tượng giỏ hàng-->
            <div style='color:white;position:relative' class='mr-2'>
                <div style='width:20px; height:20px;background-color:#23b85c; font-size:12px; border:none;
                        border-radius:50%; position:absolute;right:2px;top:-2px;display:flex;align-items:center;justify-content:center;' id='cart-number-product'>
                @if (session('cart'))
                    {{ count(session('cart')) }}
                @else
                    0
                @endif
                </div>
                <a href="{{route('order')}}" style='cursor:pointer;color:white;'>
                    <i class="fa fa-cart-arrow-down fa-2x mr-2 mt-3" aria-hidden="true"></i>
                </a>
            </div>
 <!-- kết thúc biểu tượng giỏ hàng-->
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
                    <h5>📍 TRỤ SỞ</h5>
                    <p>56 Đường Hoàng Diệu 2, Quận Thủ Đức<br>TP. Hồ Chí Minh, Việt Nam</p>
                </div>
                <div class='col-md-4 mb-3 mb-md-0'>
                    <h5>ℹ️ THÔNG TIN CHUNG</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Về chúng tôi</a></li>
                        <li><a href="#">Liên hệ</a></li>
                        <li><a href="#">Điều khoản dịch vụ</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                    </ul>
                </div>
                <div class='col-md-4'>
                    <h5>🗺️ BẢN ĐỒ</h5>
                    <div class="map-section">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.456537789779!2d106.76704667502126!3d10.852682357754236!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175271b869b6015%3A0xd06e137ef646e4fa!2zNTYgSG_DoG5nIERp4buHIDIgLCBMaW5oIFRyaeG7g3UsIFRow7RuZyBUaOG7pywgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1713082170662!5m2!1svi!2s" 
                                width="95%" 
                                height="120" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">>
                            </iframe>
                    </div>
            </div>
            </div>
            <div class="row mt-3 pt-3 border-top">
                 <div class="col text-muted text-center">
                     © {{ date('Y') }} OOPS - PROTECT YOUR PHONE
                 </div>
            </div>
        </div>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="vi"> {{-- Đặt ngôn ngữ phù hợp --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Lấy title từ controller hoặc đặt mặc định --}}
    <title>{{ $title ?? 'Thông tin tài khoản' }}</title>

    {{-- === CSS === --}}
    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    {{-- Font Awesome CSS (Cho các icon) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* === CSS Layout Cơ Bản (Giống layout gốc) === */
        body {
             /* background-color: #f8f9fa; */ /* Optional: Màu nền nhẹ nhàng */
        }

        .page-banner {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 1000px; /* Hoặc kích thước banner của bạn */
            height: auto;
            /* margin-bottom: 15px; */ /* Khoảng cách dưới banner nếu cần */
        }

        .navbar.custom-navbar { /* Navbar chính màu đỏ */
            background-color: #ff5850;
            max-width: 1000px;
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
            max-width: 1000px; /* Giới hạn chiều rộng tối đa */
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
            max-width: 1000px; /* Giới hạn chiều rộng giống navbar */
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

        /* === CSS Cụ Thể Cho Form Tài Khoản === */
        .form-control:disabled, .form-control[readonly] {
             background-color: #e9ecef; /* Màu nền input bị khóa */
             cursor: not-allowed; /* Con trỏ chuột */
             opacity: 0.8;
        }
        .text-danger { /* Dấu * màu đỏ */
             /* Bootstrap đã định nghĩa, nhưng có thể ghi đè nếu cần */
        }
        .invalid-feedback { /* Thông báo lỗi của Bootstrap */
             font-size: 0.8em;
        }
        .form-text.text-muted { /* Gợi ý dưới input */
            font-size: 0.85em;
        }
        .btn-primary { /* Nút Lưu */
            background-color: #007bff; /* Màu nút chính của Bootstrap */
            border-color: #007bff;
        }
         .btn-secondary { /* Nút Quay lại */
            background-color: #6c757d;
            border-color: #6c757d;
         }
         .btn-warning { /* Nút Đổi mật khẩu */
             background-color: #ffc107;
             border-color: #ffc107;
             color: #212529; /* Màu chữ cho nút vàng */
         }

    </style>
</head>
<body>
    {{-- === HEADER (Banner + Menu) === --}}
    <header style='text-align:center;'>
        {{-- Banner --}}
        <img src="{{ asset('images/banner.jpg') }}" alt="Website Banner" class="page-banner img-fluid"> {{-- Thêm img-fluid cho responsive --}}

        {{-- Navigation Menu --}}
        <nav class="navbar navbar-light navbar-expand-sm custom-navbar">
            <div class='container-fluid p-0 d-flex justify-content-between'>
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

    {{-- === MAIN CONTENT AREA === --}}
    <main class="main-container">
        {{-- Nội dung form tài khoản bạn đã cung cấp --}}
        <div class="container my-4"> {{-- Không cần container nữa vì main-container đã có padding --}}
            <h1 class="mb-4 text-center">Thông Tin Tài Khoản</h1> {{-- Căn giữa tiêu đề --}}

            {{-- Hiển thị thông báo thành công hoặc lỗi --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            {{-- @if ($errors->any()) ... @endif --}}


            <form action="{{ route('account.update') }}" method="POST"> {{-- Đặt tên route là 'account.update' --}}
                @csrf {{-- Bảo vệ CSRF --}}
                @method('PUT') {{-- Phương thức HTTP là PUT để cập nhật --}}

                <div class="row">
                    {{-- Cột thông tin cá nhân --}}
                    <div class="col-md-6">
                        <h4 class="mb-3 border-bottom pb-2">Thông tin cá nhân</h4>
                        <div class="form-group">
                            <label for="first_name">Tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                id="first_name" name="first_name"
                                value="{{ old('first_name', $user->first_name) }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name">Họ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                id="last_name" name="last_name"
                                value="{{ old('last_name', $user->last_name) }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Địa chỉ Email</label>
                            {{-- Email không cho sửa --}}
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly disabled>
                            <small class="form-text text-muted">Bạn không thể thay đổi địa chỉ email.</small>
                        </div>

                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            {{-- Cho phép sửa số điện thoại --}}
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" name="phone" placeholder="Nhập số điện thoại của bạn"
                                value="{{ old('phone', $user->phone) }}">
                                {{-- Có thể thêm validation 'nullable', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10' trong controller --}}
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Cột Địa chỉ / Thông tin giao hàng --}}
                    <div class="col-md-6">
                        <h4 class="mb-3 border-bottom pb-2">Địa chỉ (Giao hàng mặc định)</h4>
                        <div class="form-group">
                            <label for="address">Địa chỉ chi tiết</label>
                            {{-- Cho phép sửa địa chỉ --}}
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" rows="5"
                                    placeholder="Ví dụ: Số 123, Đường ABC, Phường XYZ, Quận 1, TP. Hồ Chí Minh">{{ old('address', $user->address) }}</textarea>
                                    {{-- Có thể thêm validation 'nullable', 'string', 'max:1000' trong controller --}}
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Vui lòng nhập địa chỉ đầy đủ để giao hàng chính xác.</small>
                        </div>

                        {{-- Có thể thêm các trường Tỉnh/Thành, Quận/Huyện nếu muốn phân tách --}}
                        {{-- <div class="form-group">
                            <label for="city">Tỉnh/Thành phố</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $user->city) }}">
                        </div> --}}

                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                    {{-- Nút Lưu thay đổi --}}
                    <button class="btn btn-primary btn-lg" type="submit">
                        <i class="fas fa-save mr-2"></i>Lưu thay đổi
                    </button>
                    {{-- Nút Quay lại trang chủ --}}
                     <a href="{{ route('home') }}" class="btn btn-secondary">
                         <i class="fas fa-arrow-left mr-1"></i>Quay lại trang chủ
                     </a>
                </div>

            </form>

            
            </div>

        </div> {{-- Đóng .container bên trong main --}}
    </main>

    {{-- === FOOTER === --}}
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

    {{-- === JAVASCRIPT === --}}
    {{-- jQuery first, then Popper.js, then Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

     {{-- Optional: Script tự động đóng alert --}}
     <script>
        $(document).ready(function() {
            // Đợi 5 giây rồi làm mờ và ẩn alert
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });
            }, 5000); // 5000 milliseconds = 5 giây

            // Kích hoạt tooltip nếu bạn dùng (ví dụ: cho nút ?)
            // $('[data-toggle="tooltip"]').tooltip();
        });
     </script>

</body>
</html>
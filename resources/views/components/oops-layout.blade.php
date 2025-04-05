<!DOCTYPE html>
<html>
    <head>
        <title>{{$title}}</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            /* Định dạng màu nền và màu chữ của menu */
            .navbar {
                background-color: #ff5850;
                max-width:1000px;
                font-weight:bold;
                margin:0 auto;

            }
            .nav-item a
            {
                color: #fff!important;
            }

            .list-oops
            {
                display:grid;
                grid-template-columns:repeat(5,20%);
            }
            .oops
            {
            
                margin:10px;
                text-align:center;
            }
            /* Dropdown menu item styling */
            .dropdown-menu .dropdown-item {
                color: black !important; /* Default color for dropdown items */
            }
            .dropdown-menu .dropdown-item:hover,
            .dropdown-menu .dropdown-item:focus {
                color: #333 !important; /* Màu chữ khi hover/focus */
                background-color: #f8f9fa;
            }

            /* Style the logout button to look like a regular dropdown item */
            .dropdown-item.btn-logout {
                border: none;
                background: none;
                cursor: pointer;
                width: 100%;
                text-align: left;
                padding: .25rem 1.5rem; /* Match Bootstrap's dropdown item padding */
                color: black !important; /* <--- Đảm bảo nút logout cũng màu đen */
                display: block;
            }
            .dropdown-item.btn-logout:hover,
            .dropdown-item.btn-logout:focus {
                color: #333 !important; /* Màu chữ nút logout khi hover/focus */
                background-color: #f8f9fa;
            }
        </style>
    </head>
    <body>
        <header style='text-align:center'>
            <img src="{{asset('images/banner.jpg')}}" width="1000px">
            <nav class="navbar navbar-light navbar-expand-sm">
                <div class='container-fluid p-0'>
                    <div class='col-9 p-0'>
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{url('trangchu')}}">Trang chủ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('trangchu/phone_brands/1')}}">Apple</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('trangchu/phone_brands/2')}}">Oppo</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('trangchu/phone_brands/3')}}">Redmi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('trangchu/phone_brands/4')}}">Samsung</a>
                                </li>
                    </div>
                    <div class="ml-auto">
                            <ul class="navbar-nav">
                                @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login_register.show') }}">
                                        <i class="fas fa-sign-in-alt"></i> Đăng nhập / Đăng ký
                                    </a>
                                </li>
                                @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-user"></i> Chào, {{ Auth::user()->first_name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="{{ route('account.edit') }}">Tài khoản của tôi</a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item" style="border: none; background: none; cursor: pointer; width: 100%; text-align: left; padding: .25rem 1.5rem;">
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
        <main style="width:1000px; margin:2px auto;">
            <div class='row'>
                <div class='col-12'>
                   {{$slot}}
                </div>
            </div>
        </main>
        <footer>
            <div class='row' style='text-align:center'>
                <div class='col-4'>TRỤ SỞ</div>
                <div class='col-4'>THÔNG TIN CHUNG</div>
                <div class='col-4'>BẢN ĐỒ</div>
            </div>
        </footer>
    </body>
</html>
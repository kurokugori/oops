<x-oops-layout>
    <x-slot name='title'>  
        Thông tin tài khoản 
    </x-slot> 

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    {{-- Font Awesome CSS (Cho các icon) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
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

    {{-- === MAIN CONTENT AREA === --}}
    <div>
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

</x-oops-layout>
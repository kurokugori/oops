<x-oops-layout>
    <x-slot name="title">Thông tin đơn hàng</x-slot>

    <div style="display: flex; justify-content: center; gap: 40px; align-items: flex-start; flex-wrap: wrap; margin-top: 20px;">
        <!-- Bên trái: Danh sách sản phẩm -->
        <div style="flex: 1; min-width: 300px;">
            <h4 class="text-primary text-center mb-3">Sản phẩm đã chọn</h4>
            @php
                $selected_products = session('selected_products', []);
                $quantities = session('quantities', []);
                $products = DB::table('products')->whereIn('id', $selected_products)->get();
                $tongTien = 0;
            @endphp

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        @php
                            $qty = $quantities[$product->id];
                            $subtotal = $qty * $product->unit_price;
                            $tongTien += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $qty }}</td>
                            <td>{{ number_format($product->unit_price, 0, ',', '.') }}đ</td>
                            <td>{{ number_format($subtotal, 0, ',', '.') }}đ</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-right"><strong>Tổng tiền</strong></td>
                        <td><strong>{{ number_format($tongTien, 0, ',', '.') }}đ</strong></td>
                    </tr>
                </tbody>  
            </table>
                @php 
                    $httt = session('hinh_thuc_thanh_toan');
                @endphp

                @if ($httt == 2)
                    <div style="text-align:center; margin-top: 30px;">
                        <h4 style="color: #28a745;">Quét mã QR để chuyển khoản</h4>
                        <img src="{{ asset('images/qr-code.png') }}" alt="QR Code" style="max-width: 300px;">
                        <p style="margin-top: 10px;">Nội dung chuyển khoản: <strong>{{ Auth::user()->id }}_{{ now()->format('Ymd_His') }}</strong></p>
                        <p>Vui lòng chuyển đúng số tiền tổng cộng và nội dung để hệ thống xác nhận đơn hàng nhanh chóng.</p>
                    </div>
                @endif
        </div>
      

        <!-- Bên phải: Form nhập thông tin -->
        <div style="flex: 1; min-width: 300px;">
            <form method="POST" action="{{ route('saveorder') }}">
                @csrf
                <h4 class="text-center text-primary mb-4">Thông tin người nhận</h4>

                <label>Tên người nhận</label>
                <input type="text" class="form-control" name="ten_nguoi_nhan"
                    value="{{ old('ten_nguoi_nhan', Auth::user()->first_name ?? '') }}" required>

                <label>Số điện thoại</label>
                <input type="text" class="form-control" name="so_dien_thoai"
                    value="{{ old('so_dien_thoai', Auth::user()->phone ?? '') }}" required>

                <label>Địa chỉ</label>
                <input type="text" class="form-control" name="dia_chi"
                    value="{{ old('dia_chi', Auth::user()->address ?? '') }}" required>

                <label>Ghi chú</label>
                <textarea name="ghi_chu" class="form-control" rows="3"></textarea>

                <input type="hidden" name="hinh_thuc_thanh_toan" value="{{ request('hinh_thuc_thanh_toan') }}">

                <div class="text-center mt-3">
                    <button class="btn btn-success">Xác nhận đặt hàng</button>
                </div>

                @if (session('status'))
                    <div class="alert alert-success mt-3">{{ session('status') }}</div>
                @endif
            </form>
        </div>
    </div>
</x-oops-layout>

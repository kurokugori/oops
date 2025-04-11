<x-oops-layout>
    <x-slot name="title">Thông tin đơn hàng</x-slot>

    <form method="POST" action="{{ route('saveorder') }}" style="width: 50%; margin: 0 auto;">
        @csrf
        <h4 class="text-center text-primary mb-4">Thông tin người nhận</h4>

        <label>Tên người nhận</label>
        <input type="text" class="form-control" name="ten_nguoi_nhan" required>

        <label>Số điện thoại</label>
        <input type="text" class="form-control" name="so_dien_thoai" required>

        <label>Địa chỉ</label>
        <input type="text" class="form-control" name="dia_chi" required>

        <label>Ghi chú</label>
        <textarea name="ghi_chu" class="form-control" rows="3"></textarea>

        {{-- 👇 INPUT HIDDEN để giữ lại hình thức thanh toán từ bước trước --}}
        <input type="hidden" name="hinh_thuc_thanh_toan" value="{{ request('hinh_thuc_thanh_toan') }}">

        {{-- Nếu bạn muốn cho người dùng đổi thì giữ cái select này, còn không thì có thể bỏ đi --}}
        {{-- <label>Hình thức thanh toán</label>
        <select class="form-control" name="hinh_thuc_thanh_toan" required>
            <option value="1" {{ request('hinh_thuc_thanh_toan') == 1 ? 'selected' : '' }}>Thanh toán khi nhận hàng</option>
            <option value="2" {{ request('hinh_thuc_thanh_toan') == 2 ? 'selected' : '' }}>Chuyển khoản</option>
        </select> --}}

        <div class="text-center mt-3">
            <button class="btn btn-success">Xác nhận đặt hàng</button>
        </div>

        @if (session('status'))
            <div class="alert alert-success mt-3">{{ session('status') }}</div>
        @endif
    </form>
</x-oops-layout>

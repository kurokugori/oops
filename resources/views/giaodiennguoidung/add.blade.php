<x-oops-layout>
    
    <x-slot name='title'>  
        Thông tin đơn hàng 
    </x-slot>
    <form method='post' action="{{ route('saveorder') }}" style='width:30%; margin:0 auto'>
        <div style='text-align:center; font-weight:bold; color:#15c;'>THÊM THÔNG TIN GIAO HÀNG</div>

        <label>Tên người nhận</label>
        <input type='text' class='form-control form-control-sm' name='movie_name' required>

        <label>Số điện thoại</label>
        <input type='int' class='form-control form-control-sm' name='movie_name_vn' required>

        <label>Địa chỉ giao hàng</label>
        <input type='text' class='form-control form-control-sm' name='movie_name' require>

        <label>Ghi chú</label>
        <textarea class='form-control form-control-sm' name='overview_vn' rows='4' required></textarea>

        {{ csrf_field() }}

        <div style='text-align:center;'>
            <input type='submit' class='btn btn-primary mt-2' value='Lưu'>
        </div>

        @if (session('status'))
            <div class="alert alert-success mt-2">{{ session('status') }}</div>
        @endif

    </form>
</x-oops-layout>

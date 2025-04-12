<x-oops-layout> 
    
    <x-slot name='title'>  
        Admin Opps
    </x-slot>       
</x-oops-layout>
<div class="main-container">
        <div class="card" onclick="window.location='{{ route('admin.products') }}'">
            <a href="#">QUẢN LÝ SẢN PHẨM</a> 
        </div>
        <div class="card" onclick="window.location='{{ route('admin.orders') }}'">
            <a href="#">QUẢN LÝ ĐƠN HÀNG</a>
        </div>
        <div class="card" onclick="window.location='{{ route('admin.revenue') }}'">
            <a href="#">QUẢN LÝ DOANH THU</a>
        </div>
    </div>

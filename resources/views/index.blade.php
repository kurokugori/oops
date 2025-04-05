<x-oops-layout>
    <x-slot name='title'>
        Trang chủ
    </x-slot>
    <div class='list-oops'>
        @foreach($data as $row)
            <div class='oops'>
                <a href="{{url('trangchu/chi_tiet/'.$row->id)}}">
                    <img src="{{asset('anh/'.$row->image_url)}}" width='200px' height='200px'><br>
                    <b>{{$row->product_name}}</b><br/>
                    <i>{{number_format($row->unit_price,0,",",".")}}đ</i>
                </a>
            </div>
        @endforeach
    </div>
    {{-- === PHÂN TRANG ĐƠN GIẢN === --}}
    @if (isset($data) && $data instanceof \Illuminate\Contracts\Pagination\Paginator) {{-- Kiểm tra là Paginator --}}
        <div class="mt-4 d-flex justify-content-center"> {{-- justify-content-between để đẩy 2 nút ra xa --}}
            {{-- Sử dụng view mặc định cho simple pagination --}}
            {{-- Hoặc $data->links('pagination::simple-bootstrap-4') --}}
            {{ $data->links('pagination::simple-bootstrap-4') }}
        </div>
    @endif
</x-oops-layout>


<style>
    .navbar {
        background-color: #ff5850;
        font-weight:bold;
    }
    .nav-item a {
        color: #fff!important;
    }
    .navbar-nav {
        margin:0 auto;
    }
    .list-oops{
        display:grid;
        grid-template-columns:repeat(4,24%);
    }
    .oops {
        margin:10px;
        text-align:center;
    }
    .pagination-simple-container .pagination {
        width: 100%; /* Cho phép justify-content-between hoạt động */
         margin-bottom: 0;
    }
     .pagination-simple-container .page-item .page-link {
         /* Style chung cho nút */
         color: #ff5850;
         border: 1px solid #ff5850;
         padding: 0.5rem 1rem;
         margin: 0 5px;
         border-radius: 0.25rem;
     }
      .pagination-simple-container .page-item .page-link:hover {
          background-color: #ff5850;
          color: #fff;
      }

     .pagination-simple-container .page-item.disabled .page-link {
         color: #adb5bd;
         background-color: #e9ecef;
         border-color: #dee2e6;
         pointer-events: none;
     }
</style>
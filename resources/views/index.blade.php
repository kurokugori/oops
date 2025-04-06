<x-oops-layout>
    <x-slot name='title'>
        Trang chủ
    </x-slot>
    <div class='list-oops'>
            @foreach($data as $row)
                <div class='oops'>
                    <a href="{{url('trangchu/chi_tiet/'.$row->id)}}" style="text-decoration: none; color: inherit;">
                        <div class="product-frame">
                            <div class="product-text">
                                    <h5>OOPS</h5>
                            </div>
                            <img src="{{asset('anh/'.$row->image_url)}}" class="product-image">
                        </div><br>
                        <b class="product-name">
                            {{ \Illuminate\Support\Str::limit($row->product_name, 80) }}
                        </b>
                        <i>Giá bán: {{number_format($row->unit_price,0,",",".")}}đ</i>
                    </a>
                </div>
            @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $data->links() }}
    </div>
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
</style>
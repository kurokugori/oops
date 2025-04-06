<x-oops-layout>
    
    <x-slot name='title'>  
        Chi tiết sản phẩm 
    </x-slot> 

    <div class="container">
        <h4>Kết quả tìm kiếm cho: <strong>{{$query}}</strong></h4>
        @if(count($data) > 0)
            <div class='list-oops'>
                @foreach($data as $row)
                    <div class='oops'>
                        <a href="{{url('trangchu/chi_tiet/'.$row->product_id)}}">
                            <div class="product-frame">
                                <div class="product-text">
                                        <h5>OOPS</h5>
                                </div>
                                <img src="{{asset('anh/'.$row->image_url)}}" class="product-image">
                            </div><br>
                            <b>{{$row->product_name}}</b><br/>
                            <i>{{ number_format($row->unit_price, 0, ',', '.') }}đ</i>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $data->links() }}
            </div>
        @else
            <p class="text-muted mt-4">Không tìm thấy sản phẩm phù hợp.</p>
        @endif
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



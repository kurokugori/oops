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
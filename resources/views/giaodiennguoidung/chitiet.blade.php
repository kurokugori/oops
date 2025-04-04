<x-oops-layout>
    
    <x-slot name='title'>  
        Chi tiết sản phẩm 
    </x-slot> 

    <div class="oops-detail">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{asset('anh/'.$data->image_url)}}" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <h3>{{$data->product_name}}</h3>
                    <p><strong>Giá bán:</strong> {{$data->unit_price}}</p>
                </div>
                <div class="col-md-12" style="text-align: justify;">
                    <h5>Mô tả sản phẩm</h5>
                    <p>{{$data->description}}</p>
                </div>
            </div>
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
    .oops-detail {
        margin: 20px 0;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
    }
    .oops-detail h3 {
        color: #ff5850;
        margin-bottom: 15px;
    }
    .oops-detail img {
        max-width: 100%;
        border: 1px solid #eee;
        padding: 5px;
    }
</style>



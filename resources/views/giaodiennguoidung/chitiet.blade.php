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
                    <div class='mt-1'>  <!--Nút và số lượng đặt hàng-->
                        Số lượng mua:
                        <input type='number' id='product-number' size='5' min="1" value="1">
                        <button class='btn btn-success btn-sm mb-1' id='add-to-cart'>Thêm vào giỏ hàng</button>
                    </div>            
                </div>

                <div class="col-md-12" style="text-align: justify;">
                    <h5>Mô tả sản phẩm</h5>
                    <p>{{$data->description}}</p>
                </div>
            </div>
    </div>

</x-oops-layout>  
<!--code xử lý nhấn nút thêm-->
<script>
    $(document).ready(function(){
        $("#add-to-cart").click(function(){
            id = "{{$data->id}}";
            num = $("#product-number").val()
            $.ajax({
                type:"POST",
                dataType:"json",
                url: "{{route('cartadd')}}",
                data:{"_token": "{{ csrf_token() }}","id":id,"num":num},
                beforeSend:function(){
                },
                success:function(data){
                $("#cart-number-product").html(data);
                },
                error: function (xhr,status,error){
                },
                complete: function(xhr,status){
                }
            });
        });
    });
</script>
<style>
    /*Style cho mấy cái nút */
    .btn-add-to-cart {
        background-color: #ff5850;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        transition: all 0.3s;
    }

    .btn-buy-now {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        transition: all 0.3s;
    }

    .btn-add-to-cart:hover {
        background-color: #e04a42;
        transform: translateY(-2px);
    }

    .btn-buy-now:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }
    /*giao diện lúc đầu */
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



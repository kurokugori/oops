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
                        <a href="{{url('trangchu/chi_tiet/'.$row->product_id)}}" style="text-decoration: none; color: inherit;">
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
                        <div class='btn-add-product'>
                            <button class='btn btn-success btn-sm mb-1 add-product' product_id="{{$row->id}}">
                                Thêm vào giỏ hàng
                            </button>
                        </div>
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

    <script>
        $(document).ready(function(){
        $(".add-product").click(function(){
        let id = $(this).attr("product_id");
        let num = 1;
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



<x-oops-layout>
    
    <x-slot name='title'>  
        Chi tiết sản phẩm 
    </x-slot> 

    <div class="oops-detail">
        <!-- Thông tin sản phẩm -->
            <div class="row">
                <div class="col-md-4">
                    <div class="product-frame">
                        <img src="{{asset('anh/'.$data->image_url)}}" class="img-fluid">
                    </div><br>
                </div>
                <div class="col-md-8">
                    <h3>{{ $data->product_name }}</h3>
                    <p><strong>Giá bán:</strong> {{ $data->unit_price }}</p>

                    <div class="mt-2" style="text-align: justify;">
                        <h5>Mô tả sản phẩm</h5>
                        <p>{{ $data->description }}</p>
                    </div>

                    <div class="mt-3">
                        <label for="product-number">Số lượng mua:</label>
                        <input type="number" id="product-number" size="5" min="1" value="1" class="form-control d-inline-block w-auto mx-2">
                        <button class="btn btn-success btn-sm mb-1" id="add-to-cart">Thêm vào giỏ hàng</button>
                    </div>
                </div>
            </div>

            {{-- ======================================= --}}
            {{-- === BẮT ĐẦU PHẦN BÌNH LUẬN === --}}
            {{-- ======================================= --}}
            <div class="product-comments mt-4">
                <h4 class="mb-3">Bình luận về sản phẩm</h4>

                {{-- Khu vực hiển thị các bình luận đã có --}}
                {{-- Lặp qua biến $comments được truyền từ Controller --}}
                <div class="comment-list mb-4">
                    @if(isset($comments) && $comments->isNotEmpty()) {{-- Kiểm tra $comments --}}
                        @foreach($comments as $comment)
                            <div class="comment-item mb-3 pb-3 border-bottom">
                                <p class="mb-1">
                                    <strong class="comment-user">
                                        <i class="fas fa-user-circle mr-1"></i>
                                        {{-- Nếu dùng DB::table join thì truy cập trực tiếp --}}
                                        {{-- {{ $comment->first_name ?? 'Người dùng' }} {{ $comment->last_name ?? '' }} --}}
                                        {{-- Nếu dùng Eloquent với with('user') --}}
                                        {{ $comment->user->first_name ?? 'Người dùng' }} {{ $comment->user->last_name ?? '' }}
                                    </strong>
                                    <small class="text-muted comment-time ml-2">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small> {{-- Format thời gian --}}
                                </p>
                                <p class="comment-body mb-0">{{ $comment->body }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Chưa có bình luận nào cho sản phẩm này.</p>
                    @endif
                </div>

                {{-- Khu vực Form nhập bình luận mới --}}
                <div class="comment-form">
                    @auth {{-- Chỉ cho người đăng nhập bình luận --}}
                        <h5 class="mb-3">Để lại bình luận của bạn</h5>
                        {{-- ... Hiển thị lỗi/thành công nếu có ... --}}
                        @if(session('comment_success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('comment_success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                        @endif
                         @if ($errors->comment_store && $errors->comment_store->any())
                             <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->comment_store->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                         @endif

                        {{-- Đảm bảo route 'comments.store' tồn tại và là POST --}}
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $data->id }}"> {{-- Gửi ID sản phẩm --}}
                            <div class="form-group">
                                <label for="comment_body">Nội dung bình luận:</label>
                                <textarea name="body" id="comment_body" class="form-control @error('body', 'comment_store') is-invalid @enderror" rows="4" placeholder="Nhập bình luận của bạn..." required>{{ old('body') }}</textarea>
                                @error('body', 'comment_store') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-comment-submit">
                                <i class="fas fa-paper-plane mr-1"></i> Gửi bình luận
                            </button>
                        </form>
                    @else
                        <p class="text-center border p-3 rounded bg-light">
                            Vui lòng <a href="{{ route('login_register.show') }}">đăng nhập</a> để để lại bình luận.
                        </p>
                    @endauth
                </div>
            </div>
            {{-- === KẾT THÚC PHẦN BÌNH LUẬN === --}}

        
            <!-- Sản phẩm tương tự -->
            <div class="mt-5">           
                <h4>Sản phẩm tương tự</h4>
                <div id="relatedCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class='list-oops'>
                                @foreach($related->slice(0, 4) as $item)
                                    <div class='oops'>
                                        <a href="{{url('trangchu/chi_tiet/'.$item->id)}}" style="text-decoration: none; color: inherit;">
                                            <div class="product-frame">
                                                <div class="product-text">
                                                        <h5>OOPS</h5>
                                                </div>
                                                <img src="{{asset('anh/'.$item->image_url)}}" class="product-image">
                                            </div><br>
                                            <b class="product-name">
                                                {{ \Illuminate\Support\Str::limit($item->product_name, 80) }}
                                            </b>
                                            <i>Giá bán: {{number_format($item->unit_price,0,",",".")}}đ</i>
                                        </a>
                                        <div class='btn-add-product'>
                                            <button class='btn btn-success btn-sm mb-1 add-product' product_id="{{$item->id}}">
                                                Thêm vào giỏ hàng
                                            </button>
                                        </div>
                                        
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class='list-oops'>
                                @foreach($related->slice(4, 4) as $item)
                                    <div class='oops'>
                                        <a href="{{url('trangchu/chi_tiet/'.$item->id)}}" style="text-decoration: none; color: inherit;">
                                            <div class="product-frame">
                                                <div class="product-text">
                                                        <h5>OOPS</h5>
                                                </div>
                                                <img src="{{asset('anh/'.$item->image_url)}}" class="product-image">
                                            </div><br>
                                            <b class="product-name">
                                                {{ \Illuminate\Support\Str::limit($item->product_name, 80) }}
                                            </b>
                                            <i>Giá bán: {{number_format($item->unit_price,0,",",".")}}đ</i>
                                        </a>
                                        <div class='btn-add-product'>
                                            <button class='btn btn-success btn-sm mb-1 add-product' product_id="{{$item->id}}">
                                                Thêm vào giỏ hàng
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <!-- Điều khiển trước/sau -->
                    <a class="carousel-control-prev" href="#relatedCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Trước</span>
                    </a>
                    <a class="carousel-control-next" href="#relatedCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Sau</span>
                    </a>

                </div>

            </div>

    </div>

</x-oops-layout>  
<!--code xử lý nhấn nút thêm-->
    <script>
        $(document).ready(function(){
        $("#add-to-cart").click(function(){
            let id = "{{$data->id}}";
            let num = $("#product-number").val();
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


        $(document).ready(function(){
            // Thay đổi thời gian chuyển đổi thành 5 giây (5000ms)
            $('#relatedCarousel').carousel({
                interval: 5000
            });
        });

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
    .list-oops{
        display:grid;
        grid-template-columns:repeat(4,24%);
    }
    .oops {
        margin:10px;
        text-align:center;
    }
</style>



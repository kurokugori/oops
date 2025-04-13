<x-oops-layout> 
    
    <x-slot name='title'>  
        Thông Tin Ốp
    </x-slot>       
</x-oops-layout>
<style>
    .error-message {
        color: red;
        margin: 0 auto;
        text-align: center;
        margin-bottom: 20px;
    }

    .panel {
        width: 50%;
        margin: 0 auto;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .panel-body {
        padding: 20px;
    }

    .form-control,
    .form-control-file {
        width: 100%;
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .form-control:focus {
        border-color: #80bdff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-title {
        text-align: center;
        font-weight: bold;
        color: #15c;
        margin-bottom: 20px;
    }
</style>

@if ($errors->any())
        <div style='color:red; margin:0 auto'>
            <div >
                {{ __('Whoops! Something went wrong.') }}
            </div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="panel panel-default" style="width:50%; margin:0 auto;">
        <div class="panel-body">
        <form action="{{route('oopssave',['action'=>$action])}}" method = "post" enctype="multipart/form-data">
            @if($action=="add")
            <div style='text-align:center;font-weight:bold;color:#15c;'>THÊM THÔNG TIN ỐP</div>
            @else
                <div style='text-align:center;font-weight:bold;color:#15c;'>SỬA THÔNG TIN ỐP</div>
            @endif
            <label>ID sản phẩm</label>
                <input type='text' class='form-control form-control-sm' name='id' value="{{$products->id??''}}">
            <label>Mã danh mục sản phẩm</label>
                <input type='text' class='form-control form-control-sm' name='phone_brand_id' value="{{$products->phone_brand_id??''}}">
            <label>Tên sản phẩm</label>
                <input type='text' class='form-control form-control-sm' name='product_name' value="{{$products->product_name??''}}">
            <label>Mô tả</label>
                <input type='text' class='form-control form-control-sm' name='description' value="{{$products->description??''}}">
            <label>Giá bán</label>
                <input type='text' class='form-control form-control-sm' name='unit_price' value="{{number_format($products->unit_price ?? 0, 0, ',', '.')}}">
                </select>
                <label>Ảnh sản phẩm</label><br>
                @if($action == "edit")
                    <img src="{{ asset('images/' . $products->image_url) }}" width="200px" class='mb-1'>
                    <input type='hidden' value='{{ $products->id }}' name='id'>
                @endif
                <input type="file" name="image_url" accept="image/*" class="form-control-file">
                {{ csrf_field() }}
                <div style='text-align:center;'>
                    <input type='submit' class='btn btn-primary mt-1' value='Lưu'>
                </div>
            </form>
        </div>
    </div>


<x-oops-products> 
    <x-slot name='title'>  
        Quản lý sản phẩm
    </x-slot>       
</x-oops-products>


<a href="{{route('oopscreate')}}" class='btn btn-sm btn-success mb-1'>Thêm Sản Phẩm</a>

<div class="table-responsive">
    <table id="oops-table" class="table table-striped table-bordered" width="100%">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>ID</th>
                <th>DM ID</th>
                <th>Tên sản phẩm</th>
                <th>Mô tả</th>
                <th>Giá sản phẩm</th>
                <th width="120px">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td><img src="{{asset('images/'.$row->image_url)}}" width="50px"></td>
                <td>{{$row->id}}</td>
                <td>{{$row->phone_brand_id}}</td>
                <td>{{$row->product_name}}</td>
                <td>{{$row->description}}</td>
                <td>{{$row->unit_price}}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{route('oopsedit',['id'=>$row->id])}}" class='btn btn-sm btn-primary'>Sửa</a>
                        &nbsp;
                        <form method='post' action="{{route('oopsdelete')}}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                            <input type='hidden' value='{{$row->id}}' name='id'>
                            <input type='submit' class='btn btn-sm btn-danger' value='Xóa'>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table> 
</div>

<script>
$(document).ready(function(){
    $('#oops-table').DataTable({
                responsive: true,
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 100],
                bStateSave: true
    });
});
</script>
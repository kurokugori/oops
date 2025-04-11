<x-oops-layout>
    <x-slot name='title'>
        Đặt hàng
    </x-slot>
    <!-- thông báo đặt hàng được hay không-->
        @if (session('status'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('status') }}
        </div>
        @endif

        @if (session('error'))
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                {{ session('error') }}
            </div>
        @endif

    <div>
        <div style='color:#15c; font-weight:bold;font-size:15px;text-align:center'>DANH SÁCH SẢN PHẨM</div>
            <style>
                .product-table {
                    border-collapse: collapse;
                    width: 70%;
                    margin: 0 auto;
                }

                .product-table th, .product-table td {
                    border: 1px solid #ddd;
                    padding: 8px;
                }

                .product-table th {
                    background-color: #f2f2f2;
                    text-align: center;
                }

                .product-table tr:hover {
                    background-color: #f9f9f9;
                }

                .product-table td {
                    text-align: center;
                }
            </style>
            <table class='product-table' style='margin:0 auto; width:70%'>
                <thead>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Xóa</th>
                </thead>
                <tbody>
                    @php
                        $tongTien = 0;
                    @endphp
                    @foreach($data as $key=>$row)
                       <tr>
                            <td align='center'>{{$key+1}}</td>
                            <td>{{$row->product_name}}</td>
                            <td align='center'>{{$quantity[$row->id]}}</td>
                            <td align='center'>{{number_format($row->unit_price,0,',','.')}}đ</td>
                            <td align='center'>
                                <form method='post' action = "{{route('cartdelete')}}" >
                                    <input type='hidden' value='{{(string)$row->id}}' name='id'>
                                    <input type='submit' class='btn btn-sm btn-danger' value='Xóa'>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                       </tr>
                       @php
                            $tongTien +=$quantity[$row->id]*$row->unit_price;
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan='3' align='center'><b>Tổng cộng</b></td>
                        <td><b>{{number_format($tongTien,0,',','.')}}đ</b></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
           
                <div style='font-weight:bold;width:70%;margin:0 auto;text-align:center;'>
                    @auth
                        @if(count($data)>0)
                        <form id="checkout-form" method="get" action="{{ route('checkout') }}">
                                <input type="hidden" name="selected_products_json" id="selected_products_json">
                                <input type="hidden" name="quantities_json" id="quantities_json">
                            Hình thức thanh toán <br>
                            <div class='d-inline-flex'>
                                <select name='hinh_thuc_thanh_toan' class='form-control form-control-sm'>
                                    <option value='1'>Tiền mặt</option>
                                    <option value='2'>Chuyển khoản</option>
                                    <option value='3'>Thanh toán VNPay</option>
                                </select>
                            </div><br>
                            <input type='submit' class='btn btn-sm btn-primary mt-1' value='ĐẶT HÀNG'>
                            <!--đoạn Javascript để submit đầy đủ dữ liệu --> 
                            <script>
                                document.getElementById('checkout-form').addEventListener('submit', function (e) {
                                    let selectedProducts = [];
                                    let quantities = {};

                                    document.querySelectorAll('input[name="selected_products[]"]:checked').forEach(function (checkbox) {
                                        let id = checkbox.value;
                                        let row = checkbox.closest('tr');
                                        let qty = row.querySelector('input[type="number"]').value;
                                        selectedProducts.push(id);
                                        quantities[id] = qty;
                                    });

                                    document.getElementById('selected_products_json').value = JSON.stringify(selectedProducts);
                                    document.getElementById('quantities_json').value = JSON.stringify(quantities);
                                });
                            </script>
                        </form>
                        @else
                            Vui lòng chọn sản phẩm cần mua
                        @endif
                    @else
                        Vui lòng đăng nhập trước khi đặt hàng
                    @endauth
                </div>
            
       
    </div>
<script>
    /*
    $.ajax({
    url: "/cart/delete",
    method: "POST", // <-- Sửa thành POST
    data: {
        id: productId,
        _token: "{{ csrf_token() }}" // Thêm CSRF token
    },
    success: function(response) {
        // Xử lý thành công
    }
});*/
</script>
</x-oops-layout>


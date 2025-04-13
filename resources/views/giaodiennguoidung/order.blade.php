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
        <div style='color:#15c; font-weight:bold;font-size:25px;text-align:center'>DANH SÁCH SẢN PHẨM</div>
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
                    <th><input type="checkbox" id="select-all"></th>
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
                            <td align="center">
                                <input type="checkbox" name="selected_products[]" value="{{ (string)$row->id }}">
                            </td>
                            <td>{{$row->product_name}}</td>
                            <td align='center'>
                                <input type="number" name="quantity[{{ $row->id }}]" value="{{ $quantity[$row->id] }}" min="1" style="width: 60px;">
                            </td>
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
                        <td><b><span id="tong-tien">0đ</span></b></td>
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
    <!-- Script để chọn tất cả -->
    <script>
        document.getElementById('select-all').onclick = function() {
            let checkboxes = document.getElementsByName('selected_products[]');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        };
    </script>
    
    <script>
        function formatCurrency(amount) {
            return amount.toLocaleString('vi-VN') + 'đ';
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('input[name="selected_products[]"]:checked').forEach(function (checkbox) {
                let row = checkbox.closest('tr');
                let quantity = row.querySelector('input[type="number"]').value;
                let priceText = row.cells[3].innerText.replace('đ', '').replace(/\./g, '');
                let price = parseInt(priceText);
                total += price * quantity;
            });
            document.getElementById('tong-tien').innerText = formatCurrency(total);
        }

        // Sự kiện khi tick chọn sản phẩm
        document.querySelectorAll('input[name="selected_products[]"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', updateTotal);
        });

        // Sự kiện khi thay đổi số lượng
        document.querySelectorAll('input[type="number"]').forEach(function (input) {
            input.addEventListener('input', updateTotal);
        });

        // Sự kiện "Chọn tất cả"
        document.getElementById('select-all').addEventListener('change', function () {
            let checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            updateTotal();
        });
    </script>
</x-oops-layout>
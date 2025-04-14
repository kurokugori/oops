<x-oops-quanly> 
    
    <x-slot name='title'>  
        QUẢN LÝ ĐƠN ĐẶT HÀNG
    </x-slot>    

</x-oops-quanly>

<div class="table-responsive">
    <div style='color:#15c; font-weight:bold;font-size:25px;text-align:center'>QUẢN LÝ ĐƠN ĐẶT HÀNG</div>
        <table id="oops-table" class="table table-striped table-bordered" width="100%">
        <thead>
            <tr>
                <th style="width: 120px;">Mã đơn hàng</th>
                <th style="width: 160px;">Tên người nhận</th>
                <th style="width: 120px;">Số điện thoại</th>
                <th style="width: 220px;">Địa chỉ</th>
                <th style="width: 130px;">Ngày đặt hàng</th>
                <th style="width: 160px;">Ghi chú</th>
                <th style="width: 150px;">Hình thức thanh toán</th>
                <th style="width: 150px;">Trạng thái</th>
            </tr>
        </thead>

        <tbody>
            @foreach($data as $row)
            <tr>
                <td>
                    <a href="#" class="view-order-details" data-id="{{ $row->ma_don_hang }}" style="text-decoration: none; color: #007bff;">
                        {{ $row->ma_don_hang }}
                    </a>
                </td>
                <td>{{$row->ten_nguoi_nhan}}</td>
                <td>{{$row->so_dien_thoai}}</td>
                <td>{{$row->dia_chi}}</td>
                <td>{{$row->ngay_dat_hang}}</td>
                <td>{{$row->ghi_chu}}</td>
                <td>
                    @if($row->hinh_thuc_thanh_toan == 1)
                        COD
                    @elseif($row->hinh_thuc_thanh_toan == 2)
                        Chuyển khoản
                    @else
                        Không xác định
                    @endif
                </td>                
                <td>
                    <form action="{{ route('admin.orders.updateStatus', $row->ma_don_hang) }}" method="POST" style="display: flex; flex-direction: column; align-items: center;">
                    @csrf
                    @method('PUT')
                    <select name="trang_thai"
                            class="form-select form-select-sm status-dropdown"
                            onchange="this.form.submit(); updateSelectColor(this);"
                            style="color: white;">
                        <option value="Chờ xác nhận" {{ $row->trang_thai == 'Chờ xác nhận' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="Đã xác nhận" {{ $row->trang_thai == 'Đã xác nhận' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="Đã giao" {{ $row->trang_thai == 'Đã giao' ? 'selected' : '' }}>Đã giao</option>
                    </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table> 
</div>

<!-- Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Chi tiết đơn hàng</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#orderDetailsModal').modal('hide')">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="orderDetailsContent">
        <!-- Nội dung chi tiết đơn hàng sẽ được nạp ở đây -->
      </div>
    </div>
  </div>
</div>

<!--Thêm script AJAX để load chi tiết đơn hàng-->
<script>
    $(document).ready(function () {
        $('.view-order-details').click(function (e) {
            e.preventDefault();
            const orderId = $(this).data('id');

            // Cập nhật tiêu đề modal theo mã đơn hàng
            $('#orderDetailsModal .modal-title').text('Chi tiết đơn hàng ' + orderId);

            // AJAX load nội dung chi tiết đơn hàng
            $.ajax({
                url: `/orders/${orderId}/details`,
                method: 'GET',
                success: function (response) {
                    $('#orderDetailsContent').html(response);
                    $('#orderDetailsModal').modal('show');
                },
                error: function () {
                    alert('Không thể tải chi tiết đơn hàng!');
                }
            });
        });
    });
</script>

<!--màu sắc cho thanh trạng thái-->
<script>
    function updateSelectColor(selectElement) {
        const value = selectElement.value;
        let color = '';
        switch (value) {
            case 'Chờ xác nhận':
                color = '#f1c40f'; // vàng
                break;
            case 'Đã xác nhận':
                color = '#2ecc71'; // xanh lá
                break;
            case 'Đã giao':
                color = '#3498db'; // xanh nước biển
                break;
        }
        selectElement.style.backgroundColor = color;
    }

    // Gọi khi trang load để set màu đúng trạng thái ban đầu
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.status-dropdown').forEach(updateSelectColor);
    });
</script>



<!--CSS giao diện trạng thái-->
<style>
    #oops-table th, #oops-table td {
        text-align: center;
        vertical-align: middle;
        word-wrap: break-word;
        white-space: normal;
    }

    .status-dropdown {
        width: 100%;
        padding: 6px 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 6px;
        font-size: 14px;
        background-color: #f8f8f8;
        color: #333;
    }

    .btn-save-status {
        padding: 6px 10px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        background-color: #28a745;
        color: white;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-save-status:hover {
        background-color: #218838;
    }

    #oops-table th, #oops-table td {
        padding: 12px 8px;
        font-size: 14px;
    }

    .status-dropdown {
        width: 100%;
        padding: 6px 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
        background-color: #fff;
        color: #333;
        text-align: center;
    }

    .modal-body { 
        max-height: 500px;
        overflow-y: auto;
        padding: 20px;
        text-align: center;
    }
</style>
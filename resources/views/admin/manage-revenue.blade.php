<x-oops-quanly>
    <x-slot name='title'>QUẢN LÝ DOANH THU</x-slot>
</x-oops-quanly>
    <div style="color:#15c; font-weight:bold; font-size:25px; text-align:center">
    QUẢN LÝ DOANH THU
    </div>
        <div style="max-width: 800px; margin: 20px auto;">
        <canvas id="areaRevenueChart"></canvas>
    </div>

        <div class="table-responsive">

    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; align-items: center;">
    <div>
        <form method="GET" action="{{ route('admin.revenue') }}">
        <label for="filter">Lọc doanh thu theo:</label>
            <select name="filter" id="filter" onchange="this.form.submit()">
                <option value="5" {{ $filter == 5 ? 'selected' : '' }}>5 phút</option>
                <option value="10" {{ $filter == 10 ? 'selected' : '' }}>10 phút</option>
                <option value="15" {{ $filter == 15 ? 'selected' : '' }}>15 phút</option>
                <option value="30" {{ $filter == 30 ? 'selected' : '' }}>30 phút</option>
                <option value="60" {{ $filter == 60 ? 'selected' : '' }}>1 giờ</option>
                <option value="120" {{ $filter == 120 ? 'selected' : '' }}>2 giờ</option>
                <option value="360" {{ $filter == 360 ? 'selected' : '' }}>6 giờ</option>
                <option value="1440" {{ $filter == 1440 ? 'selected' : '' }}>1 ngày</option>
            </select>
    </form>

    </div>

        <div style="font-size: 24px; color: red; font-weight: bold;">
            Tổng doanh thu: {{ number_format($totalRevenue, 0, ',', '.') }}đ
        </div>

        <div>
            <a href="{{ route('admin.revenue.sync') }}" class="btn btn-success" onclick="return confirm('Bạn chắc chắn muốn cập nhật doanh thu không?')">
            Cập nhật doanh thu
            </a>
        </div>
    </div>

    <table id="revenue-table" class="table table-striped table-bordered" width="100%">
        <thead>
            <tr>
                <th style="width: 150px;">Mã đơn hàng</th>
                <th style="width: 200px;">Tên người nhận</th>
                <th style="width: 150px;">Tổng tiền</th>
                <th style="width: 180px;">Ngày cập nhật</th>
            </tr>
        </thead>
    <tbody>
    @foreach($revenue as $item)
            <tr>
                <td>{{ $item->ma_don_hang }}</td>
                <td>{{ $item->ten_nguoi_nhan }}</td>
                <td>{{ number_format($item->tong_tien, 0, ',', '.') }}đ</td>
                <td>{{ \Carbon\Carbon::parse($item->ngay_cap_nhat)->format('d/m/Y H:i:s') }}</td>
            </tr>
    @endforeach
            </tbody>
        </table>
    </div>

    <!-- Optional: CSS -->
    <style>
    #revenue-table th, #revenue-table td {
        text-align: center;
        vertical-align: middle;
    }

    .btn-success {
        padding: 8px 12px;
        font-size: 14px;
        border-radius: 5px;
        text-decoration: none;
    }

    .btn-success:hover {
        background-color: #218838;
        color: white;
        transform: scale(1.05); /* Thêm hiệu ứng phóng to */
        transition: all 0.3s ease;
    }

    select {
        padding: 6px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    select:hover {
        border-color: #007bff;
        cursor: pointer;
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('areaRevenueChart').getContext('2d');
        const areaRevenueChart = new Chart(ctx, {
            type: 'line',
            data: {
            labels: {!! json_encode($chartData->pluck('time')) !!}, // Sử dụng 'time' đã định dạng theo phút
            datasets: [{
            label: 'Doanh thu theo phút (VND)', // Cập nhật label theo phút
            data: {!! json_encode($chartData->pluck('tong')) !!}, // Dữ liệu doanh thu
            fill: true,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            tension: 0.4
        }]
        },
            options: {
            plugins: {
            legend: { display: true }
            },
            scales: {
            y: {
            beginAtZero: true,
            ticks: {
            callback: function(value) {
            return value.toLocaleString() + 'đ'; // Hiển thị tiền tệ với đơn vị 'đ'
                    }
                }
            }
        }
    }
});
</script>

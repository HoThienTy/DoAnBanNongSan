<table>
    <thead>
        <tr>
            <th colspan="2">Báo cáo hàng hủy tháng {{ $previousMonth->format('m/Y') }}</th>
        </tr>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Tổng số lượng hủy</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cancelledProducts as $item)
            <tr>
                <td>{{ $item->TenSanPham }}</td>
                <td>{{ $item->TongSoLuongHuy }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="2">Thống kê lý do hủy</th>
        </tr>
        <tr>
            <th>Lý do</th>
            <th>Tổng số lượng hủy</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cancelledReasons as $reason)
            <tr>
                <td>{{ $reason->ly_do }}</td>
                <td>{{ $reason->TongSoLuongHuy }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

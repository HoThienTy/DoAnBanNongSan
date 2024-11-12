<table>
    <thead>
        <tr>
            <th colspan="2">Sản phẩm bán chạy nhất tháng {{ $currentMonth->format('m/Y') }}</th>
        </tr>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng bán</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bestSellingProducts as $item)
            <tr>
                <td>{{ $item->TenSanPham }}</td>
                <td>{{ $item->TongSoLuongBan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

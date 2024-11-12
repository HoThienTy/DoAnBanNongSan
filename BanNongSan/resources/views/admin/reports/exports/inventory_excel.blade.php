<table>
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng tồn kho</th>
        </tr>
    </thead>
    <tbody>
        @foreach($inventoryData as $item)
            <tr>
                <td>{{ $item->TenSanPham }}</td>
                <td>{{ $item->TongSoLuong }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

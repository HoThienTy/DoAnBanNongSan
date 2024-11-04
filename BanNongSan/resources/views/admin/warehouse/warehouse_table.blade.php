<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng tồn</th>
            <th>Mức tối thiểu</th>
            <th>Ngày hết hạn gần nhất</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            @php
                // Tính tổng số lượng tồn kho từ các lô hàng
                $tongSoLuongTon = $product->loHang->sum('so_luong');
                $mucToiThieu = $product->khoHang->MucToiThieu ?? 0;
                $status = '';

                // Kiểm tra số lượng tồn kho so với mức tối thiểu
                if ($tongSoLuongTon <= $mucToiThieu) {
                    $status .= '<span class="badge badge-danger" data-toggle="tooltip" title="Số lượng tồn kho dưới mức tối thiểu">Tồn kho thấp</span> ';
                }

                // Lấy ngày hết hạn gần nhất
                $ngayHetHanGanNhat = $product->loHang()->where('so_luong', '>', 0)->min('han_su_dung');

                // Kiểm tra xem có lô hàng nào sắp hết hạn trong vòng 2 ngày tới không
                if ($ngayHetHanGanNhat && \Carbon\Carbon::parse($ngayHetHanGanNhat)->lt(\Carbon\Carbon::now()->addDays(2))) {
                    $status .= '<span class="badge badge-warning" data-toggle="tooltip" title="Có lô hàng sắp hết hạn">Sắp hết hạn</span>';
                }
            @endphp
            <tr>
                <td>{{ $product->MaSanPham }}</td>
                <td>{{ $product->TenSanPham }}</td>
                <td>{{ $tongSoLuongTon }}</td>
                <td>{{ $mucToiThieu }}</td>
                <td>{{ $ngayHetHanGanNhat ? \Carbon\Carbon::parse($ngayHetHanGanNhat)->format('d/m/Y') : 'Không có' }}</td>
                <td>{!! $status ?: '<span class="badge badge-success">Ổn định</span>' !!}</td>
                <td>
                    <a href="{{ route('admin.warehouse.show', $product->MaSanPham) }}" class="btn btn-info">Chi tiết</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

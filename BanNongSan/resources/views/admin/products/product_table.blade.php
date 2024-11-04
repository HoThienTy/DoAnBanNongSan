<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Giá bán</th>
            <th>Hình ảnh</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if($products->count() > 0)
            @foreach($products as $product)
            <tr>
                <td>{{ $product->MaSanPham }}</td>
                <td>{{ $product->TenSanPham }}</td>
                <td>{{ $product->danhMuc->TenDanhMuc ?? 'Không có' }}</td>
                <td>{{ number_format($product->GiaBan, 0, ',', '.') }} VND</td>
                <td>
                    @if($product->HinhAnh)
                        <img src="{{ asset('images/products/'.$product->HinhAnh) }}" alt="{{ $product->TenSanPham }}" width="100">
                    @else
                        Không có hình ảnh
                    @endif
                </td>
                <td>{{ $product->NgayTao }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->MaSanPham) }}" class="btn btn-warning">Chỉnh sửa</a>
                    <form action="{{ route('admin.products.destroy', $product->MaSanPham) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center">Không tìm thấy sản phẩm phù hợp.</td>
            </tr>
        @endif
    </tbody>
</table>

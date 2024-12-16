<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    @include('layouts.vendor-css')

</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    @include('layouts.header')

    <!-- Hero Section Begin -->
    <section class="hero hero-normal">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Danh mục</span>
                        </div>
                        <ul>
                            @foreach ($categories as $category)
                                <li><a
                                        href="{{ route('user.shop.index', ['category' => $category->MaDanhMuc]) }}">{{ $category->TenDanhMuc }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="{{ route('user.shop.index') }}" method="GET">
                                <div class="hero__search__categories">
                                    Tất cả
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" name="search" placeholder="Bạn cần tìm gì?"
                                    value="{{ request('search') }}">
                                <button type="submit" class="site-btn">TÌM KIẾM</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>0777526729</h5>
                                <span>Hỗ trợ 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Giỏ Hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Giỏ Hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <!-- Thay thế nội dung trong <tbody> bằng mã sau -->
                            <!-- Trong phần tbody của shopping-cart.blade.php -->
                            <tbody>
                                @if (session('cart') && count(session('cart')) > 0)
                                    <form action="{{ route('cart.update') }}" method="POST" id="cart-update-form">
                                        @csrf
                                        @foreach (session('cart') as $MaSanPham => $item)
                                            @php
                                                $product = App\Models\SanPham::with('loHang')->find($MaSanPham);
                                                $totalStock = $product->loHang->sum('so_luong');
                                            @endphp
                                            <tr>
                                                <td class="shoping__cart__item">
                                                    <img src="{{ asset('images/products/' . $item['photo']) }}"
                                                        alt="{{ $item['name'] }}">
                                                    <h5>{{ $item['name'] }}</h5>
                                                </td>
                                                <td class="shoping__cart__price">
                                                    {{ number_format($item['price'], 0, ',', '.') }} VNĐ
                                                </td>
                                                <td class="shoping__cart__quantity">
                                                    <div class="quantity">
                                                        <div class="pro-qty">
                                                            <input type="number"
                                                                name="quantities[{{ $MaSanPham }}]"
                                                                value="{{ $item['quantity'] }}" min="1"
                                                                max="{{ $totalStock }}" class="cart-quantity-input"
                                                                data-product-id="{{ $MaSanPham }}"
                                                                data-stock="{{ $totalStock }}">
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">Còn lại: {{ $totalStock }}</small>
                                                </td>
                                                <td class="shoping__cart__total">
                                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                                    VNĐ
                                                </td>
                                                <td class="shoping__cart__item__close">
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="MaSanPham"
                                                            value="{{ $MaSanPham }}">
                                                        <button type="submit" class="btn btn-link p-0 m-0">
                                                            <span class="icon_close"></span>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </form>
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">Giỏ hàng của bạn đang trống.</td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="{{ route('user.shop.index') }}" class="primary-btn cart-btn">TIẾP TỤC MUA SẮM</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Mã khuyến mãi</h5>
                            @if ($coupons->count() > 0)
                                <form action="{{ route('coupon.apply') }}" method="POST">
                                    @csrf
                                    <select name="coupon_code" class="form-control">
                                        <option value="">Chọn mã khuyến mãi</option>
                                        @foreach ($coupons as $coupon)
                                            <option value="{{ $coupon->ma_khuyen_mai }}">
                                                {{ $coupon->ma_khuyen_mai }} - Giảm {{ $coupon->giam_gia }}%
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="site-btn"
                                        style="background-color: #7fad39; border-color: #7fad39; margin-top: 10px;">
                                        Áp dụng mã
                                    </button>
                                </form>
                            @else
                                <p>Hiện không có mã khuyến mãi nào.</p>
                            @endif

                            @if (session('coupon'))
                                <p>Mã giảm giá: {{ session('coupon')->ma_khuyen_mai }} -
                                    {{ session('coupon')->giam_gia }}%</p>
                                <a href="{{ route('coupon.remove') }}" class="btn btn-danger remove-coupon">Xóa mã khuyến mãi</a>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Tính tổng tiền -->
                    @php
                        $total = 0;
                        if (session('cart')) {
                            foreach (session('cart') as $item) {
                                $total += $item['price'] * $item['quantity'];
                            }
                        }
                    @endphp

                    <!-- Hiển thị tổng tiền -->
                    <div class="shoping__checkout">
                        <h5>Tổng giỏ hàng</h5>
                        <ul>
                            <li>Tổng phụ <span>{{ number_format($total, 0, ',', '.') }} VNĐ</span></li>

                            <!-- Hiển thị giảm giá nếu có mã giảm giá trong session -->
                            @if (session('coupon'))
                                @php
                                    $discount = ($total * session('coupon')->giam_gia) / 100;
                                    $finalTotal = $total - $discount;
                                @endphp
                                <li>Giảm giá ({{ session('coupon')->giam_gia }}%)
                                    <span>-{{ number_format($discount, 0, ',', '.') }} VNĐ</span>
                                </li>
                            @else
                                @php
                                    $discount = 0;
                                    $finalTotal = $total;
                                @endphp
                            @endif

                            <!-- Tổng thanh toán sau khi đã áp dụng giảm giá -->
                            <li>Tổng <span>{{ number_format($finalTotal, 0, ',', '.') }} VNĐ</span></li>
                        </ul>
                        <a href="{{ route('checkout.index') }}" class="primary-btn">TIẾN HÀNH THANH TOÁN</a>
                    </div>


                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->

    @include('layouts.footer')
    @include('layouts.vendor-js')

    <script>
        $(document).ready(function() {
            $('.cart-quantity-input').on('change', function() {
                var productId = $(this).data('product-id');
                var quantity = parseInt($(this).val());
                var stockQuantity = parseInt($(this).data('stock'));

                if (quantity > stockQuantity) {
                    alert('Số lượng không được vượt quá ' + stockQuantity);
                    $(this).val(stockQuantity);
                    quantity = stockQuantity;
                }

                if (quantity < 1) {
                    alert('Số lượng tối thiểu là 1');
                    $(this).val(1);
                    quantity = 1;
                }

                $.ajax({
                    url: '{{ route('cart.update') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        quantities: {
                            [productId]: quantity
                        }
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Có lỗi khi cập nhật giỏ hàng: " + error);
                    }
                });
            });
        });

        // Xử lý form áp dụng mã khuyến mãi
        $('form[action="{{ route('coupon.apply') }}"]').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var submitBtn = form.find('button[type="submit"]');

            submitBtn.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Cập nhật hiển thị giá
                        $('#subtotal').text(response.total);
                        $('#discount-row').removeClass('d-none');
                        $('#discount-amount').text('-' + response.discount);
                        $('#final-total').text(response.finalTotal);

                        // Hiển thị thông tin mã giảm giá
                        $('.coupon-info').html(`
                    <div class="alert alert-success">
                        Mã giảm giá: ${response.coupon.ma_khuyen_mai} (${response.coupon.giam_gia}%)
                        <a href="{{ route('coupon.remove') }}" class="btn btn-danger btn-sm float-right remove-coupon">Xóa</a>
                    </div>
                `);

                        alert('Áp dụng mã khuyến mãi thành công!');
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra khi áp dụng mã khuyến mãi');
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                }
            });
        });

        // Xử lý xóa mã khuyến mãi
        $(document).on('click', '.remove-coupon', function(e) {
            e.preventDefault();
            if (!confirm('Bạn có chắc chắn muốn xóa mã khuyến mãi này?')) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload(); // Reload trang để hiển thị thông tin cập nhật
                    } else {
                        alert('Có lỗi xảy ra khi xóa mã khuyến mãi.');
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra khi xóa mã khuyến mãi.');
                }
            });
        });
    </script>



</body>
<style>
    .site-btn {
        color: #ffffff;
        background-color: #7fad39;
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        text-transform: uppercase;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .site-btn:hover {
        background-color: #689f2c;
        color: #ffffff;
    }

    .site-btn:disabled {
        background-color: #cccccc;
        cursor: not-allowed;
    }
</style>

</html>

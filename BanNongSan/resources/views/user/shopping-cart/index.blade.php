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
                            <tbody>
                                @if (session('cart') && count(session('cart')) > 0)
                                    @foreach (session('cart') as $MaSanPham => $item)
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
                                                        <input type="text" name="quantities[{{ $MaSanPham }}]"
                                                            value="{{ $item['quantity'] }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="shoping__cart__total">
                                                {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                                VNĐ
                                            </td>
                                            <td class="shoping__cart__item__close">
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="MaSanPham" value="{{ $MaSanPham }}">
                                                    <button type="submit" class="btn btn-link p-0 m-0"><span
                                                            class="icon_close"></span></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
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
                            @if($coupons->count() > 0)
                                <form action="{{ route('coupon.apply') }}" method="POST">
                                    @csrf
                                    <select name="coupon_code" class="form-control">
                                        <option value="">Chọn mã khuyến mãi</option>
                                        @foreach($coupons as $coupon)
                                            <option value="{{ $coupon->ma_khuyen_mai }}">
                                                {{ $coupon->ma_khuyen_mai }} - Giảm {{ $coupon->giam_gia }}%
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="site-btn" style="margin-top: 10px;">Áp dụng mã</button>
                                </form>
                            @else
                                <p>Hiện không có mã khuyến mãi nào.</p>
                            @endif
                        
                            @if (session('coupon'))
                                <p>Mã giảm giá: {{ session('coupon')->ma_khuyen_mai }} - {{ session('coupon')->giam_gia }}%</p>
                                <a href="{{ route('coupon.remove') }}" class="btn btn-danger">Xóa mã khuyến mãi</a>
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
                                    <span>-{{ number_format($discount, 0, ',', '.') }} VNĐ</span></li>
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


</body>

</html>

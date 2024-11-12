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
<style>
    .option-address {
        width: 100%;
        height: 46px;
        border: 1px solid #ebebeb;
        padding-left: 20px;
        font-size: 16px;
        color: #b2b2b2;
        border-radius: 4px;
    }
</style>

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
                            <form action="#">
                                <div class="hero__search__categories">
                                    All Categories
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" placeholder="What do yo u need?">
                                <button type="submit" class="site-btn">SEARCH</button>
                            </form>
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
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your
                        code
                    </h6>
                </div>
            </div>
            <div class="checkout__form">
                <h4>Chi Tiết Đơn Hàng</h4>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Thay đổi form để gửi dữ liệu đến `CheckoutController` -->
                <form action="{{ route('checkout.placeOrder') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <!-- Thông tin thanh toán -->
                            <div class="checkout__input">
                                <p>Họ và tên<span>*</span></p>
                                <input type="text" name="HoTen" value="{{ old('HoTen') }}">
                            </div>
                            <div class="checkout__input">
                                <p>Email<span></span></p>
                                <input type="email" name="Email" value="{{ old('Email') }}">
                            </div>
                            <div class="checkout__input">
                                <p>Số điện thoại<span>*</span></p>
                                <input type="text" name="SoDienThoai" value="{{ old('SoDienThoai') }}">
                            </div>
                            <div class="checkout__input">
                                <p>Tỉnh/Thành phố<span>*</span></p>
                                <select id="province" name="province" class="option-address">
                                    <option value="">Chọn tỉnh/thành phố</option>
                                    <!-- Các option sẽ được điền bởi JavaScript -->
                                </select>
                            </div>
                            <div class="checkout__input">
                                <p>Quận/Huyện<span>*</span></p>
                                <select id="district" name="district" class="option-address">
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                            </div>
                            <div class="checkout__input">
                                <p>Phường/Xã<span>*</span></p>
                                <select id="ward" name="ward" class="option-address">
                                    <option value="">Chọn phường/xã</option>
                                </select>
                            </div>
                            <div class="checkout__input">
                                <p>Số nhà và tên đường<span>*</span></p>
                                <input type="text" name="street" value="{{ old('street') }}">
                            </div>

                            <!-- Các trường khác nếu cần -->
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <!-- Hiển thị thông tin đơn hàng -->
                            <div class="checkout__order">
                                <h4>Đơn hàng của bạn</h4>
                                <div class="checkout__order__products">Sản phẩm <span>Thành tiền</span></div>
                                <ul>
                                    @foreach ($cart as $item)
                                        <li>{{ $item['name'] }} x {{ $item['quantity'] }}
                                            <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                                VNĐ</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="checkout__order__subtotal">Tổng phụ
                                    <span>{{ number_format($total, 0, ',', '.') }} VNĐ</span>
                                </div>

                                <!-- Hiển thị giảm giá nếu có -->
                                @if ($discount > 0)
                                    <div class="checkout__order__discount">Giảm giá
                                        <span>-{{ number_format($discount, 0, ',', '.') }} VNĐ</span>
                                    </div>
                                @endif

                                <!-- Hiển thị tổng cuối cùng -->
                                <div class="checkout__order__total">Tổng thanh toán
                                    <span>{{ number_format($finalTotal, 0, ',', '.') }} VNĐ</span>
                                </div>
                                <!-- Phần lựa chọn phương thức thanh toán -->
                                <div class="checkout__input__checkbox">
                                    <label for="payment_cod">
                                        Thanh toán khi nhận hàng (COD)
                                        <input type="radio" id="payment_cod" name="payment_method" value="cod"
                                            checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="payment_online">
                                        Thanh toán trực tuyến
                                        <input type="radio" id="payment_online" name="payment_method"
                                            value="online">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                                <button type="submit" class="site-btn">ĐẶT HÀNG</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    @include('layouts.footer')
    @include('layouts.vendor-js')

    <script>
        $(document).ready(function() {
            // Lấy danh sách tỉnh/thành phố
            $.ajax({
                url: "https://provinces.open-api.vn/api/p/",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    var options = '<option value="">Chọn tỉnh/thành phố</option>';
                    $.each(data, function(index, province) {
                        options += '<option value="' + province.code + '">' + province.name +
                            '</option>';
                    });
                    $('#province').html(options);
                }
            });

            // Khi chọn tỉnh/thành phố, lấy danh sách quận/huyện
            $('#province').on('change', function() {
                var provinceCode = $(this).val();
                if (provinceCode) {
                    $.ajax({
                        url: "https://provinces.open-api.vn/api/p/" + provinceCode + "?depth=2",
                        method: "GET",
                        dataType: "json",
                        success: function(data) {
                            var options = '<option value="">Chọn quận/huyện</option>';
                            $.each(data.districts, function(index, district) {
                                options += '<option value="' + district.code + '">' +
                                    district.name + '</option>';
                            });
                            $('#district').html(options);
                            $('#ward').html('<option value="">Chọn phường/xã</option>');
                        }
                    });
                } else {
                    $('#district').html('<option value="">Chọn quận/huyện</option>');
                    $('#ward').html('<option value="">Chọn phường/xã</option>');
                }
            });

            // Khi chọn quận/huyện, lấy danh sách phường/xã
            $('#district').on('change', function() {
                var districtCode = $(this).val();
                if (districtCode) {
                    $.ajax({
                        url: "https://provinces.open-api.vn/api/d/" + districtCode + "?depth=2",
                        method: "GET",
                        dataType: "json",
                        success: function(data) {
                            var options = '<option value="">Chọn phường/xã</option>';
                            $.each(data.wards, function(index, ward) {
                                options += '<option value="' + ward.code + '">' + ward
                                    .name + '</option>';
                            });
                            $('#ward').html(options);
                        }
                    });
                } else {
                    $('#ward').html('<option value="">Chọn phường/xã</option>');
                }
            });
        });
    </script>


</body>

</html>

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

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Thanh toán thành công</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('welcome') }}">Trang chủ</a>
                            <span>Thanh toán thành công</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Success Section Begin -->
    <section class="checkout-success spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Cảm ơn bạn đã đặt hàng!</h2>
                    <p>Đơn hàng của bạn đã được xử lý thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận và giao hàng.</p>
                    <a href="{{ route('user.account.orders') }}" class="primary-btn">Xem đơn hàng của bạn</a>
                    <a href="{{ route('user.shop.index') }}" class="primary-btn">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Success Section End -->

    @include('layouts.footer')
    @include('layouts.vendor-js')


</body>

</html>

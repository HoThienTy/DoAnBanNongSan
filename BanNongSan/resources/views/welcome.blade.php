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
    <section class="hero">
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
                    <div class="hero__item set-bg" data-setbg="{{ asset('assets/img/hero/banner.jpg') }}">
                        <div class="hero__text">
                            <span>Thực phẩm sạch</span>
                            <h2>Thực Phẩm <br />100% Organic</h2>
                            <p>Có sẵn nhận và giao hàng miễn phí</p>
                            <a href="#" class="primary-btn">MUA NGAY</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    @foreach ($categories as $index => $category)
                        <div class="col-lg-3">
                            <div class="categories__item set-bg"
                                data-setbg="{{ asset('assets/img/categories/cat-' . (($index % 5) + 1) . '.jpg') }}">
                                <h5>
                                    <a href="{{ route('user.shop.index', ['category' => $category->MaDanhMuc]) }}">
                                        {{ $category->TenDanhMuc }}
                                    </a>
                                </h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->


    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Sản Phẩm Nổi Bật</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">Tất Cả</li>
                            @foreach ($categories as $category)
                                <li data-filter="{{ $category->TenDanhMuc }}">{{ $category->TenDanhMuc }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
            <div class="row featured__filter">
                @foreach ($featuredProducts as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix">
                        <div class="featured__item">
                            <div class="featured__item__pic set-bg"
                                data-setbg="{{ asset('images/products/' . $product->HinhAnh) }}">
                                <ul class="featured__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>

                                    <li>
                                        <a href="javascript:void(0);" onclick="addToCart({{ $product->MaSanPham }})">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <div class="featured__item__text">
                                <h6><a
                                        href="{{ route('user.product-detail.show', $product->MaSanPham) }}">{{ $product->TenSanPham }}</a>
                                </h6>
                                <h5>{{ number_format($product->GiaBan, 0, ',', '.') }} VNĐ</h5>
                            </div>
                        </div>


                    </div>
                @endforeach
            </div>

        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{ asset('assets/img/banner/banner-1.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{ asset('assets/img/banner/banner-2.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <!-- Chia thành 3 cột, mỗi cột 3 sản phẩm -->
                @for ($i = 0; $i < 3; $i++)
                    <div class="col-lg-4 col-md-6">
                        <div class="latest-product__text">
                            <h4>Sản phẩm mới</h4>
                            <div class="latest-product__slider owl-carousel">
                                <div class="latest-prdouct__slider__item">
                                    @foreach ($latestProducts->slice($i * 3, 3) as $product)
                                        <a href="#" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="{{ $product->HinhAnh ? asset('images/products/' . $product->HinhAnh) : asset('images/default.jpg') }}"
                                                    alt="{{ $product->TenSanPham }}">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>{{ $product->TenSanPham }}</h6>
                                                <span>{{ number_format($product->GiaBan, 0, ',', '.') }} VNĐ</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>Từ Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{ asset('assets/img/blog/blog-1.jpg') }}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> Ngày 4 tháng 5, 2024</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Mẹo nấu ăn giúp việc nấu ăn trở nên đơn giản</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{ asset('assets/img/blog/blog-2.jpg') }}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> Ngày 4 tháng 5, 2024</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">6 cách chuẩn bị bữa sáng cho 30 người</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{ asset('assets/img/blog/blog-3.jpg') }}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> Ngày 4 tháng 5, 2024</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Thăm trang trại sạch ở Mỹ</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section End -->

    @include('layouts.footer')
    @include('layouts.vendor-js')

    <script>
        function addToCart(MaSanPham) {
            fetch(`/cart/add/${MaSanPham}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Xử lý phản hồi nếu cần, ví dụ: hiển thị thông báo đã thêm vào giỏ hàng
                    alert(data.message || 'Sản phẩm đã được thêm vào giỏ hàng!');
                })
                .catch(error => {
                    console.error('Lỗi khi thêm vào giỏ hàng:', error);
                });
            window.location.href = '/cart';

        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Khởi tạo MixItUp cho sản phẩm
            var containerEl = document.querySelector('#productContainer');
            var mixer = mixitup(containerEl);

            // Lắng nghe sự kiện nhấp vào các mục danh mục
            document.querySelectorAll('.featured__controls ul li').forEach(function(filterButton) {
                filterButton.addEventListener('click', function() {
                    // Xóa lớp 'active' khỏi tất cả các mục và thêm vào mục được chọn
                    document.querySelectorAll('.featured__controls ul li').forEach(function(btn) {
                        btn.classList.remove('active');
                    });
                    filterButton.classList.add('active');

                    // Áp dụng bộ lọc dựa trên giá trị `data-filter`
                    var filterValue = filterButton.getAttribute('data-filter');
                    mixer.filter(filterValue === "all" ? 'all' : filterValue);
                });
            });
        });
    </script>
</body>

</html>

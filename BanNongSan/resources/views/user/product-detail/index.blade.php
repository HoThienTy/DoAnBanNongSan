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
                    <li><a href="{{ route('user.shop.index', ['category' => $category->MaDanhMuc]) }}">{{ $category->TenDanhMuc }}</a></li>
                @endforeach
            </ul>
        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="hero__search">
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
            </div>
        </section>
        <!-- Hero Section End -->

        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb__text">
                            <h2>{{ $product->TenSanPham }}</h2>
                            <div class="breadcrumb__option">
                                <a href="{{ route('welcome') }}">Trang chủ</a>
                                <a href="{{ route('user.shop.index', ['category' => $product->MaDanhMuc]) }}">{{ $product->danhMuc->TenDanhMuc }}</a>
                                <span>{{ $product->TenSanPham }}</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->

        <!-- Product Details Section Begin -->
        <section class="product-details spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="product__details__pic">
                            <div class="product__details__pic__item">
                                <img class="product__details__pic__item--large"
                                    src="{{ asset('images/products/' . $product->HinhAnh) }}" alt="{{ $product->TenSanPham }}">
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="product__details__text">
                            <h3>{{ $product->TenSanPham }}</h3>
                            <div class="product__details__price">{{ number_format($product->GiaBan, 0, ',', '.') }} VNĐ</div>
                            <p>{{ $product->MoTa }}</p>
                            
                            @php
                                $stockQuantity = optional($product->khoHang)->SoLuongTon ?? 0;
                            @endphp
                            <div class="stock-status mb-3">
                                @if($stockQuantity > 0)
                                    <span class="badge badge-success">Còn hàng</span>
                                    <span class="text-success">Số lượng: {{ $stockQuantity }} sản phẩm</span>
                                @else
                                    <span class="badge badge-danger">Hết hàng</span>
                                @endif
                            </div>
                        
                            @if($stockQuantity > 0)
                                <div class="product__details__quantity">
                                    <div class="quantity">
                                        <form action="{{ route('cart.add', $product->MaSanPham) }}" method="POST">
                                            @csrf
                                            <div class="pro-qty">
                                                <input type="number" name="quantity" value="1" min="1" max="{{ $stockQuantity }}">
                                            </div>
                                            <button type="submit" class="primary-btn">THÊM VÀO GIỎ HÀNG</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <button class="primary-btn" disabled>HẾT HÀNG</button>
                            @endif
                        </div>
                        
                    </div>
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                        aria-selected="true">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                        aria-selected="false">Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                        aria-selected="false">Reviews <span>(1)</span></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <h6>Products Infomation</h6>
                                        <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                            Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus. Vivamus
                                            suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam sit amet quam
                                            vehicula elementum sed sit amet dui. Donec rutrum congue leo eget malesuada.
                                            Vivamus suscipit tortor eget felis porttitor volutpat. Curabitur arcu erat,
                                            accumsan id imperdiet et, porttitor at sem. Praesent sapien massa, convallis a
                                            pellentesque nec, egestas non nisi. Vestibulum ac diam sit amet quam vehicula
                                            elementum sed sit amet dui. Vestibulum ante ipsum primis in faucibus orci luctus
                                            et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam
                                            vel, ullamcorper sit amet ligula. Proin eget tortor risus.</p>
                                            <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                            ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                            elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                            porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                            nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                            Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed
                                            porttitor lectus nibh. Vestibulum ac diam sit amet quam vehicula elementum
                                            sed sit amet dui. Proin eget tortor risus.</p>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-2" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <h6>Products Infomation</h6>
                                        <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                            Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                            Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                            sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                            eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                            Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                            sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                            diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                            ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                            Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                            Proin eget tortor risus.</p>
                                        <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                            ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                            elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                            porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                            nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</p>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-3" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <h6>Products Infomation</h6>
                                        <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                            Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                            Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                            sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                            eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                            Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                            sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                            diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                            ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                            Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                            Proin eget tortor risus.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Details Section End -->

        <!-- Related Product Section Begin -->
        <section class="related-product">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title related__product__title">
                            <h2>Related Product</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{ asset('images/products/' . $relatedProduct->HinhAnh) }}">
                                    <ul class="product__item__pic__hover">
                                        <!-- ... -->
                                    </ul>
                                    <a href="{{ route('user.product-detail.show', $relatedProduct->MaSanPham) }}" class="product-link"></a>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{ route('user.product-detail.show', $relatedProduct->MaSanPham) }}">{{ $relatedProduct->TenSanPham }}</a></h6>
                                    <h5>{{ number_format($relatedProduct->GiaBan, 0, ',', '.') }} VNĐ</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
            </div>
        </section>
        <!-- Related Product Section End -->

        @include('layouts.footer')
        @include('layouts.vendor-js')

    </body>

    </html>
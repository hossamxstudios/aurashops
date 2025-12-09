<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - My Wishlist</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="My Wishlist - Aura Beauty Care">
    <meta name="keywords" content="cosmetics, skin care, hair care, body care, beauty">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    @include('website.main.meta')
</head>
<body class="preload-wrapper">
    <div id="wrapper">
        @include('website.main.navbar')
        <!-- page-title -->
        <div class="page-title" style="background-image: url({{ asset('website/images/section/page-title.jpg') }});">
            <div class="pt-5 container-full">
                <div class="pt-5 row">
                    <div class="col-12">
                        <h3 class="text-center heading">My Wishlist</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li><a class="link" href="{{ route('home') }}">Homepage</a></li>
                            <li><i class="icon-arrRight"></i></li>
                            <li>Wishlist</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->
        <!-- wishlist -->
        <section class="flat-spacing">
            <div class="container">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if($wishlistItems->count() > 0)
                    <div class="mb-4 wishlist-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $wishlistItems->count() }} {{ $wishlistItems->count() === 1 ? 'item' : 'items' }} in your wishlist</h5>
                            <a href="{{ route('shop.all') }}" class="tf-btn btn-outline">
                                <span class="text text-button">Continue Shopping</span>
                            </a>
                        </div>
                    </div>
                    <div class="tf-grid-layout wrapper-shop tf-col-5" id="gridLayout">
                        @foreach($wishlistItems as $item)
                            @php
                                $product = $item->product;
                            @endphp
                            <div class="grid card-product" data-availability="Out of stock" data-brand="adidas">
                                <div class="card-product-wrapper">
                                    <a href="{{ route('product.show', $product->slug) }}" class="product-img">
                                        <img class="lazyload img-product" data-src="{{ $product->getFirstMediaUrl('product_thumbnail') }}"
                                            src="{{ $product->getFirstMediaUrl('product_thumbnail') }}" alt="image-product">
                                        <img class="lazyload img-hover" data-src="{{ $product->getFirstMediaUrl('product_thumbnail') }}"
                                            src="{{ $product->getFirstMediaUrl('product_thumbnail') }}" alt="image-product">
                                    </a>
                                    <div class="list-product-btn">
                                        <a href="javascript:void(0);"
                                           class="box-icon wishlist btn-icon-action btn-add-to-wishlist"
                                           data-product-id="{{ $product->id }}"
                                           data-in-wishlist="true">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Remove from Wishlist</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon quickview tf-btn-loading" data-bs-toggle="modal" data-bs-target="#quickView{{ $product->id }}">
                                            <span class="icon icon-eye"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                    <div class="list-btn-main">
                                        @if($product->isSimple())
                                            <a href="javascript:void(0);"
                                            class="btn-main-product"
                                            data-add-to-cart
                                            data-product-id="{{ $product->id }}"
                                            data-product-type="simple">Add To cart</a>
                                        @elseif($product->isVariant())
                                            <a href="javascript:void(0);"
                                            class="btn-main-product"
                                            data-bs-toggle="modal"
                                            data-bs-target="#quickView{{ $product->id }}">Select Options</a>
                                        @elseif($product->isBundle())
                                            @php
                                                $hasBundleVariants = $product->bundleItems->contains(function($bundleItem) {
                                                    return $bundleItem->child && $bundleItem->child->isVariant();
                                                });
                                            @endphp
                                            @if($hasBundleVariants)
                                                <a href="javascript:void(0);"
                                                class="btn-main-product"
                                                data-bs-toggle="modal"
                                                data-bs-target="#bundleSelectionModal{{ $product->id }}">Select Bundle Items</a>
                                            @else
                                                <a href="javascript:void(0);"
                                                class="btn-main-product"
                                                data-add-to-cart
                                                data-product-id="{{ $product->id }}"
                                                data-product-type="bundle">Add To cart</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="{{ route('product.show', $product->slug) }}" class="title link">{{ $product->name }}</a>
                                    <span class="price current-price">{{ $product->price }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-5 text-center empty-wishlist">
                        <svg width="150" height="150" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-4">
                            <path d="M20.84 4.61012C20.3292 4.09912 19.7228 3.69376 19.0554 3.4172C18.3879 3.14064 17.6725 2.99829 16.95 2.99829C16.2275 2.99829 15.5121 3.14064 14.8446 3.4172C14.1772 3.69376 13.5708 4.09912 13.06 4.61012L12 5.67012L10.94 4.61012C9.9083 3.57842 8.50903 2.99883 7.05 2.99883C5.59096 2.99883 4.19169 3.57842 3.16 4.61012C2.1283 5.64181 1.54871 7.04108 1.54871 8.50012C1.54871 9.95915 2.1283 11.3584 3.16 12.3901L4.22 13.4501L12 21.2301L19.78 13.4501L20.84 12.3901C21.351 11.8794 21.7563 11.2729 22.0329 10.6055C22.3095 9.93801 22.4518 9.2226 22.4518 8.50012C22.4518 7.77763 22.3095 7.06222 22.0329 6.39476C21.7563 5.7273 21.351 5.12087 20.84 4.61012Z" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <h4>Your Wishlist is Empty</h4>
                        <p class="mb-4 text-secondary">Save your favorite products for later!</p>
                        <a href="{{ route('shop.all') }}" class="tf-btn btn-fill">
                            <span class="text text-button">Start Shopping</span>
                        </a>
                    </div>
                @endif
            </div>
        </section>
        <!-- /wishlist -->
        @include('website.main.footer')
    </div>
    @foreach($wishlistItems as $item)
        @php $product = $item->product; @endphp
        @include('website.pages.home.quickViewModal')
        @if($product->isBundle())
            @include('website.pages.home.bundleSelectionModal')
        @endif
    @endforeach
    @include('website.pages.home.cartModal')
    @include('website.main.scripts')
</body>
</html>

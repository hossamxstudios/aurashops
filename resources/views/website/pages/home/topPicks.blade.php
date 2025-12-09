<section class="pt-5 flat-spacing">
    <div class="container-fluid px-lg-5">
        <div class="text-center heading-section wow fadeInUp">
            <h3 class="heading">Today's Top Picks</h3>
            <p class="subheading text-secondary">Fresh styles just in! Elevate your look.</p>
        </div>
        <div dir="ltr" class="swiper tf-sw-latest" data-preview="6" data-tablet="4" data-mobile="2" data-space-lg="25" data-space-md="25" data-space="10" data-pagination="2" data-pagination-md="2" data-pagination-lg="2">
            <div class="swiper-wrapper">
                @foreach($topPicksProducts as $index => $product)
                <div class="swiper-slide">
                    <div class="card-product wow fadeInUp" data-wow-delay="{{ $index * 0.1 }}s">
                        <div class="card-product-wrapper">
                            <a href="{{ route('product.show', $product->slug) }}" class="product-img">
                                @php
                                    $thumbnail = $product->getFirstMediaUrl('product_thumbnail');
                                    $images = $product->getMedia('product_images');
                                    $hoverImage = $images->count() > 0 ? $images->first()->getUrl() : $thumbnail;
                                @endphp
                                <img class="lazyload img-product" data-src="{{ $thumbnail }}" src="{{ $thumbnail }}" alt="{{ $product->name }}">
                                <img class="lazyload img-hover" data-src="{{ $hoverImage }}" src="{{ $hoverImage }}" alt="{{ $product->name }}">
                            </a>
                            @if($product->sale_price > 0)
                            <div class="on-sale-wrap">
                                <span class="on-sale-item"> -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% </span>
                            </div>
                            @endif
                            @if($product->is_featured)
                            <div class="marquee-product bg-main">
                                <div class="marquee-wrapper">
                                    <div class="initial-child-container">
                                        <div class="marquee-child-item">
                                            <p class="text-white font-2 text-btn-uppercase fw-6">Featured</p>
                                        </div>
                                        <div class="marquee-child-item">
                                            <span class="icon icon-lightning text-critical"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="list-product-btn">
                                <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action" data-wishlist-product="{{ $product->id }}">
                                    <span class="icon icon-heart"></span>
                                    <span class="tooltip">Wishlist</span>
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
                            <span class="price">
                                @if($product->sale_price > 0)
                                    <span class="old-price">EGP {{ number_format($product->price, 2) }}</span>
                                    EGP {{ number_format($product->sale_price, 2) }}
                                @else
                                    EGP {{ number_format($product->price, 2) }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="sw-pagination-latest sw-dots type-circle justify-content-center"></div>
        </div>
    </div>
</section>

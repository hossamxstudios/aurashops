<!-- Related Products -->
<section class="pt-0 flat-spacing">
    <div class="container">
        <div class="flat-title">
            <span class="title">Related Products</span>
        </div>
        @if($relatedProducts->count() > 0)
        <div dir="ltr" class="swiper tf-sw-latest" data-preview="4" data-tablet="3" data-mobile="2" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
            <div class="swiper-wrapper">
                @foreach($relatedProducts as $relatedProduct)
                <div class="swiper-slide">
                    <div class="card-product">
                        <div class="card-product-wrapper">
                            <a href="{{ route('product.show', $relatedProduct->slug) }}" class="product-img">
                                @if($relatedProduct->getFirstMediaUrl('product_thumbnail'))
                                    <img class="lazyload img-product"
                                         data-src="{{ $relatedProduct->getFirstMediaUrl('product_thumbnail') }}"
                                         src="{{ $relatedProduct->getFirstMediaUrl('product_thumbnail') }}"
                                         alt="{{ $relatedProduct->name }}">
                                @endif
                                @if($relatedProduct->getMedia('product_images')->first())
                                    <img class="lazyload img-hover"
                                         data-src="{{ $relatedProduct->getMedia('product_images')->first()->getUrl() }}"
                                         src="{{ $relatedProduct->getMedia('product_images')->first()->getUrl() }}"
                                         alt="{{ $relatedProduct->name }}">
                                @endif
                            </a>

                            @if($relatedProduct->sale_price > 0)
                            <div class="on-sale-wrap">
                                <span class="on-sale-item">-{{ round((($relatedProduct->price - $relatedProduct->sale_price) / $relatedProduct->price) * 100) }}%</span>
                            </div>
                            @endif

                            <div class="list-product-btn">
                                <a href="javascript:void(0);"
                                   class="box-icon wishlist btn-icon-action"
                                   data-wishlist-product="{{ $relatedProduct->id }}">
                                    <span class="icon icon-heart"></span>
                                    <span class="tooltip">Wishlist</span>
                                </a>
                                <a href="javascript:void(0);"
                                   class="box-icon quickview tf-btn-loading"
                                   data-product-id="{{ $relatedProduct->id }}"
                                   data-bs-toggle="modal"
                                   data-bs-target="#quickViewModal{{ $relatedProduct->id }}">
                                    <span class="icon icon-eye"></span>
                                    <span class="tooltip">Quick View</span>
                                </a>
                            </div>

                            <div class="list-btn-main">
                                @if($relatedProduct->isSimple())
                                    <a href="javascript:void(0);"
                                       class="btn-main-product"
                                       data-add-to-cart
                                       data-product-id="{{ $relatedProduct->id }}"
                                       data-product-type="simple">
                                        Add To Cart
                                    </a>
                                @elseif($relatedProduct->isVariant())
                                    <a href="{{ route('product.show', $relatedProduct->slug) }}" class="btn-main-product">
                                        Select Options
                                    </a>
                                @elseif($relatedProduct->isBundle())
                                    <a href="{{ route('product.show', $relatedProduct->slug) }}" class="btn-main-product">
                                        View Bundle
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="card-product-info">
                            <a href="{{ route('product.show', $relatedProduct->slug) }}" class="title link">
                                {{ $relatedProduct->name }}
                            </a>
                            @if($relatedProduct->sale_price > 0)
                                <span class="price">
                                    <span class="old-price">EGP {{ number_format($relatedProduct->price, 2) }}</span>
                                    EGP {{ number_format($relatedProduct->sale_price, 2) }}
                                </span>
                            @else
                                <span class="price">EGP {{ number_format($relatedProduct->price, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="sw-pagination-latest sw-dots type-circle justify-content-center"></div>
        </div>
        @else
        <div class="text-center py-5">
            <p class="text-secondary">No related products found.</p>
        </div>
        @endif
    </div>
</section>

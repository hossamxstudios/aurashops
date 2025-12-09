<section class="pt-5 flat-spacing">
    <div class="tf-main-product section-image-zoom">
        <div class="container">
            <div class="row">
                <!-- Product default -->
                <div class="col-md-6">
                    <div class="tf-product-media-wrap sticky-top">
                        <div class="thumbs-slider">
                            <div dir="ltr" class="swiper tf-product-media-thumbs other-image-zoom" data-direction="vertical">
                                <div class="swiper-wrapper stagger-wrap">
                                    <div class="swiper-slide stagger-item" data-color="{{ $product->getFirstMediaUrl('product_thumbnail') }}">
                                        <div class="item">
                                            <img class="lazyload" data-src="{{ $product->getFirstMediaUrl('product_thumbnail') }}" src="{{ $product->getFirstMediaUrl('product_thumbnail') }}" alt="">
                                        </div>
                                    </div>
                                    @foreach ($product->getMedia('product_images') as $media)
                                    <div class="swiper-slide stagger-item" data-color="{{ $media->getUrl() }}">
                                        <div class="item">
                                            <img class="lazyload" data-src="{{ $media->getUrl() }}" src="{{ $media->getUrl() }}" alt="">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide" data-color="{{ $product->getFirstMediaUrl('product_thumbnail') }}">
                                        <a href="{{ $product->getFirstMediaUrl('product_thumbnail') }}" target="_blank" class="item" data-pswp-width="600px" data-pswp-height="800px">
                                            <img class="tf-image-zoom lazyload" data-zoom="{{ $product->getFirstMediaUrl('product_thumbnail') }}" data-src="{{ $product->getFirstMediaUrl('product_thumbnail') }}" src="{{ $product->getFirstMediaUrl('product_thumbnail') }}" alt="">
                                        </a>
                                    </div>
                                    @foreach ($product->getMedia('product_images') as $media)
                                    <div class="swiper-slide" data-color="{{ $media->getUrl() }}">
                                        <a href="{{ $media->getUrl() }}" target="_blank" class="item" data-pswp-width="600px" data-pswp-height="800px">
                                            <img class="tf-image-zoom lazyload" data-zoom="{{ $media->getUrl() }}" data-src="{{ $media->getUrl() }}" src="{{ $media->getUrl() }}" alt="">
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tf-product-info-wrap position-relative">
                        <div class="tf-zoom-main"></div>
                        <div class="tf-product-info-list other-image-zoom">
                            <div class="tf-product-info-heading">
                                <div class="tf-product-info-name">
                                    <div class="text text-btn-uppercase">{{ $product->categories->first()?->name }} | {{ $product->brand->name }}</div>
                                    <h3 class="name">{{ $product->name }}</h3>
                                    <div class="sub">
                                        <div class="tf-product-info-rate">
                                            <div class="list-star">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="icon icon-star{{ $i <= floor($product->rating ?? 5) ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                            <div class="text text-caption-1">({{ $product->reviews->count() }} reviews)</div>
                                        </div>
                                        <div class="tf-product-info-sold">
                                            <i class="icon icon-lightning"></i>
                                            <div class="text text-caption-1">{{ $product->orders_count ?? 0 }} sold in last 32 hours</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tf-product-info-desc">
                                    <div class="tf-product-info-price">
                                        <h5 class="price-on-sale font-2" id="productPrice-{{ $product->id }}">EGP {{ number_format($product->getDisplayPrice(), 2) }}</h5>
                                        @if($product->sale_price > 0)
                                            <div class="compare-at-price font-2" id="productOriginalPrice-{{ $product->id }}">EGP {{ number_format($product->price, 2) }}</div>
                                            <div class="badges-on-sale text-btn-uppercase" id="productDiscount-{{ $product->id }}">
                                                -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                            </div>
                                        @endif
                                    </div>
                                    <p>{{ $product->details ?? 'No description available.' }}</p>
                                    <div class="tf-product-info-liveview">
                                        <i class="icon icon-eye"></i>
                                        <p class="text-caption-1"><span class="liveview-count">{{ rand(15, 50) }}</span> people are viewing this right now</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tf-product-info-choose-option" id="productOptions-{{ $product->id }}">
                                @if($product->isVariant())
                                    @php
                                        $attributesMap = [];
                                        foreach($product->variants as $variant) {
                                            if (!$variant->is_active) continue;
                                            foreach($variant->values as $value) {
                                                $attrId = $value->attribute_id;
                                                $attrName = $value->attribute->name;
                                                if (!isset($attributesMap[$attrId])) {
                                                    $attributesMap[$attrId] = [
                                                        'id' => $attrId,
                                                        'name' => $attrName,
                                                        'values' => []
                                                    ];
                                                }
                                                $attributesMap[$attrId]['values'][$value->id] = $value->name;
                                            }
                                        }
                                    @endphp

                                    @foreach($attributesMap as $attributeId => $attribute)
                                        <div class="variant-picker-item">
                                            <div class="variant-picker-label mb_12">
                                                {{ $attribute['name'] }}:<span class="text-title variant-picker-label-value value-attr-{{ $attributeId }}-{{ $product->id }}"></span>
                                            </div>
                                            <div class="variant-picker-values gap12">
                                                @foreach($attribute['values'] as $valueId => $valueName)
                                                    <input type="radio"
                                                           name="attribute_{{ $attributeId }}_{{ $product->id }}"
                                                           id="product-attr-{{ $attributeId }}-val-{{ $valueId }}-{{ $product->id }}"
                                                           value="{{ $valueId }}"
                                                           data-attribute-id="{{ $attributeId }}">
                                                    <label class="style-text-1 style-rounded radius-60 color-btn"
                                                           for="product-attr-{{ $attributeId }}-val-{{ $valueId }}-{{ $product->id }}"
                                                           data-value-id="{{ $valueId }}"
                                                           data-value-name="{{ $valueName }}">
                                                        <span class="text-title">{{ $valueName }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if(!$product->isBundle())
                                <div class="tf-product-info-quantity">
                                    <div class="title mb_12">Quantity:</div>
                                    <div class="wg-quantity">
                                        <span class="btn-quantity btn-decrease">-</span>
                                        <input class="quantity-product" type="text" name="number" value="1" id="quantity-{{ $product->id }}">
                                        <span class="btn-quantity btn-increase">+</span>
                                    </div>
                                </div>
                                @endif

                                <div>
                                    <div class="tf-product-info-by-btn mb_10">
                                        @if($product->isSimple())
                                            <a href="javascript:void(0);"
                                               class="btn-style-2 flex-grow-1 text-btn-uppercase fw-6"
                                               id="addToCartBtn-{{ $product->id }}"
                                               data-add-to-cart
                                               data-product-id="{{ $product->id }}"
                                               data-product-type="simple">
                                                <span>Add to cart -&nbsp;</span>
                                                <span class="tf-qty-price total-price" id="totalPrice-{{ $product->id }}">EGP {{ number_format($product->getDisplayPrice(), 2) }}</span>
                                            </a>
                                        @elseif($product->isVariant())
                                            <a href="javascript:void(0);"
                                               class="btn-style-2 flex-grow-1 text-btn-uppercase fw-6"
                                               id="addToCartBtn-{{ $product->id }}"
                                               data-add-to-cart
                                               data-product-id="{{ $product->id }}"
                                               data-product-type="variant"
                                               onclick="validateAndAddToCart{{ $product->id }}(event)">
                                                <span>Add to cart -&nbsp;</span>
                                                <span class="tf-qty-price total-price" id="totalPrice-{{ $product->id }}">EGP {{ number_format($product->getDisplayPrice(), 2) }}</span>
                                            </a>
                                        @elseif($product->isBundle())
                                            @php
                                                $hasBundleVariants = $product->bundleItems->contains(function($bundleItem) {
                                                    return $bundleItem->child && $bundleItem->child->isVariant();
                                                });
                                            @endphp
                                            @if($hasBundleVariants)
                                                <a href="javascript:void(0);"
                                                   class="btn-style-2 flex-grow-1 text-btn-uppercase fw-6"
                                                   data-bs-toggle="modal"
                                                   data-bs-target="#bundleSelectionModal{{ $product->id }}">
                                                    <span>Select Bundle Items</span>
                                                </a>
                                            @else
                                                <a href="javascript:void(0);"
                                                   class="btn-style-2 flex-grow-1 text-btn-uppercase fw-6"
                                                   data-add-to-cart
                                                   data-product-id="{{ $product->id }}"
                                                   data-product-type="bundle">
                                                    <span>Add to cart -&nbsp;</span>
                                                    <span class="tf-qty-price total-price">EGP {{ number_format($product->getDisplayPrice(), 2) }}</span>
                                                </a>
                                            @endif
                                        @endif
                                        <a href="javascript:void(0);" class="box-icon hover-tooltip text-caption-2 wishlist btn-icon-action" data-wishlist-product="{{ $product->id }}">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip text-caption-2">Wishlist</span>
                                        </a>
                                    </div>
                                </div>

                                @if($product->isBundle() && $product->bundleItems->count())
                                <div class="tf-product-bundle-items mb_30">
                                    <div class="tf-bundle-header mb_20">
                                        <h6 class="fw-6"><i class="icon-layers me-2"></i>This Bundle Includes:</h6>
                                    </div>
                                    <div class="tf-bundle-items-list">
                                        @foreach($product->bundleItems as $bundleItem)
                                            @php
                                                $childProduct = $bundleItem->child;
                                            @endphp
                                            @if($childProduct)
                                            <div class="tf-bundle-item">
                                                <div class="tf-bundle-item-image">
                                                    @if($childProduct->getFirstMediaUrl('product_thumbnail'))
                                                        <img src="{{ $childProduct->getFirstMediaUrl('product_thumbnail') }}"
                                                             alt="{{ $childProduct->name }}">
                                                    @else
                                                        <img src="{{ asset('website/images/products/placeholder.jpg') }}"
                                                             alt="{{ $childProduct->name }}">
                                                    @endif
                                                    @if($bundleItem->qty > 1)
                                                        <span class="bundle-qty-badge">{{ $bundleItem->qty }}x</span>
                                                    @endif
                                                </div>
                                                <div class="tf-bundle-item-info">
                                                    <h6 class="bundle-item-name">{{ $childProduct->name }}</h6>
                                                    <div class="bundle-item-meta">
                                                        @if($childProduct->isVariant())
                                                            <span class="badge bg-primary-subtle text-primary">
                                                                <i class="icon-settings me-1"></i>Multiple Options
                                                            </span>
                                                        @endif
                                                        <span class="text-caption-1 text-secondary">
                                                            {{ $bundleItem->qty }} {{ $bundleItem->qty > 1 ? 'Items' : 'Item' }}
                                                        </span>
                                                    </div>
                                                    @if($childProduct->details)
                                                        <p class="bundle-item-desc text-caption-1 text-secondary">
                                                            {{ Str::limit($childProduct->details, 80) }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="tf-bundle-item-price">
                                                    @if($childProduct->sale_price > 0)
                                                        <div class="price-on-sale">
                                                            <span class="price-sale">EGP {{ number_format($childProduct->sale_price, 2) }}</span>
                                                            <span class="price-old">EGP {{ number_format($childProduct->price, 2) }}</span>
                                                        </div>
                                                    @else
                                                        <span class="price">EGP {{ number_format($childProduct->price, 2) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="tf-bundle-total">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-6">Bundle Total:</span>
                                            <span class="fw-6 text-primary fs-5">
                                                @if($product->sale_price > 0)
                                                    <span class="text-decoration-line-through text-secondary me-2 fs-6">
                                                        EGP {{ number_format($product->price, 2) }}
                                                    </span>
                                                    EGP {{ number_format($product->sale_price, 2) }}
                                                @else
                                                    EGP {{ number_format($product->price, 2) }}
                                                @endif
                                            </span>
                                        </div>
                                        @if($product->sale_price > 0)
                                            @php
                                                $bundleSavings = $product->price - $product->sale_price;
                                                $bundleSavingsPercent = round(($bundleSavings / $product->price) * 100);
                                            @endphp
                                            <div class="mt-2 bundle-savings text-success">
                                                <i class="icon-check me-1"></i>
                                                You save EGP {{ number_format($bundleSavings, 2) }} ({{ $bundleSavingsPercent }}%)
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <div class="tf-product-info-help">
                                    <div class="tf-product-info-extra-link">
                                        <a href="#delivery_return" data-bs-toggle="modal" class="tf-product-extra-icon">
                                            <div class="icon">
                                                <i class="icon-shipping"></i>
                                            </div>
                                            <p class="text-caption-1">Delivery & Return</p>
                                        </a>
                                        <a href="#ask_question" data-bs-toggle="modal" class="tf-product-extra-icon">
                                            <div class="icon">
                                                <i class="icon-question"></i>
                                            </div>
                                            <p class="text-caption-1">Ask A Question</p>
                                        </a>
                                        <a href="#share_social" data-bs-toggle="modal" class="tf-product-extra-icon">
                                            <div class="icon">
                                                <i class="icon-share"></i>
                                            </div>
                                            <p class="text-caption-1">Share</p>
                                        </a>
                                    </div>
                                    <div class="tf-product-info-time">
                                        <div class="icon">
                                            <i class="icon-timer"></i>
                                        </div>
                                        <p class="text-caption-1">Estimated Delivery:&nbsp;&nbsp;<span>12-26 days</span> (International), <span>3-6 days</span> (United States)</p>
                                    </div>
                                    <div class="tf-product-info-return">
                                        <div class="icon">
                                            <i class="icon-arrowClockwise"></i>
                                        </div>
                                        <p class="text-caption-1">Return within <span>45 days</span> of purchase. Duties & taxes are non-refundable.</p>
                                    </div>
                                    <div class="dropdown dropdown-store-location">
                                        <div class="dropdown-title dropdown-backdrop" data-bs-toggle="dropdown" aria-haspopup="true">
                                            <div class="tf-product-info-view link">
                                                <div class="icon">
                                                    <i class="icon-map-pin"></i>
                                                </div>
                                                <span>View Store Information</span>
                                            </div>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <div class="dropdown-content">
                                                <div class="dropdown-content-heading">
                                                    <h5>Store Location</h5>
                                                    <i class="icon icon-close"></i>
                                                </div>
                                                <div class="line-bt"></div>
                                                <div>
                                                    <h6>Fashion Modave</h6>
                                                    <p>Pickup available. Usually ready in 24 hours</p>
                                                </div>
                                                <div>
                                                    <p>766 Rosalinda Forges Suite 044,</p>
                                                    <p>Gracielahaven, Oregon</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="tf-product-info-sku">
                                    <li>
                                        <p class="text-caption-1">SKU:</p>
                                        <p class="text-caption-1 text-1">{{ $product->sku ?? 'N/A' }}</p>
                                    </li>
                                    <li>
                                        <p class="text-caption-1">Vendor:</p>
                                        <p class="text-caption-1 text-1">{{ $product->brand->name }}</p>
                                    </li>
                                    <li>
                                        <p class="text-caption-1">Available:</p>
                                        <p class="text-caption-1 text-1">{{ $product->quantity > 0 ? 'Instock' : 'Out of Stock' }}</p>
                                    </li>
                                    <li>
                                        <p class="text-caption-1">Categories:</p>
                                        <p class="text-caption-1">
                                            @foreach($product->categories as $index => $category)
                                                <a href="{{ route('shop.category', $category->slug) }}" class="text-1 link">{{ $category->name }}</a>{{ $index < $product->categories->count() - 1 ? ', ' : '' }}
                                            @endforeach
                                        </p>
                                    </li>
                                </ul>
                                <div class="tf-product-info-guranteed">
                                    <div class="text-title">
                                        Guranteed safe checkout:
                                    </div>
                                    <div class="tf-payment">
                                        <a href="#">
                                            <img src="{{ asset('website/images/payment/img-1.png') }}" alt="">
                                        </a>
                                        <a href="#">
                                            <img src="{{ asset('website/images/payment/img-2.png') }}" alt="">
                                        </a>
                                        <a href="#">
                                            <img src="{{ asset('website/images/payment/img-3.png') }}" alt="">
                                        </a>
                                        <a href="#">
                                            <img src="{{ asset('website/images/payment/img-4.png') }}" alt="">
                                        </a>
                                        <a href="#">
                                            <img src="{{ asset('website/images/payment/img-5.png') }}" alt="">
                                        </a>
                                        <a href="#">
                                            <img src="{{ asset('website/images/payment/img-6.png') }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tf-sticky-btn-atc">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form class="form-sticky-atc">
                        <div class="tf-sticky-atc-product">
                            <div class="image">
                                @php
                                    $thumbnail = $product->getFirstMediaUrl('product_thumbnail');
                                @endphp
                                <img class="lazyload" data-src="{{ $thumbnail }}" alt="{{ $product->name }}" src="{{ $thumbnail }}">
                            </div>
                            <div class="content">
                                <div class="text-title">{{ $product->name }}</div>
                                <div class="text-caption-1 text-secondary-2" id="stickySelectedOptions-{{ $product->id }}">
                                    @if($product->isVariant())
                                        Select options
                                    @else
                                        {{ $product->categories->first()?->name }}
                                    @endif
                                </div>
                                <div class="text-title" id="stickyPrice-{{ $product->id }}">EGP {{ number_format($product->getDisplayPrice(), 2) }}</div>
                            </div>
                        </div>
                        <div class="tf-sticky-atc-infos" id="stickyVariantOptions-{{ $product->id }}">
                            @if($product->isVariant())
                                @php
                                    // Get all attributes for sticky bar
                                    $stickyAttributes = [];
                                    foreach($product->variants as $variant) {
                                        if (!$variant->is_active) continue;
                                        foreach($variant->values as $value) {
                                            $attrId = $value->attribute_id;
                                            $attrName = $value->attribute->name;
                                            if (!isset($stickyAttributes[$attrId])) {
                                                $stickyAttributes[$attrId] = [
                                                    'id' => $attrId,
                                                    'name' => $attrName,
                                                    'values' => []
                                                ];
                                            }
                                            if (!isset($stickyAttributes[$attrId]['values'][$value->id])) {
                                                $stickyAttributes[$attrId]['values'][$value->id] = $value->name;
                                            }
                                        }
                                    }
                                @endphp

                                @foreach($stickyAttributes as $attribute)
                                <div class="gap-12 mb-2 tf-sticky-atc-option d-flex align-items-center" data-attribute-id="{{ $attribute['id'] }}">
                                    <div class="tf-sticky-atc-infos-title text-title" style="min-width: 80px;">{{ $attribute['name'] }}:</div>
                                    <div class="tf-dropdown-sort style-2" data-bs-toggle="dropdown">
                                        <div class="btn-select">
                                            <span class="text-sort-value font-2 sticky-attr-value-{{ $attribute['id'] }}-{{ $product->id }}">Choose</span>
                                            <span class="icon icon-arrow-down"></span>
                                        </div>
                                        <div class="dropdown-menu">
                                            @foreach($attribute['values'] as $valueId => $valueName)
                                                <div class="select-item sticky-variant-option"
                                                     data-attribute-id="{{ $attribute['id'] }}"
                                                     data-value-id="{{ $valueId }}"
                                                     data-value-name="{{ $valueName }}">
                                                    <span class="text-value-item">{{ $valueName }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif

                            @if(!$product->isBundle())
                            <div class="gap-12 tf-sticky-atc-quantity d-flex align-items-center">
                                <div class="tf-sticky-atc-infos-title text-title">Quantity:</div>
                                <div class="wg-quantity style-1">
                                    <span class="btn-quantity minus-btn">-</span>
                                    <input type="text" name="number" value="1" id="stickyQuantity-{{ $product->id }}">
                                    <span class="btn-quantity plus-btn">+</span>
                                </div>
                            </div>
                            @endif

                            <div class="tf-sticky-atc-btns">
                                @if($product->isSimple())
                                    <a href="javascript:void(0);"
                                       class="tf-btn w-100 btn-reset radius-4"
                                       data-add-to-cart
                                       data-product-id="{{ $product->id }}"
                                       data-product-type="simple"
                                       id="stickyAddToCartBtn-{{ $product->id }}">
                                        <span class="text text-btn-uppercase">Add To Cart</span>
                                    </a>
                                @elseif($product->isVariant())
                                    <a href="javascript:void(0);"
                                       class="tf-btn w-100 btn-reset radius-4"
                                       id="stickyAddToCartBtn-{{ $product->id }}"
                                       data-add-to-cart
                                       data-product-id="{{ $product->id }}"
                                       data-product-type="variant"
                                       onclick="stickyAddToCart{{ $product->id }}()">
                                        <span class="text text-btn-uppercase">Add To Cart</span>
                                    </a>
                                @elseif($product->isBundle())
                                    @php
                                        $hasBundleVariants = $product->bundleItems->contains(function($bundleItem) {
                                            return $bundleItem->child && $bundleItem->child->isVariant();
                                        });
                                    @endphp
                                    @if($hasBundleVariants)
                                        <a href="javascript:void(0);"
                                           class="tf-btn w-100 btn-reset radius-4"
                                           data-bs-toggle="modal"
                                           data-bs-target="#bundleSelectionModal{{ $product->id }}">
                                            <span class="text text-btn-uppercase">Select Bundle</span>
                                        </a>
                                    @else
                                        <a href="javascript:void(0);"
                                           class="tf-btn w-100 btn-reset radius-4"
                                           data-add-to-cart
                                           data-product-id="{{ $product->id }}"
                                           data-product-type="bundle">
                                            <span class="text text-btn-uppercase">Add To Cart</span>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Variant picker label value */
    .variant-picker-label-value {
        margin-left: 5px;
        font-weight: 500;
    }

    /* Rounded color button style */
    .color-btn {
        min-width: 50px;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }

    .color-btn:hover {
        border-color: #000;
    }

    /* Selected state - black background */
    input[type="radio"]:checked + .color-btn {
        border-color: #000;
        background-color: #000;
        color: #fff;
    }

    input[type="radio"]:checked + .color-btn .text-title {
        color: #fff;
    }

    /* Bundle Items Styles */
    .tf-product-bundle-items {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #e9ecef;
    }

    .tf-bundle-header h6 {
        font-size: 16px;
        color: #212529;
        margin: 0;
    }

    .tf-bundle-items-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 20px;
    }

    .tf-bundle-item {
        display: flex;
        gap: 16px;
        align-items: center;
        background: #fff;
        padding: 16px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .tf-bundle-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }

    .tf-bundle-item-image {
        position: relative;
        width: 80px;
        height: 80px;
        flex-shrink: 0;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .tf-bundle-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .bundle-qty-badge {
        position: absolute;
        top: 4px;
        right: 4px;
        background: #000;
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
    }

    .tf-bundle-item-info {
        flex-grow: 1;
    }

    .bundle-item-name {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #212529;
    }

    .bundle-item-meta {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 6px;
    }

    .bundle-item-desc {
        margin: 0;
        line-height: 1.4;
    }

    .tf-bundle-item-price {
        text-align: right;
        flex-shrink: 0;
    }

    .tf-bundle-item-price .price {
        font-size: 16px;
        font-weight: 600;
        color: #212529;
    }

    .tf-bundle-item-price .price-on-sale {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .tf-bundle-item-price .price-sale {
        font-size: 16px;
        font-weight: 600;
        color: #198754;
    }

    .tf-bundle-item-price .price-old {
        font-size: 13px;
        color: #6c757d;
        text-decoration: line-through;
    }

    .tf-bundle-total {
        padding-top: 16px;
        border-top: 2px solid #dee2e6;
    }

    .bundle-savings {
        font-size: 14px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .tf-bundle-item {
            flex-direction: column;
            text-align: center;
        }

        .tf-bundle-item-image {
            width: 100%;
            height: 200px;
        }

        .tf-bundle-item-price {
            text-align: center;
        }

        .bundle-item-meta {
            justify-content: center;
        }
    }
</style>

<script>
    // Validation function for Add to Cart
    window['validateAndAddToCart{{ $product->id }}'] = function(event) {
        event.preventDefault();
        const productId = {{ $product->id }};
        const productType = '{{ $product->type }}';

        // Check if product is variant type
        if (productType === 'variant') {
            const optionsContainer = document.getElementById('productOptions-' + productId);

            if (optionsContainer) {
                const attributeGroups = optionsContainer.querySelectorAll('.variant-picker-item');
                const totalGroups = attributeGroups.length;

                let selectedCount = 0;
                const radioNames = new Set();

                attributeGroups.forEach(group => {
                    const radios = group.querySelectorAll('input[type="radio"]');
                    radios.forEach(radio => {
                        if (radio.checked) {
                            radioNames.add(radio.name);
                        }
                    });
                });

                selectedCount = radioNames.size;

                if (selectedCount < totalGroups) {
                    if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                        window.ShopFeatures.showNotification('Please select all options', 'error');
                    }
                    return false;
                }

                const addToCartBtn = document.getElementById('addToCartBtn-' + productId);
                const variantId = addToCartBtn ? addToCartBtn.getAttribute('data-variant-id') : null;

                if (!variantId) {
                    if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                        window.ShopFeatures.showNotification('Please select all options', 'error');
                    }
                    return false;
                }
            }
        }

        // Check if product is bundle type with variant items
        if (productType === 'bundle') {
            const bundleData = window['bundleVariants' + productId];

            if (bundleData && Object.keys(bundleData).length > 0) {
                const bundleModal = new bootstrap.Modal(document.getElementById('bundleSelectionModal' + productId));
                bundleModal.show();
                return false;
            }
        }

        // Trigger add to cart
        const quantityInput = document.getElementById('quantity-' + productId);
        const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const addToCartBtn = document.getElementById('addToCartBtn-' + productId);

        if (!addToCartBtn) return false;

        const variantId = addToCartBtn.getAttribute('data-variant-id');

        addToCartBtn.disabled = true;
        const originalHtml = addToCartBtn.innerHTML;
        addToCartBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Adding...';

        fetch('/cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                variant_id: variantId,
                qty: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                    window.ShopFeatures.showNotification('✓ Added to cart', 'success');
                }
                if (window.ShopFeatures && window.ShopFeatures.updateCartCount) {
                    window.ShopFeatures.updateCartCount(data.cart.count);
                }
                if (typeof window.refreshCartContent === 'function') {
                    window.refreshCartContent();
                }
            } else {
                if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                    window.ShopFeatures.showNotification(data.message || 'Failed to add to cart', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Add to cart error:', error);
            if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                window.ShopFeatures.showNotification('An error occurred. Please try again.', 'error');
            }
        })
        .finally(() => {
            addToCartBtn.disabled = false;
            addToCartBtn.innerHTML = originalHtml;
        });

        return false;
    };
</script>

@if(!$product->isBundle())
<script>
    // Price Calculator for product {{ $product->id }}
    (function() {
        const productId = {{ $product->id }};
        const quantityInput = document.getElementById('quantity-' + productId);
        const stickyQuantityInput = document.getElementById('stickyQuantity-' + productId);
        const totalPriceEl = document.getElementById('totalPrice-' + productId);
        const stickyPriceEl = document.getElementById('stickyPrice-' + productId);

        if (!quantityInput || !totalPriceEl) {
            return;
        }

        // Store base price and last quantity
        let basePrice = parseFloat({{ $product->getDisplayPrice() }});
        let lastQty = 1;

        function updateTotalPrice() {
            const inputValue = quantityInput.value;
            const currentQty = parseInt(inputValue);

            // Skip if empty or invalid
            if (inputValue === '' || inputValue === null) {
                return;
            }

            // Skip if quantity didn't change
            if (currentQty === lastQty) {
                return;
            }

            lastQty = currentQty;
            let qty = currentQty;

            // Validate quantity
            if (isNaN(qty) || qty < 1) {
                qty = lastQty > 0 ? lastQty : 1;
                lastQty = qty;
            }

            // Validate base price
            if (isNaN(basePrice) || basePrice <= 0 || !isFinite(basePrice)) {
                return;
            }

            const total = basePrice * qty;

            // Update DOM only if valid
            if (!isNaN(total) && total > 0 && isFinite(total)) {
                const newText = 'EGP ' + total.toFixed(2);
                if (totalPriceEl.textContent !== newText) {
                    totalPriceEl.textContent = newText;
                }
                // Update sticky price
                if (stickyPriceEl && stickyPriceEl.textContent !== newText) {
                    stickyPriceEl.textContent = newText;
                }
            }
        }

        // Listen to input events
        quantityInput.addEventListener('input', updateTotalPrice);
        quantityInput.addEventListener('change', updateTotalPrice);
        quantityInput.addEventListener('keyup', updateTotalPrice);

        // Polling for theme +/- buttons (100ms)
        let lastValue = quantityInput.value;
        const checkValueChange = function() {
            const currentValue = quantityInput.value;
            if (currentValue !== lastValue) {
                lastValue = currentValue;
                updateTotalPrice();
                // Sync with sticky
                if (stickyQuantityInput) {
                    stickyQuantityInput.value = currentValue;
                }
            }
        };
        setInterval(checkValueChange, 100);

        // MutationObserver as backup
        const observer = new MutationObserver(checkValueChange);
        observer.observe(quantityInput, {
            attributes: true,
            attributeFilter: ['value'],
            characterData: true
        });
        observer.observe(quantityInput.parentNode, {
            childList: true,
            subtree: true
        });

        // Expose function to update base price (for variants)
        window['updateBasePrice' + productId] = function(newPrice) {
            const parsedPrice = parseFloat(newPrice);
            if (!isNaN(parsedPrice) && parsedPrice > 0) {
                basePrice = parsedPrice;
                lastQty = -1; // Force update
                updateTotalPrice();
            }
        };

        // Sync sticky quantity input
        if (stickyQuantityInput) {
            let stickyLastValue = stickyQuantityInput.value;
            const checkStickyValueChange = function() {
                const currentValue = stickyQuantityInput.value;
                if (currentValue !== stickyLastValue) {
                    stickyLastValue = currentValue;
                    quantityInput.value = currentValue;
                    lastValue = currentValue;
                    updateTotalPrice();
                }
            };
            setInterval(checkStickyValueChange, 100);

            const stickyObserver = new MutationObserver(checkStickyValueChange);
            stickyObserver.observe(stickyQuantityInput, {
                attributes: true,
                attributeFilter: ['value']
            });
        }

        // Guard against NaN display
        const priceGuard = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' || mutation.type === 'characterData') {
                    const text = totalPriceEl.textContent;
                    if (text.includes('NaN') || text.includes('nan')) {
                        const validTotal = basePrice * (lastQty || 1);
                        if (!isNaN(validTotal) && isFinite(validTotal)) {
                            totalPriceEl.textContent = 'EGP ' + validTotal.toFixed(2);
                        }
                    }
                }
            });
        });
        priceGuard.observe(totalPriceEl, {
            childList: true,
            characterData: true,
            subtree: true
        });

        // Initial update
        updateTotalPrice();
    })();
</script>
@endif

@if($product->isVariant() && $product->variants->count())
    @php
        $productPageVariants = $product->variants->where('is_active', 1)->map(function($variant) {
            $displayPrice = $variant->sale_price > 0 ? $variant->sale_price : $variant->price;
            return [
                'id' => $variant->id,
                'price' => (float) $displayPrice,
                'original_price' => (float) $variant->price,
                'sale_price' => (float) $variant->sale_price,
                'value_ids' => $variant->values->pluck('id')->values()->all(),
            ];
        })->values();
    @endphp

    <script>
        (function() {
            const variants = @json($productPageVariants);
            const productId = {{ $product->id }};
            const optionsContainer = document.getElementById('productOptions-' + productId);
            if (!optionsContainer) return;

            const priceEl = document.getElementById('productPrice-' + productId);

            // Count total attribute groups
            const attributeGroups = optionsContainer.querySelectorAll('.variant-picker-item');
            const totalAttributeGroups = attributeGroups.length;

            function updatePriceForSelection() {
                const selectedValueIds = [];
                const radioNames = new Set();
                const radios = optionsContainer.querySelectorAll('input[type="radio"]');

                radios.forEach(radio => {
                    if (radio.checked) {
                        radioNames.add(radio.name);
                        const label = optionsContainer.querySelector('label[for="' + radio.id + '"]');
                        if (label) {
                            const valueId = parseInt(label.getAttribute('data-value-id'));
                            if (!isNaN(valueId)) {
                                selectedValueIds.push(valueId);
                            }
                        }
                    }
                });

                const selectedGroups = radioNames.size;

                // Don't try to match if not all attributes are selected
                if (selectedGroups < totalAttributeGroups) {
                    // Clear variant-id
                    const addToCartBtn = document.getElementById('addToCartBtn-' + productId);
                    if (addToCartBtn) {
                        addToCartBtn.removeAttribute('data-variant-id');
                    }
                    return;
                }

                if (!selectedValueIds.length) return;

                // Find matching variant
                const match = variants.find(v => {
                    if (!v.value_ids || v.value_ids.length !== selectedValueIds.length) return false;
                    const sortedA = [...v.value_ids].sort();
                    const sortedB = [...selectedValueIds].sort();
                    return sortedA.every((val, idx) => val === sortedB[idx]);
                });

                if (match && priceEl) {
                    if (match.price === undefined || match.price === null) {
                        return;
                    }

                    const price = parseFloat(match.price);

                    console.log('💰 Variant price:', price, 'isNaN:', isNaN(price), 'isFinite:', isFinite(price));

                    if (!isNaN(price) && isFinite(price) && price > 0) {
                        // Update main display price
                        if (priceEl) {
                            priceEl.textContent = 'EGP ' + price.toFixed(2);
                        }

                        // Update button price (totalPrice)
                        const totalPriceEl = document.getElementById('totalPrice-' + productId);
                        if (totalPriceEl) {
                            totalPriceEl.textContent = 'EGP ' + price.toFixed(2);
                        }

                        // Update base price in quantity widget
                        if (typeof window['updateBasePrice' + productId] === 'function') {
                            window['updateBasePrice' + productId](price);
                        }

                        // Update Add to Cart button variant-id
                        const addToCartBtn = document.getElementById('addToCartBtn-' + productId);
                        if (addToCartBtn) {
                            addToCartBtn.setAttribute('data-variant-id', match.id);
                        }
                    } else {
                        console.error('❌ Invalid price - cannot update:', {
                            price: price,
                            isNaN: isNaN(price),
                            isFinite: isFinite(price),
                            match: match
                        });
                    }
                } else if (!match) {
                    console.warn('⚠️  No matching variant found for selected values');
                }
            }

            // Listen to radio changes
            optionsContainer.addEventListener('change', function(e) {
                if (e.target && e.target.matches('input[type="radio"]')) {
                    // Update selected value label
                    const attributeId = e.target.getAttribute('data-attribute-id');
                    const label = e.target.nextElementSibling;
                    const valueName = label ? label.getAttribute('data-value-name') : '';
                    const valueLabel = document.querySelector('.value-attr-' + attributeId + '-' + productId);

                    if (valueLabel && valueName) {
                        valueLabel.textContent = valueName;
                    }

                    updatePriceForSelection();
                }
            });
        })();
    </script>
@endif

<script>
    // Sticky bar sync and visibility
    (function() {
        const productId = {{ $product->id }};

        // Sticky bar visibility on scroll
        const stickyBar = document.querySelector('.tf-sticky-btn-atc');
        const mainAddToCart = document.querySelector('.tf-product-info-by-btn');

        if (stickyBar && mainAddToCart) {
            window.addEventListener('scroll', function() {
                const mainRect = mainAddToCart.getBoundingClientRect();

                // Show sticky when main add to cart is above viewport
                if (mainRect.bottom < 0) {
                    stickyBar.classList.add('show');
                } else {
                    stickyBar.classList.remove('show');
                }
            });
        }

        // Sync sticky variant options with main form
        @if($product->isVariant())
        document.addEventListener('DOMContentLoaded', function() {
            const mainOptionsContainer = document.getElementById('productOptions-' + productId);
            const stickyOptionsContainer = document.getElementById('stickyVariantOptions-' + productId);

            if (!mainOptionsContainer || !stickyOptionsContainer) return;

            // Track selected values for sticky
            const stickySelectedValues = {};

            // Sticky → Main (When user clicks on sticky dropdown)
            stickyOptionsContainer.querySelectorAll('.sticky-variant-option').forEach(item => {
                item.addEventListener('click', function() {
                    const attributeId = this.getAttribute('data-attribute-id');
                    const valueId = this.getAttribute('data-value-id');
                    const valueName = this.getAttribute('data-value-name');

                    // Update sticky display
                    const displaySpan = document.querySelector('.sticky-attr-value-' + attributeId + '-' + productId);
                    if (displaySpan) {
                        displaySpan.textContent = valueName;
                    }

                    // Store selection
                    stickySelectedValues[attributeId] = { valueId, valueName };

                    // Find and check corresponding radio in main form
                    const mainRadio = mainOptionsContainer.querySelector(`input[type="radio"][data-attribute-id="${attributeId}"][value="${valueId}"]`);
                    if (mainRadio) {
                        mainRadio.checked = true;
                        mainRadio.dispatchEvent(new Event('change', { bubbles: true }));
                    }

                    // Update sticky add to cart button state
                    checkStickyButtonState();
                });
            });

            // Main → Sticky (When user selects in main form)
            mainOptionsContainer.addEventListener('change', function(e) {
                if (e.target && e.target.matches('input[type="radio"]')) {
                    const attributeId = e.target.getAttribute('data-attribute-id');
                    const valueId = e.target.value;
                    const label = e.target.nextElementSibling;
                    const valueName = label ? label.getAttribute('data-value-name') : '';

                    // Update sticky dropdown display
                    const displaySpan = document.querySelector('.sticky-attr-value-' + attributeId + '-' + productId);
                    if (displaySpan && valueName) {
                        displaySpan.textContent = valueName;
                        stickySelectedValues[attributeId] = { valueId, valueName };
                    }

                    // Update sticky price
                    const mainPrice = document.getElementById('productPrice-' + productId);
                    const stickyPrice = document.getElementById('stickyPrice-' + productId);
                    if (mainPrice && stickyPrice) {
                        stickyPrice.textContent = mainPrice.textContent;
                    }

                    // Update selected options text
                    const selectedOptions = [];
                    mainOptionsContainer.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                        const lbl = radio.nextElementSibling;
                        if (lbl) {
                            const vName = lbl.getAttribute('data-value-name');
                            if (vName) selectedOptions.push(vName);
                        }
                    });

                    const stickyOptionsText = document.getElementById('stickySelectedOptions-' + productId);
                    if (stickyOptionsText) {
                        if (selectedOptions.length > 0) {
                            stickyOptionsText.textContent = selectedOptions.join(', ');
                        } else {
                            stickyOptionsText.textContent = 'Select options';
                        }
                    }

                    // Update sticky button state
                    checkStickyButtonState();
                }
            });

            // Check if all attributes are selected for sticky button
            function checkStickyButtonState() {
                const stickyBtn = document.getElementById('stickyAddToCartBtn-' + productId);
                if (!stickyBtn) return;

                const totalAttributes = stickyOptionsContainer.querySelectorAll('.tf-sticky-atc-option').length;
                const selectedCount = Object.keys(stickySelectedValues).length;

                if (selectedCount < totalAttributes) {
                    stickyBtn.classList.add('disabled');
                    stickyBtn.style.opacity = '0.5';
                    stickyBtn.style.cursor = 'not-allowed';
                } else {
                    stickyBtn.classList.remove('disabled');
                    stickyBtn.style.opacity = '1';
                    stickyBtn.style.cursor = 'pointer';
                }
            }

            // Initial check
            checkStickyButtonState();
        });

        // Sticky Add to Cart function with validation
        window['stickyAddToCart{{ $product->id }}'] = function() {
            const stickyBtn = document.getElementById('stickyAddToCartBtn-' + productId);

            // Check if button is disabled
            if (stickyBtn && stickyBtn.classList.contains('disabled')) {
                if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                    window.ShopFeatures.showNotification('Please select all options', 'error');
                }
                return false;
            }

            // Trigger main add to cart
            const mainAddToCartBtn = document.getElementById('addToCartBtn-' + productId);
            if (mainAddToCartBtn && mainAddToCartBtn.onclick) {
                const event = new Event('click');
                mainAddToCartBtn.onclick(event);
            }
        };
        @endif
    })();
</script>


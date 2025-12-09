        <!-- Section product -->
        <section class="pt-0 flat-spacing">
            <div class="container">
                @include('website.pages.shopGender.productsControl')
                <!-- Active Filters Display -->
                @if(request()->has('categories') || request()->has('brands'))
                    <div class="mb-4 tf-active-filters">
                        <div class="flex-wrap gap-2 d-flex align-items-center">
                            <span class="text-caption-1 fw-bold">Active Filters:</span>
                            @if(request()->has('categories'))
                                @foreach(request('categories') as $categoryId)
                                    @php
                                        $category = \App\Models\Category::find($categoryId);
                                    @endphp
                                    @if($category)
                                        <a href="{{ route('shop.all', array_merge(request()->except('categories'), ['categories' => array_diff(request('categories', []), [$categoryId])])) }}"
                                           class="gap-1 px-3 py-2 text-white badge bg-secondary d-inline-flex align-items-center">
                                            {{ $category->name }}
                                            <i class="icon icon-close"></i>
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                            @if(request()->has('brands'))
                                @foreach(request('brands') as $brandId)
                                    @php
                                        $brand = \App\Models\Brand::find($brandId);
                                    @endphp
                                    @if($brand)
                                        <a href="{{ route('shop.all', array_merge(request()->except('brands'), ['brands' => array_diff(request('brands', []), [$brandId])])) }}"
                                           class="gap-1 px-3 py-2 text-white badge bg-secondary d-inline-flex align-items-center">
                                            {{ $brand->name }}
                                            <i class="icon icon-close"></i>
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                            <a href="{{ route('shop.all') }}" class="btn btn-sm btn-outline-secondary">Clear All</a>
                        </div>
                    </div>
                @endif
                <div class="wrapper-control-shop">
                    <div class="meta-filter-shop">
                        <div class="count-text">Showing {{ $products->count() }} of {{ $products->total() }} products</div>
                    </div>
                    <div class="tf-grid-layout wrapper-shop tf-col-5" id="gridLayout">
                        <!-- card product 1 -->
                        @foreach($products as $index => $product)
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
                                       data-in-wishlist="false">
                                        <span class="icon icon-heart"></span>
                                        <span class="tooltip">Add to Wishlist</span>
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
                                @if($product->sale_price > 0)
                                    <span class="price">
                                        <span class="old-price">EGP {{ number_format($product->price, 2) }}</span>
                                        EGP {{ number_format($product->sale_price, 2) }}
                                    </span>
                                @else
                                    <span class="price">EGP {{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="tf-pagination-wrap">
                        {{ $products->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </section>
        @include('website.pages.shopGender.filter')

        <section class="flat-spacing">
            <div class="container">
                <div dir="ltr" class="swiper tf-sw-categories" data-preview="6" data-tablet="4" data-mobile-sm="3" data-mobile="2" data-space-lg="20" data-space-md="20" data-space="15" data-pagination="2" data-pagination-md="2" data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <!-- item 1 -->
                        @foreach ($allSubCategories as $allSubCategory)
                        <div class="swiper-slide">
                            <div class="collection-circle hover-img">
                                <a href="{{ route('shop.category', $allSubCategory->slug) }}" class="img-style">
                                    <img class="lazyload" data-src="{{ $allSubCategory->getFirstMediaUrl('category_image') }}" src="{{ $allSubCategory->getFirstMediaUrl('category_image') }}" alt="collection-img">
                                </a>
                                <div class="text-center collection-content">
                                    <a href="{{ route('shop.category', $allSubCategory->slug) }}" class="cls-title">
                                        <h6 class="text">{{ $allSubCategory->name }}</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="sw-pagination-categories sw-dots type-circle justify-content-center"></div>
                </div>
            </div>
        </section>

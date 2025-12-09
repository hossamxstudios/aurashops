        <section class="space-30">
            <div dir="ltr" class="swiper tf-sw-collection" data-preview="3" data-tablet="2" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                <div class="swiper-wrapper">
                    @foreach ($genders as $gender)
                    <div class="swiper-slide">
                        <div class="collection-position-2 style-4 hover-img wow fadeInUp" data-wow-delay="0s">
                            <a class="img-style">
                                <img class="lazyload" data-src="{{ $gender->getFirstMediaUrl('gender_image') }}" src="{{ $gender->getFirstMediaUrl('gender_image') }}" alt="banner-cls">
                            </a>
                            <div class="content">
                                <a href="{{ route('shop.gender', $gender->slug) }}" class="cls-btn">
                                    <h6 class="text">Shop {{ $gender->name }}</h6><i class="icon icon-arrowUpRight"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="sw-pagination-collection sw-dots type-circle justify-content-center"></div>
            </div>
        </section>

 <section class="pb-5 flat-spacing">
            <div class="container">
                <div class="text-center heading-section wow fadeInUp">
                    <h3 class="heading">Shop by Skin Concern</h3>
                    <p class="subheading text-secondary">Fresh styles just in! Elevate your look.</p>
                </div>
                <div class="tf-grid-layout tf-col-2 md-col-3">

                    @foreach ($categories as $category)
                    <div class="collection-position-2 style-6 hover-img wow fadeInUp" data-wow-delay="0s">
                        <a class="img-style" href="{{ route('shop.category', $category->slug) }}">
                            <img class="ls-is-cached lazyloaded" data-src="{{ $category->getFirstMediaUrl('category_image') }}" src="{{ $category->getFirstMediaUrl('category_image') }}" alt="banner-cls">
                        </a>
                        <div class="content">
                            <a href="{{ route('shop.category', $category->slug) }}" class="cls-btn">
                                <h6 class="text">{{ $category->name }}</h6>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

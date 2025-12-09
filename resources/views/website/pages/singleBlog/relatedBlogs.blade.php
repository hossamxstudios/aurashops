    <section class="pt-0 flat-spacing">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="heading-section">
                            <h3>Related Articles</h3>
                            <p class="body-text-1">Discover the Hottest Fashion News and Trends Straight from the Runway
                            </p>
                        </div>
                        <div dir="ltr" class="swiper tf-sw-recent" data-preview="3" data-tablet="2" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                            <div class="swiper-wrapper">
                                @foreach ($relatedBlogs as $blog)
                                <div class="swiper-slide">
                                    <div class="wg-blog style-1 hover-image">
                                        <div class="image">
                                            <img class="lazyload" data-src="{{ $blog->getMedia('blog-images')->first()?->getUrl() }}"
                                                src="{{ $blog->getMedia('blog-images')->first()?->getUrl() }}" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="meta">
                                                <div class="gap-8 meta-item">
                                                    <div class="icon">
                                                        <i class="icon-calendar"></i>
                                                    </div>
                                                    <p class="text-caption-1">{{ $blog->created_at->format('F j, Y') }}</p>
                                                </div>
                                                <div class="gap-8 meta-item">
                                                    <div class="icon">
                                                        <i class="icon-user"></i>
                                                    </div>
                                                    <p class="text-caption-1">Topic: <a class="link" href="#">{{ $blog->topic?->name }}</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="title fw-5">
                                                    <a class="link" href="{{ route('blog.single', $blog->slug) }}">{{ $blog->title }}</a>
                                                </h6>
                                                <div class="body-text">{{ \Str::limit($blog->content, 100) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="sw-pagination-recent sw-dots type-circle d-flex justify-content-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

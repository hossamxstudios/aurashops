                    <div class="col-lg-8 mb-lg-30">
                        @foreach ($blogs as $blog)
                        <div class="wg-blog style-row hover-image mb_40">
                            <div class="image">
                                <img class="lazyload" data-src="{{ $blog->getMedia('blog-images')?->first()?->getUrl() }}" src="{{ $blog->getMedia('blog-images')?->first()?->getUrl() }}" alt="">
                            </div>
                            <div class="content">
                                <div class="flex-wrap gap-10 d-flex align-items-center justify-content-between">
                                    <div class="meta">
                                        <div class="gap-8 meta-item">
                                            <div class="icon">
                                                <i class="icon-calendar"></i>
                                            </div>
                                            <p class="text-caption-1">{{ $blog->created_at->format('F d, Y') }}</p>
                                        </div>
                                        <div class="gap-8 meta-item">
                                            <div class="icon">
                                                <i class="icon-user"></i>
                                            </div>
                                            <p class="text-caption-1">Topic: <a class="link" href="#">{{ $blog->topic?->name }}</a></p>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="title">
                                    <a class="link" href="{{ route('blog.single', $blog->slug) }}">{{ $blog->title }}</a>
                                </h5>
                                <p>{{ $blog->details }}</p>
                                <a href="{{ route('blog.single', $blog->slug) }}" class="link text-button bot-button">Read More</a>
                            </div>
                        </div>
                        @endforeach
                        <ul class="wg-pagination">
                            {{ $blogs->links() }}
                        </ul>
                    </div>

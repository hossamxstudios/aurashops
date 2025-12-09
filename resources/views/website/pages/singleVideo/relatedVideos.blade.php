    <section class="pt-0 flat-spacing">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="heading-section">
                            <h3>Related Videos</h3>
                            <p class="body-text-1">More videos from this playlist to help you learn
                            </p>
                        </div>
                        <div dir="ltr" class="swiper tf-sw-recent" data-preview="3" data-tablet="2" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                            <div class="swiper-wrapper">
                                @foreach ($relatedVideos as $relatedVideo)
                                <div class="swiper-slide">
                                    <div class="wg-blog style-1 hover-image">
                                        <div class="image">
                                            @if($relatedVideo->link)
                                                @php
                                                    // Extract YouTube video ID
                                                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $relatedVideo->link, $match);
                                                    $videoId = $match[1] ?? null;
                                                @endphp
                                                @if($videoId)
                                                    <img class="lazyload" data-src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" alt="{{ $relatedVideo->title }}">
                                                @else
                                                    <img class="lazyload" data-src="{{ asset('website/images/blog/blog-1.jpg') }}" src="{{ asset('website/images/blog/blog-1.jpg') }}" alt="{{ $relatedVideo->title }}">
                                                @endif
                                            @else
                                                <img class="lazyload" data-src="{{ asset('website/images/blog/blog-1.jpg') }}" src="{{ asset('website/images/blog/blog-1.jpg') }}" alt="{{ $relatedVideo->title }}">
                                            @endif
                                        </div>
                                        <div class="content">
                                            <div class="meta">
                                                <div class="gap-8 meta-item">
                                                    <div class="icon">
                                                        <i class="icon-calendar"></i>
                                                    </div>
                                                    <p class="text-caption-1">{{ $relatedVideo->created_at->format('F j, Y') }}</p>
                                                </div>
                                                <div class="gap-8 meta-item">
                                                    <div class="icon">
                                                        <i class="icon-play"></i>
                                                    </div>
                                                    <p class="text-caption-1">Playlist: <a class="link" href="{{ route('playlist.videos', $relatedVideo->playlist->slug) }}">{{ $relatedVideo->playlist?->name }}</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="title fw-5">
                                                    <a class="link" href="{{ route('video.single', $relatedVideo->slug) }}">{{ $relatedVideo->title }}</a>
                                                </h6>
                                                <div class="body-text">{{ \Str::limit($relatedVideo->details, 100) }}</div>
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

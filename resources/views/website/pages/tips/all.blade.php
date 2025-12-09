                    <div class="col-lg-8 mb-lg-30">
                        @foreach ($videos as $video)
                        <div class="wg-blog style-row hover-image mb_40">
                            <div class="image">
                                @if($video->link)
                                    @php
                                        // Extract YouTube video ID
                                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $video->link, $match);
                                        $videoId = $match[1] ?? null;
                                    @endphp
                                    @if($videoId)
                                        <img class="lazyload" data-src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" alt="{{ $video->title }}">
                                    @else
                                        <img class="lazyload" data-src="{{ asset('website/images/blog/blog-1.jpg') }}" src="{{ asset('website/images/blog/blog-1.jpg') }}" alt="{{ $video->title }}">
                                    @endif
                                @else
                                    <img class="lazyload" data-src="{{ asset('website/images/blog/blog-1.jpg') }}" src="{{ asset('website/images/blog/blog-1.jpg') }}" alt="{{ $video->title }}">
                                @endif
                            </div>
                            <div class="content">
                                <div class="flex-wrap gap-10 d-flex align-items-center justify-content-between">
                                    <div class="meta">
                                        <div class="gap-8 meta-item">
                                            <div class="icon">
                                                <i class="icon-calendar"></i>
                                            </div>
                                            <p class="text-caption-1">{{ $video->created_at->format('F d, Y') }}</p>
                                        </div>
                                        <div class="gap-8 meta-item">
                                            <div class="icon">
                                                <i class="icon-user"></i>
                                            </div>
                                            <p class="text-caption-1">Playlist: <a class="link" href="{{ route('playlist.videos', $video->playlist->slug) }}">{{ $video->playlist?->name }}</a></p>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="title">
                                    <a class="link" href="{{ route('video.single', $video->slug) }}">{{ $video->title }}</a>
                                </h5>
                                <p>{{ Str::limit($video->details, 150) }}</p>
                                <a href="{{ route('video.single', $video->slug) }}" class="link text-button bot-button">Watch Video</a>
                            </div>
                        </div>
                        @endforeach
                        <ul class="wg-pagination">
                            {{ $videos->links() }}
                        </ul>
                    </div>

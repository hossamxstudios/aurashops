 <div class="col-lg-4">
     <div class="sidebar maxw-360">
         <div class="sidebar-item sidebar-relatest-post">
             <h5 class="sidebar-heading">Related Videos</h5>
             <div>
                @foreach ($relatedVideos as $relatedVideo)
                    @if($loop->iteration == 1)
                    <div class="relatest-post-item hover-image">
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
                                    <p class="text-caption-1">Playlist: <a class="link" href="{{ route('playlist.videos', $relatedVideo->playlist->slug) }}">{{ $relatedVideo->playlist->name }}</a>
                                    </p>
                                </div>
                            </div>
                            <h6 class="title fw-5">
                                <a class="link" href="{{ route('video.single', $relatedVideo->slug) }}">{{ $relatedVideo->title }}</a>
                            </h6>
                        </div>
                    </div>
                    @else
                    <div class="relatest-post-item style-row hover-image">
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
                                    <p class="text-caption-1">{{ $relatedVideo->created_at->format('F j, Y') }}</p>
                                </div>
                                <div class="gap-8 meta-item">
                                    <p class="text-caption-1">Playlist: <a class="link" href="{{ route('playlist.videos', $relatedVideo->playlist->slug) }}">{{ $relatedVideo->playlist->name }}</a>
                                    </p>
                                </div>
                            </div>
                            <div class="title text-title">
                                <a class="link" href="{{ route('video.single', $relatedVideo->slug) }}">{{ $relatedVideo->title }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
             </div>
         </div>
     </div>
 </div>

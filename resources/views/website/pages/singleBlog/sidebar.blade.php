 <div class="col-lg-4">
     <div class="sidebar maxw-360">
         <div class="sidebar-item sidebar-relatest-post">
             <h5 class="sidebar-heading">Relatest Blogs</h5>
             <div>
                @foreach ($relatedBlogs as $blog)
                    @if($loop->iteration ==1)
                    <div class="relatest-post-item hover-image">
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
                                    <p class="text-caption-1">Topic: <a class="link" href="#">{{ $blog->topic->name }}</a>
                                    </p>
                                </div>
                            </div>
                            <h6 class="title fw-5">
                                <a class="link" href="{{ route('blog.single', $blog->slug) }}">{{ $blog->title }}</a>
                            </h6>
                        </div>
                    </div>
                    @else
                    <div class="relatest-post-item style-row hover-image">
                        <div class="image">
                            <img class="lazyload" data-src="{{ $blog->getMedia('blog-images')->first()?->getUrl() }}"
                                src="{{ $blog->getMedia('blog-images')->first()?->getUrl() }}" alt="">
                        </div>
                        <div class="content">
                            <div class="meta">
                                <div class="gap-8 meta-item">
                                    <p class="text-caption-1">{{ $blog->created_at->format('F j, Y') }}</p>
                                </div>
                                <div class="gap-8 meta-item">
                                    <p class="text-caption-1">Topic: <a class="link" href="#">{{ $blog->topic->name }}</a>
                                    </p>
                                </div>
                            </div>
                            <div class="title text-title">
                                <a class="link" href="{{ route('blog.single', $blog->slug) }}">{{ $blog->title }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
             </div>
         </div>
     </div>
 </div>

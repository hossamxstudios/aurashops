  <div class="col-lg-8 mb-lg-30">
      <div class="blog-detail-wrap page-single-2">
          <div class="inner">
              <div class="heading">
                  <ul class="list-tags has-bg">
                      <li>
                          <a href="{{ route('topic.blogs', $blog->topic?->slug) }}" class="link">{{ $blog->topic?->name }}</a>
                      </li>
                  </ul>
                  <h3 class="fw-5">{{ $blog->title }}</h3>
                  <div class="meta">
                      <div class="gap-8 meta-item">
                          <div class="icon">
                              <i class="icon-calendar"></i>
                          </div>
                          <p class="body-text-1">{{ $blog->created_at->format('F j, Y') }}</p>
                      </div>
                      <div class="gap-8 meta-item">
                          <div class="icon">
                              <i class="icon-user"></i>
                          </div>
                          <p class="body-text-1">Topic: <a class="link" href="{{ route('topic.blogs', $blog->topic?->slug) }}">{{ $blog->topic?->name }}</a></p>
                      </div>
                  </div>
              </div>
              <div class="image">
                  <img class="lazyload" data-src="{{ $blog->getMedia('blog-images')->first()?->getUrl() }}" src="{{ $blog->getMedia('blog-images')->first()?->getUrl() }}"
                      alt="">
              </div>
              <div class="content">
                  <p class="body-text-1 mb_12">{{ $blog->content }}</p>
              </div>
              <div class="gap-20 group-image d-flex">
                  <div>
                      <img src="{{ $blog->getMedia('blog-images')->first()?->getUrl() }}" alt="">
                  </div>
                  <div>
                      <img src="{{ $blog->getMedia('blog-images')->first()?->getUrl() }}" alt="">
                  </div>
              </div>

              <div class="flex-wrap gap-10 bot d-flex justify-content-between">
                  <ul class="list-tags has-bg">
                      <li>Topics:</li>
                      @foreach ($topics as $topic)
                          <li>
                              <a href="#" class="link">{{ $topic->name }}</a>
                          </li>
                      @endforeach
                  </ul>
                  <div class="gap-16 d-flex align-items-center justify-content-between">
                      <p>Share this post:</p>
                      <ul class="tf-social-icon style-1">
                          <li><a href="#" class="social-facebook"><i class="icon icon-fb"></i></a>
                          </li>
                          <li><a href="#" class="social-twiter"><i class="icon icon-x"></i></a></li>
                          <li><a href="#" class="social-pinterest"><i class="icon icon-pinterest"></i></a></li>
                          <li><a href="#" class="social-instagram"><i class="icon icon-instagram"></i></a></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>

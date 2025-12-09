  <div class="col-lg-8 mb-lg-30">
      <div class="blog-detail-wrap page-single-2">
          <div class="inner">
              <div class="heading">
                  <ul class="list-tags has-bg">
                      <li>
                          <a href="{{ route('playlist.videos', $video->playlist?->slug) }}" class="link">{{ $video->playlist?->name }}</a>
                      </li>
                  </ul>
                  <h3 class="fw-5">{{ $video->title }}</h3>
                  <div class="meta">
                      <div class="gap-8 meta-item">
                          <div class="icon">
                              <i class="icon-calendar"></i>
                          </div>
                          <p class="body-text-1">{{ $video->created_at->format('F j, Y') }}</p>
                      </div>
                      <div class="gap-8 meta-item">
                          <div class="icon">
                              <i class="icon-user"></i>
                          </div>
                          <p class="body-text-1">Playlist: <a class="link" href="{{ route('playlist.videos', $video->playlist?->slug) }}">{{ $video->playlist?->name }}</a></p>
                      </div>
                  </div>
              </div>
              <div class="video-wrapper mb_30">
                  @if($video->link)
                      @php
                          // Extract YouTube video ID
                          preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $video->link, $match);
                          $videoId = $match[1] ?? null;
                      @endphp
                      @if($videoId)
                          <div class="ratio ratio-16x9">
                              <iframe src="https://www.youtube.com/embed/{{ $videoId }}" title="{{ $video->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                          </div>
                      @else
                          <div class="alert alert-warning">Invalid video link</div>
                      @endif
                  @else
                      <div class="alert alert-info">No video available</div>
                  @endif
              </div>
              <div class="content">
                  <p class="body-text-1 mb_12">{{ $video->details }}</p>
              </div>

              <div class="flex-wrap gap-10 bot d-flex justify-content-between">
                  <ul class="list-tags has-bg">
                      <li>Playlists:</li>
                      @foreach ($allPlaylists as $playlist)
                          <li>
                              <a href="{{ route('playlist.videos', $playlist->slug) }}" class="link">{{ $playlist->name }}</a>
                          </li>
                      @endforeach
                  </ul>
                  <div class="gap-16 d-flex align-items-center justify-content-between">
                      <p>Share this video:</p>
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

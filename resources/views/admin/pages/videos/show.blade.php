<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Video Details</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="py-3 row justify-content-center">
                        <div class="col-12">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('admin.videos.index') }}" class="mb-2 btn btn-outline-secondary btn-sm">
                                        <i data-lucide="arrow-left" class="icon-sm me-1"></i> Back
                                    </a>
                                    <h3 class="mb-1 fw-bold">{{ $video->title }}</h3>
                                    <p class="mb-0 text-muted">
                                        <span class="badge bg-info me-2">{{ $video->playlist->name }}</span>
                                    </p>
                                </div>
                                <div>
                                    <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn btn-primary btn-sm">
                                        <i data-lucide="edit" class="icon-sm me-1"></i> Edit
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteVideo({{ $video->id }}, '{{ $video->title }}')">
                                        <i data-lucide="trash-2" class="icon-sm me-1"></i> Delete
                                    </button>
                                </div>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Video Embed -->
                                    <div class="mb-3 card">
                                        <div class="card-body">
                                            <div class="ratio ratio-16x9">
                                                @php
                                                    $embedUrl = $video->link;
                                                    if (str_contains($video->link, 'youtube.com/watch')) {
                                                        parse_str(parse_url($video->link, PHP_URL_QUERY), $params);
                                                        $embedUrl = 'https://www.youtube.com/embed/' . ($params['v'] ?? '');
                                                    } elseif (str_contains($video->link, 'youtu.be/')) {
                                                        $videoId = basename(parse_url($video->link, PHP_URL_PATH));
                                                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                                    } elseif (str_contains($video->link, 'vimeo.com')) {
                                                        $videoId = basename(parse_url($video->link, PHP_URL_PATH));
                                                        $embedUrl = 'https://player.vimeo.com/video/' . $videoId;
                                                    }
                                                @endphp
                                                <iframe src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Details -->
                                    @if($video->details)
                                        <div class="mb-3 card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0">{{ $video->details }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <!-- Info -->
                                    <div class="mb-3 card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="text-muted fs-sm">Playlist</label>
                                                <div><strong>{{ $video->playlist->name }}</strong></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-muted fs-sm">Slug</label>
                                                <div><code>{{ $video->slug }}</code></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-muted fs-sm">Video Link</label>
                                                <div>
                                                    <a href="{{ $video->link }}" target="_blank" class="text-break">
                                                        {{ Str::limit($video->link, 40) }}
                                                        <i data-lucide="external-link" class="icon-sm ms-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-muted fs-sm">Created At</label>
                                                <div>{{ $video->created_at->format('M d, Y h:i A') }}</div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="text-muted fs-sm">Updated At</label>
                                                <div>{{ $video->updated_at->format('M d, Y h:i A') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
    @include('admin.pages.videos.deleteModal')
</body>
</html>

<script>
    function deleteVideo(id, title) {
        document.getElementById('deleteVideoTitle').textContent = title;
        document.getElementById('deleteForm').action = `/admin/videos/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>

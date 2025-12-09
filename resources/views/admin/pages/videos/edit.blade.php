<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Edit Video</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="py-3 row justify-content-center">
                        <div class="col-xxl-8 col-xl-10">
                            <a href="{{ route('admin.videos.show', $video->id) }}" class="mb-2 btn btn-outline-secondary btn-sm">
                                <i data-lucide="arrow-left" class="icon-sm me-1"></i> Back to Video
                            </a>
                            <h3 class="mb-3 fw-bold">Edit Video</h3>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.videos.update', $video->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3 card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Playlist <span class="text-danger">*</span></label>
                                            <select class="form-select" name="playlist_id" required>
                                                <option value="">Choose playlist...</option>
                                                @foreach($playlists as $playlist)
                                                    <option value="{{ $playlist->id }}" {{ $video->playlist_id == $playlist->id ? 'selected' : '' }}>
                                                        {{ $playlist->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="title" value="{{ $video->title }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                            <input type="text" class="form-control" name="slug" value="{{ $video->slug }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Video Link <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="link" value="{{ $video->link }}" required>
                                            <small class="text-muted">YouTube, Vimeo, or any video URL</small>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label">Details</label>
                                            <textarea class="form-control" name="details" rows="5">{{ $video->details }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i data-lucide="save" class="icon-sm me-1"></i> Update Video
                                    </button>
                                    <a href="{{ route('admin.videos.show', $video->id) }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
</body>
</html>

<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <a href="{{ route('admin.videos.create') }}" class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm">
            <i data-lucide="plus" class="fs-sm me-1"></i> New Video
        </a>
        <h3 class="fw-bold">Videos</h3>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.videos.index') }}">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Search videos..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="playlist_id">
                        <option value="">All Playlists</option>
                        @foreach($playlists as $playlist)
                            <option value="{{ $playlist->id }}" {{ request('playlist_id') == $playlist->id ? 'selected' : '' }}>
                                {{ $playlist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i data-lucide="search" class="icon-sm me-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.videos.index') }}" class="btn btn-outline-secondary w-100">
                        <i data-lucide="x" class="icon-sm me-1"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Playlist</th>
                        <th>Link</th>
                        <th>Created</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($videos as $video)
                        <tr>
                            <td><strong>#{{ $video->id }}</strong></td>
                            <td>
                                <strong>{{ $video->title }}</strong>
                                @if($video->details)
                                    <br><small class="text-muted">{{ Str::limit($video->details, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $video->playlist->name }}</span>
                            </td>
                            <td>
                                <a href="{{ $video->link }}" target="_blank" class="text-decoration-none">
                                    <i data-lucide="external-link" class="icon-sm"></i>
                                </a>
                            </td>
                            <td><small>{{ $video->created_at->format('M d, Y') }}</small></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.videos.show', $video->id) }}" class="btn btn-outline-info" title="View">
                                        <i data-lucide="eye" class="icon-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn btn-outline-primary" title="Edit">
                                        <i data-lucide="edit" class="icon-sm"></i>
                                    </a>
                                    <button class="btn btn-outline-danger" onclick="deleteVideo({{ $video->id }}, '{{ $video->title }}')" title="Delete">
                                        <i data-lucide="trash-2" class="icon-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i data-lucide="inbox" class="icon-lg mb-2" style="opacity: 0.3;"></i>
                                <p class="mb-0">No videos found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $videos->links() }}
        </div>
    </div>
</div>

@include('admin.pages.videos.deleteModal')

<style>
    .btn-group .btn {border-radius: 0;}
    .btn-group .btn:first-child {border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;}
    .btn-group .btn:last-child {border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;}
</style>

<script>
    function deleteVideo(id, title) {
        document.getElementById('deleteVideoTitle').textContent = title;
        document.getElementById('deleteForm').action = `/admin/videos/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

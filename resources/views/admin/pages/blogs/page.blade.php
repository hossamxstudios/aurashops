<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <a href="{{ route('admin.blogs.create') }}" class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm">
            <i data-lucide="plus" class="fs-sm me-1"></i> New Blog
        </a>
        <h3 class="fw-bold">Blogs</h3>
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
        <form method="GET" action="{{ route('admin.blogs.index') }}">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="search" placeholder="Search blogs..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="topic_id">
                        <option value="">All Topics</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}" {{ request('topic_id') == $topic->id ? 'selected' : '' }}>
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="is_active">
                        <option value="">All Status</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i data-lucide="search" class="icon-sm me-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary w-100">
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
                        <th width="80">Image</th>
                        <th>Title</th>
                        <th>Topic</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Created</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                        <tr>
                            <td>
                                @if($blog->getFirstMediaUrl('blog-images'))
                                    <img src="{{ $blog->getFirstMediaUrl('blog-images', 'thumb') }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $blog->title }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i data-lucide="image" class="text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $blog->title }}</strong>
                                @if($blog->subtitle)
                                    <br><small class="text-muted">{{ Str::limit($blog->subtitle, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $blog->topic->name }}</span>
                            </td>
                            <td>
                                @if($blog->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $blog->views }}</span>
                            </td>
                            <td><small>{{ $blog->created_at->format('M d, Y') }}</small></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-outline-info" title="View">
                                        <i data-lucide="eye" class="icon-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-outline-primary" title="Edit">
                                        <i data-lucide="edit" class="icon-sm"></i>
                                    </a>
                                    <button class="btn btn-outline-danger" onclick="deleteBlog({{ $blog->id }}, '{{ $blog->title }}')" title="Delete">
                                        <i data-lucide="trash-2" class="icon-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i data-lucide="inbox" class="icon-lg mb-2" style="opacity: 0.3;"></i>
                                <p class="mb-0">No blogs found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $blogs->links() }}
        </div>
    </div>
</div>

@include('admin.pages.blogs.deleteModal')

<style>
    .btn-group .btn {border-radius: 0;}
    .btn-group .btn:first-child {border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;}
    .btn-group .btn:last-child {border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;}
</style>

<script>
    function deleteBlog(id, title) {
        document.getElementById('deleteBlogTitle').textContent = title;
        document.getElementById('deleteForm').action = `/admin/blogs/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Blog Details</title>
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
                                    <a href="{{ route('admin.blogs.index') }}" class="mb-2 btn btn-outline-secondary btn-sm">
                                        <i data-lucide="arrow-left" class="icon-sm me-1"></i> Back
                                    </a>
                                    <h3 class="mb-1 fw-bold">{{ $blog->title }}</h3>
                                    <p class="mb-0 text-muted">
                                        <span class="badge bg-info me-2">{{ $blog->topic->name }}</span>
                                        @if($blog->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary btn-sm">
                                        <i data-lucide="edit" class="icon-sm me-1"></i> Edit
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteBlog({{ $blog->id }}, '{{ $blog->title }}')">
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
                                    <!-- Featured Image -->
                                    @if($blog->getFirstMediaUrl('blog-images'))
                                        <div class="mb-3 card">
                                            <div class="card-body">
                                                <img src="{{ $blog->getFirstMediaUrl('blog-images') }}" class="img-fluid rounded" alt="{{ $blog->title }}">
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Content -->
                                    <div class="mb-3 card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Content</h5>
                                        </div>
                                        <div class="card-body">
                                            @if($blog->subtitle)
                                                <p class="lead">{{ $blog->subtitle }}</p>
                                                <hr>
                                            @endif
                                            <div class="blog-content">
                                                {!! nl2br(e($blog->content)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Info -->
                                    <div class="mb-3 card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="text-muted fs-sm">Slug</label>
                                                <div><code>{{ $blog->slug }}</code></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-muted fs-sm">Views</label>
                                                <div><strong>{{ number_format($blog->views) }}</strong></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-muted fs-sm">Created At</label>
                                                <div>{{ $blog->created_at->format('M d, Y h:i A') }}</div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="text-muted fs-sm">Updated At</label>
                                                <div>{{ $blog->updated_at->format('M d, Y h:i A') }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SEO -->
                                    <div class="mb-3 card">
                                        <div class="card-header">
                                            <h5 class="mb-0">SEO Meta Tags</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="text-muted fs-sm">Meta Title</label>
                                                <div>{{ $blog->meta_title ?: 'Not set' }}</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-muted fs-sm">Meta Description</label>
                                                <div>{{ $blog->meta_desc ?: 'Not set' }}</div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="text-muted fs-sm">Meta Keywords</label>
                                                <div>{{ $blog->meta_keywords ?: 'Not set' }}</div>
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
    @include('admin.pages.blogs.deleteModal')
</body>
</html>

<script>
    function deleteBlog(id, title) {
        document.getElementById('deleteBlogTitle').textContent = title;
        document.getElementById('deleteForm').action = `/admin/blogs/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>

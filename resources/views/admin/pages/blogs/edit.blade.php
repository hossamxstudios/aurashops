<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Edit Blog</title>
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
                            <a href="{{ route('admin.blogs.show', $blog->id) }}" class="mb-2 btn btn-outline-secondary btn-sm">
                                <i data-lucide="arrow-left" class="icon-sm me-1"></i> Back to Blog
                            </a>
                            <h3 class="mb-3 fw-bold">Edit Blog</h3>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3 card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Topic <span class="text-danger">*</span></label>
                                            <select class="form-select" name="topic_id" required>
                                                <option value="">Choose topic...</option>
                                                @foreach($topics as $topic)
                                                    <option value="{{ $topic->id }}" {{ $blog->topic_id == $topic->id ? 'selected' : '' }}>
                                                        {{ $topic->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="title" value="{{ $blog->title }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Subtitle</label>
                                            <input type="text" class="form-control" name="subtitle" value="{{ $blog->subtitle }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                            <input type="text" class="form-control" name="slug" value="{{ $blog->slug }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Content</label>
                                            <textarea class="form-control" name="content" rows="10">{{ $blog->content }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Featured Image</label>
                                            @if($blog->getFirstMediaUrl('blog-images'))
                                                <div class="mb-2">
                                                    <img src="{{ $blog->getFirstMediaUrl('blog-images', 'thumb') }}" class="rounded" style="max-width: 200px;">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                            <small class="text-muted">Upload new image to replace existing one. Max file size: 2MB</small>
                                        </div>

                                        <div class="mb-0">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $blog->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 card">
                                    <div class="card-header">
                                        <h5 class="mb-0">SEO Meta Tags</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Meta Title</label>
                                            <input type="text" class="form-control" name="meta_title" value="{{ $blog->meta_title }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Meta Description</label>
                                            <textarea class="form-control" name="meta_desc" rows="3">{{ $blog->meta_desc }}</textarea>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label">Meta Keywords</label>
                                            <input type="text" class="form-control" name="meta_keywords" value="{{ $blog->meta_keywords }}">
                                            <small class="text-muted">Separate keywords with commas</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i data-lucide="save" class="icon-sm me-1"></i> Update Blog
                                    </button>
                                    <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-secondary">
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

<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Tags</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="py-1 pt-4 row">
                        <div class="col-12">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="fw-bold">Tags Management</h3>
                                    <p class="text-muted">Manage product tags for better organization</p>
                                </div>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTagModal">
                                    <i class="ti ti-plus me-1"></i>Add New Tag
                                </button>
                            </div>
                        </div>
                    </div>

                    @include('admin.main.messages')

                    <!-- Tags Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    @if($tags->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table align-middle table-hover">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="border-0">#</th>
                                                        <th class="border-0">Tag Name</th>
                                                        <th class="border-0">Products Count</th>
                                                        <th class="border-0">Created Date</th>
                                                        <th class="border-0 text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tags as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="rounded me-2 bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                                        <i class="ti ti-tag text-primary"></i>
                                                                    </div>
                                                                    <span class="fw-semibold">{{ $item->name }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-info-subtle text-info">
                                                                    {{ $item->products->count() }} Products
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <small class="text-muted">{{ $item->created_at->format('M d, Y') }}</small>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="gap-1 d-flex justify-content-end">
                                                                    <a href="{{ route('admin.tags.edit', $item->id) }}" class="btn btn-light btn-sm" title="Edit">
                                                                        <i class="ti ti-edit"></i>
                                                                    </a>
                                                                    <button class="btn btn-danger-subtle text-danger btn-sm" onclick="deleteTag({{ $item->id }}, '{{ $item->name }}')" title="Delete">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="py-5 text-center">
                                            <i class="ti ti-tag text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <h6 class="mt-3 text-muted fw-semibold">No Tags Yet</h6>
                                            <p class="text-muted">Create your first tag to start organizing products</p>
                                            <button class="mt-2 btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTagModal">
                                                <i class="ti ti-plus me-1"></i>Add New Tag
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Tag Modal -->
    <div class="modal fade" id="addTagModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="border-0 shadow modal-content">
                <div class="border-0 modal-header bg-light">
                    <h5 class="modal-title fw-semibold">
                        <i class="ti ti-plus me-2 text-primary"></i>Add New Tag
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.tags.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tag_name" class="form-label fw-medium">Tag Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="tag_name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Choose a clear, descriptive name for the tag</small>
                        </div>
                    </div>
                    <div class="border-0 modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i>Create Tag
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Tag Modal -->
    @if(isset($tag))
    <div class="modal fade show" id="editTagModal" tabindex="-1" style="display: block;">
        <div class="modal-dialog">
            <div class="border-0 shadow modal-content">
                <div class="border-0 modal-header bg-light">
                    <h5 class="modal-title fw-semibold">
                        <i class="ti ti-edit me-2 text-primary"></i>Edit Tag
                    </h5>
                    <button type="button" class="btn-close" onclick="window.location='{{ route('admin.tags.index') }}'"></button>
                </div>
                <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_tag_name" class="form-label fw-medium">Tag Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_tag_name" name="name" value="{{ old('name', $tag->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="border-0 modal-footer">
                        <button type="button" class="btn btn-light" onclick="window.location='{{ route('admin.tags.index') }}'">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i>Update Tag
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Delete Tag Modal -->
    <div class="modal fade" id="deleteTagModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="border-0 shadow modal-content">
                <div class="border-0 modal-header bg-danger-subtle">
                    <h5 class="modal-title text-danger">
                        <i class="ti ti-alert-triangle me-2"></i>Delete Tag
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="py-4 text-center modal-body">
                    <div class="mb-3">
                        <div class="mx-auto mb-3 avatar-xl">
                            <div class="rounded-circle avatar-title bg-danger-subtle text-danger">
                                <i class="ti ti-trash fs-1"></i>
                            </div>
                        </div>
                        <h5 class="mb-2">Are you sure?</h5>
                        <p class="mb-0 text-muted">Do you really want to delete tag: <strong id="tagName"></strong>?</p>
                        <p class="text-muted">This action cannot be undone.</p>
                    </div>
                </div>
                <div class="border-0 modal-footer">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i>Delete Tag
                        </button>
                    </form>
                </div>
            </div>
            @include('admin.main.footer')
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')

    <script>
        function deleteTag(id, name) {
            document.getElementById('tagName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/tags/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('deleteTagModal'));
            modal.show();
        }

        @if(isset($tag))
            // Auto-show edit modal
            document.addEventListener('DOMContentLoaded', function() {
                const editModal = document.getElementById('editTagModal');
                if (editModal) {
                    editModal.style.display = 'block';
                    document.body.classList.add('modal-open');
                }
            });
        @endif

        @if($errors->any() && !isset($tag))
            // Reopen add modal if there are validation errors
            document.addEventListener('DOMContentLoaded', function() {
                const addModal = new bootstrap.Modal(document.getElementById('addTagModal'));
                addModal.show();
            });
        @endif
    </script>
</body>
</html>

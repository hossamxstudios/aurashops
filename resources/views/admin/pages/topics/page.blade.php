<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <button class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> New Topic
        </button>
        <h3 class="fw-bold">Blog Topics</h3>
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

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Blogs Count</th>
                        <th>Created</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topics as $topic)
                        <tr>
                            <td><strong>#{{ $topic->id }}</strong></td>
                            <td><strong>{{ $topic->name }}</strong></td>
                            <td><code>{{ $topic->slug }}</code></td>
                            <td>
                                <span class="badge bg-primary">{{ $topic->blogs_count }} blogs</span>
                            </td>
                            <td><small>{{ $topic->created_at->format('M d, Y') }}</small></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" onclick="editTopic({{ $topic->id }})" title="Edit">
                                        <i data-lucide="edit" class="icon-sm"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="deleteTopic({{ $topic->id }}, '{{ $topic->name }}')" title="Delete">
                                        <i data-lucide="trash-2" class="icon-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i data-lucide="inbox" class="icon-lg mb-2" style="opacity: 0.3;"></i>
                                <p class="mb-0">No topics found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $topics->links() }}
        </div>
    </div>
</div>

@include('admin.pages.topics.createModal')
@include('admin.pages.topics.editModal')
@include('admin.pages.topics.deleteModal')

<style>
    .btn-group .btn {border-radius: 0;}
    .btn-group .btn:first-child {border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;}
    .btn-group .btn:last-child {border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;}
</style>

<script>
    function editTopic(id) {
        fetch(`/admin/topics/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/topics/${id}`;
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_slug').value = data.slug;
                document.getElementById('edit_details').value = data.details || '';
                
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
    }

    function deleteTopic(id, name) {
        document.getElementById('deleteTopicName').textContent = name;
        document.getElementById('deleteForm').action = `/admin/topics/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

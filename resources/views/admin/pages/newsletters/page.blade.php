<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <button class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> Add Subscription
        </button>
        <a href="{{ route('admin.newsletters.export', request()->query()) }}" class="px-2 py-1 mb-2 shadow badge badge-success fw-normal fst-italic fs-sm">
            <i data-lucide="download" class="fs-sm me-1"></i> Export Emails
        </a>
        <h3 class="fw-bold">Newsletter Subscriptions</h3>
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
        <form method="GET" action="{{ route('admin.newsletters.index') }}">
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="search" placeholder="Search by email or client name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="type">
                        <option value="">All Types</option>
                        <option value="guest" {{ request('type') === 'guest' ? 'selected' : '' }}>Guest Subscriptions</option>
                        <option value="client" {{ request('type') === 'client' ? 'selected' : '' }}>Client Subscriptions</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i data-lucide="search" class="icon-sm me-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.newsletters.index') }}" class="btn btn-outline-secondary w-100">
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
                        <th>Email</th>
                        <th>Client</th>
                        <th>Type</th>
                        <th>Subscribed At</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($newsletters as $newsletter)
                        <tr>
                            <td><strong>#{{ $newsletter->id }}</strong></td>
                            <td>
                                <i data-lucide="mail" class="icon-sm me-1 text-muted"></i>
                                {{ $newsletter->email }}
                            </td>
                            <td>
                                @if($newsletter->client)
                                    <span class="badge bg-info">{{ $newsletter->client->full_name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($newsletter->client_id)
                                    <span class="badge bg-primary">Client</span>
                                @else
                                    <span class="badge bg-secondary">Guest</span>
                                @endif
                            </td>
                            <td><small>{{ $newsletter->created_at->format('M d, Y h:i A') }}</small></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" onclick="editNewsletter({{ $newsletter->id }})" title="Edit">
                                        <i data-lucide="edit" class="icon-sm"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="deleteNewsletter({{ $newsletter->id }}, '{{ $newsletter->email }}')" title="Delete">
                                        <i data-lucide="trash-2" class="icon-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i data-lucide="inbox" class="icon-lg mb-2" style="opacity: 0.3;"></i>
                                <p class="mb-0">No newsletter subscriptions found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $newsletters->links() }}
        </div>
    </div>
</div>

@include('admin.pages.newsletters.createModal')
@include('admin.pages.newsletters.editModal')
@include('admin.pages.newsletters.deleteModal')

<style>
    .btn-group .btn {border-radius: 0;}
    .btn-group .btn:first-child {border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;}
    .btn-group .btn:last-child {border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;}
</style>

<script>
    function editNewsletter(id) {
        fetch(`/admin/newsletters/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/newsletters/${id}`;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_client_id').value = data.client_id || '';
                
                // Update email field requirement based on client selection
                const editEmailInput = document.getElementById('edit_email');
                const editRequiredStar = document.getElementById('edit_email_required_star');
                const editOptionalNote = document.getElementById('edit_email_optional_note');
                
                if (data.client_id) {
                    editEmailInput.removeAttribute('required');
                    editRequiredStar.classList.add('d-none');
                    editOptionalNote.classList.remove('d-none');
                } else {
                    editEmailInput.setAttribute('required', 'required');
                    editRequiredStar.classList.remove('d-none');
                    editOptionalNote.classList.add('d-none');
                }
                
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
    }

    function deleteNewsletter(id, email) {
        document.getElementById('deleteNewsletterEmail').textContent = email;
        document.getElementById('deleteForm').action = `/admin/newsletters/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

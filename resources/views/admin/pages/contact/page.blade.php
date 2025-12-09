<div class="py-1 pt-4 row justify-content-center">
    {{-- <div class="text-center col-xxl-5 col-xl-7">
        <button class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" data-bs-toggle="modal" data-bs-target="#">
             All Contact Forms
        </button>
        <a href="{{ route('admin.newsletters.export', request()->query()) }}" class="px-2 py-1 mb-2 shadow text-dark badge badge-primary fw-normal fst-italic fs-sm">
            <i data-lucide="download" class="fs-sm me-1"></i> Export Emails
        </a>
    </div> --}}
    <h3 class="fw-bold">Contact Forms</h3>
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
<div class="mb-3 card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.contact-forms.index') }}">
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="search" placeholder="Search by email or client name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i data-lucide="search" class="icon-sm me-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.contact-forms.index') }}" class="btn btn-outline-secondary w-100">
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Subscribed At</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contactForms as $contactForm)
                        <tr>
                            <td><strong>#{{ $contactForm->id }}</strong></td>
                            <td>{{ $contactForm->name }}</td>
                            <td>
                                <i data-lucide="mail" class="icon-sm me-1 text-muted"></i>
                                {{ $contactForm->email }}
                            </td>
                            <td>
                                {{ $contactForm->phone }}
                            </td>
                            <td>
                                {{ $contactForm->message }}
                            </td>
                            <td>
                                {{ $contactForm->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-danger" onclick="deleteContactForm({{ $contactForm->id }}, '{{ $contactForm->email }}')" title="Delete">
                                        <i data-lucide="trash-2" class="icon-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-muted">
                                <i data-lucide="inbox" class="mb-2 icon-lg" style="opacity: 0.3;"></i>
                                <p class="mb-0">No contact forms found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $contactForms->links() }}
        </div>
    </div>
</div>
@include('admin.pages.contact.deleteModal')

<style>
    .btn-group .btn {border-radius: 0;}
    .btn-group .btn:first-child {border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;}
    .btn-group .btn:last-child {border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;}
</style>

<script>
    function deleteContactForm(id, email) {
        document.getElementById('deleteNewsletterEmail').textContent = email;
        document.getElementById('deleteForm').action = `/admin/contact-forms/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

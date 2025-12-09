<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> Add Payment Method
        </span>
        <h3 class="fw-bold">
            Payment Methods
        </h3>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Search Filter -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i data-lucide="search" class="icon-sm"></i></span>
                                <input type="text" id="searchMethods" class="form-control" placeholder="Search by name or details...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 table-hover table-centered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="methodsTableBody">
                            @forelse($paymentMethods as $method)
                                <tr>
                                    <td>{{ $method->id }}</td>
                                    <td>
                                        @if($method->hasMedia('icon'))
                                            <img src="{{ $method->getFirstMediaUrl('icon') }}" alt="{{ $method->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: contain;">
                                        @else
                                            <span class="text-muted small">No icon</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $method->name }}</span>
                                    </td>
                                    <td>
                                        <code class="small">{{ $method->slug }}</code>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $method->details }}</small>
                                    </td>
                                    <td>
                                        @if($method->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-light" onclick="editMethod({{ $method->id }})" title="Edit">
                                            <i data-lucide="edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteMethod({{ $method->id }}, '{{ addslashes($method->name) }}')" title="Delete">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center">
                                        <p class="mb-0 text-muted">No payment methods found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $paymentMethods->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('admin.pages.payment_methods.createModal')
@include('admin.pages.payment_methods.editModal')
@include('admin.pages.payment_methods.deleteModal')

<script>
    // Re-initialize Lucide icons after page load
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Search/Filter methods table
    document.getElementById('searchMethods').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableBody = document.getElementById('methodsTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const methodName = row.cells[1]?.textContent.toLowerCase() || '';
            const methodDetails = row.cells[3]?.textContent.toLowerCase() || '';

            if (methodName.includes(searchTerm) || methodDetails.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> Add Supplier
        </span>
        <h3 class="fw-bold">Suppliers</h3>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-hover table-centered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Currency</th>
                                <th>Last Supply</th>
                                <th>Status</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $supplier)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $supplier->name }}</span>
                                        @if($supplier->website)
                                            <br><small class="text-muted"><a href="{{ $supplier->website }}" target="_blank">{{ $supplier->website }}</a></small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($supplier->contact_person)
                                            <div>{{ $supplier->contact_person }}</div>
                                        @endif
                                        @if($supplier->contact_phone)
                                            <small class="text-muted">{{ $supplier->contact_phone }}</small>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-info">{{ $supplier->currency }}</span></td>
                                    <td>
                                        @if($supplier->last_supply_at)
                                            <small>{{ $supplier->last_supply_at->format('M d, Y') }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($supplier->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="editSupplier({{ $supplier->id }})" title="Edit" data-bs-toggle="tooltip">
                                                <i data-lucide="edit-3" class="icon-sm"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteSupplier({{ $supplier->id }}, '{{ $supplier->name }}')" title="Delete" data-bs-toggle="tooltip">
                                                <i data-lucide="trash-2" class="icon-sm"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center">
                                        <p class="mb-0 text-muted">No suppliers found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $suppliers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.pages.suppliers.createModal')
@include('admin.pages.suppliers.editModal')
@include('admin.pages.suppliers.deleteModal')

<style>
    .btn-group .btn {
        border-radius: 0;
    }
    .btn-group .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    .btn-group .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

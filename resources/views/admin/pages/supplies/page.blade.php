<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <a href="{{ route('admin.supplies.create') }}" class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm">
            <i data-lucide="plus" class="fs-sm me-1"></i> New Supply Order
        </a>
        <h3 class="fw-bold">Supply Orders</h3>
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
                                <th>ID</th>
                                <th>Supplier</th>
                                <th>Warehouse</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supplies as $supply)
                                <tr>
                                    <td><strong>#{{ $supply->id }}</strong></td>
                                    <td>
                                        @if($supply->supplier)
                                            {{ $supply->supplier->name }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($supply->warehouse)
                                            {{ $supply->warehouse->name }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $supply->supplyItems->count() }} items</span>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($supply->total, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $supply->status_badge_color }}">
                                            {{ ucfirst($supply->status) }}
                                        </span>
                                        @if($supply->is_delivered)
                                            <br><small class="text-success">Delivered</small>
                                        @endif
                                    </td>
                                    <td><small>{{ $supply->created_at->format('M d, Y') }}</small></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.supplies.show', $supply->id) }}" class="btn btn-sm btn-outline-primary" title="View Details" data-bs-toggle="tooltip">
                                                <i data-lucide="eye" class="icon-sm"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="editSupply({{ $supply->id }})" title="Edit" data-bs-toggle="tooltip">
                                                <i data-lucide="edit-3" class="icon-sm"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteSupply({{ $supply->id }})" title="Delete" data-bs-toggle="tooltip">
                                                <i data-lucide="trash-2" class="icon-sm"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-4 text-center">
                                        <p class="mb-0 text-muted">No supply orders found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $supplies->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.pages.supplies.editModal')
@include('admin.pages.supplies.deleteModal')

<style>
    .btn-group .btn {border-radius: 0;}
    .btn-group .btn:first-child {border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;}
    .btn-group .btn:last-child {border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
    });
</script>

<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <a href="{{ route('admin.return-orders.create') }}" class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm">
            <i data-lucide="plus" class="fs-sm me-1"></i> New Return Order
        </a>
        <h3 class="fw-bold">Return Orders</h3>
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
        <!-- Search and Filters -->
        <form method="GET" action="{{ route('admin.return-orders.index') }}" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by client or order..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="refunded" class="form-select">
                        <option value="">All Refund Status</option>
                        <option value="yes" {{ request('refunded') == 'yes' ? 'selected' : '' }}>Refunded</option>
                        <option value="no" {{ request('refunded') == 'no' ? 'selected' : '' }}>Not Refunded</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Original Order</th>
                        <th>Items</th>
                        <th>Total Refund</th>
                        <th>Status</th>
                        <th>Refunded</th>
                        <th>Date</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returnOrders as $returnOrder)
                        <tr>
                            <td><strong>#{{ $returnOrder->id }}</strong></td>
                            <td>
                                <strong>{{ $returnOrder->client->name }}</strong><br>
                                <small class="text-muted">{{ $returnOrder->client->email }}</small>
                            </td>
                            <td>
                                <strong class="text-primary">#{{ $returnOrder->order_id }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $returnOrder->items->count() }} items</span>
                            </td>
                            <td>
                                <strong class="text-success">${{ number_format($returnOrder->total_refund_amount, 2) }}</strong>
                                @if($returnOrder->return_fee > 0 || $returnOrder->shipping_fee > 0)
                                    <br><small class="text-muted">
                                        Fees: ${{ number_format($returnOrder->return_fee + $returnOrder->shipping_fee, 2) }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $returnOrder->status_badge }}">
                                    {{ ucfirst($returnOrder->status) }}
                                </span>
                                @if($returnOrder->is_all_approved === true)
                                    <br><span class="badge bg-success mt-1">All Approved</span>
                                @elseif($returnOrder->is_all_approved === false)
                                    <br><span class="badge bg-danger mt-1">Some Rejected</span>
                                @endif
                            </td>
                            <td>
                                @if($returnOrder->is_refunded)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-warning">No</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $returnOrder->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.return-orders.show', $returnOrder->id) }}" class="btn btn-outline-info" title="View">
                                        <i data-lucide="eye" class="icon-sm"></i>
                                    </a>
                                    <button class="btn btn-outline-danger" onclick="deleteReturnOrder({{ $returnOrder->id }})" title="Delete">
                                        <i data-lucide="trash-2" class="icon-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i data-lucide="package-x" class="icon-lg mb-2" style="opacity: 0.3;"></i>
                                <p class="mb-0">No return orders found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $returnOrders->links() }}
        </div>
    </div>
</div>

@include('admin.pages.return-orders.deleteModal')

<style>
    .btn-group .btn {border-radius: 0;}
    .btn-group .btn:first-child {border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;}
    .btn-group .btn:last-child {border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;}
</style>

<script>
    function deleteReturnOrder(id) {
        document.getElementById('deleteForm').action = `/admin/return-orders/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

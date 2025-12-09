<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> New Coupon
        </span>
        <h3 class="fw-bold">Coupons</h3>
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
        <form method="GET" action="{{ route('admin.coupons.index') }}" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by code or details..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="discount_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="percentage" {{ request('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="fixed" {{ request('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
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
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Usage</th>
                        <th>Dates</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td>
                                <strong class="text-primary">{{ $coupon->code }}</strong>
                                @if($coupon->details)
                                    <br><small class="text-muted">{{ Str::limit($coupon->details, 30) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $coupon->discount_type_badge }}">
                                    @if($coupon->discount_type === 'percentage')
                                        {{ $coupon->discount_value }}%
                                    @else
                                        ${{ number_format($coupon->discount_value, 2) }}
                                    @endif
                                </span>
                                @if($coupon->min_order_value > 0)
                                    <br><small class="text-muted">Min: ${{ $coupon->min_order_value }}</small>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $coupon->used_times }}</strong> / {{ $coupon->usage_limit }}
                                <br><small class="text-muted">{{ $coupon->usage_limit_client }} per client</small>
                            </td>
                            <td>
                                <small>
                                    <strong>From:</strong> {{ $coupon->start_date->format('M d, Y') }}<br>
                                    <strong>To:</strong> {{ $coupon->end_date->format('M d, Y') }}
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $coupon->status_badge }}">
                                    {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.coupons.show', $coupon->id) }}" class="btn btn-outline-info" title="View Details">
                                        <i data-lucide="eye" class="icon-sm"></i>
                                    </a>
                                    <button class="btn btn-outline-primary" onclick="editCoupon({{ $coupon->id }})" title="Edit">
                                        <i data-lucide="edit" class="icon-sm"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="deleteCoupon({{ $coupon->id }}, '{{ $coupon->code }}')" title="Delete">
                                        <i data-lucide="trash-2" class="icon-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i data-lucide="ticket" class="icon-lg mb-2" style="opacity: 0.3;"></i>
                                <p class="mb-0">No coupons found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $coupons->links() }}
        </div>
    </div>
</div>

@include('admin.pages.coupons.createModal')
@include('admin.pages.coupons.editModal')
@include('admin.pages.coupons.deleteModal')

<style>
    .btn-group .btn {border-radius: 0;}
    .btn-group .btn:first-child {border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;}
    .btn-group .btn:last-child {border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;}
</style>

<script>
    function editCoupon(id) {
        fetch(`/admin/coupons/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/coupons/${id}`;
                document.getElementById('edit_code').value = data.code;
                document.getElementById('edit_details').value = data.details || '';
                document.getElementById('edit_discount_type').value = data.discount_type;
                document.getElementById('edit_discount_value').value = data.discount_value;
                document.getElementById('edit_min_order_value').value = data.min_order_value;
                document.getElementById('edit_max_discount_value').value = data.max_discount_value;
                document.getElementById('edit_usage_limit').value = data.usage_limit;
                document.getElementById('edit_usage_limit_client').value = data.usage_limit_client;
                
                // Format dates from Y-m-d format
                const startDate = data.start_date.split('T')[0];
                const endDate = data.end_date.split('T')[0];
                document.getElementById('edit_start_date').value = startDate;
                document.getElementById('edit_end_date').value = endDate;
                
                document.getElementById('edit_is_active').checked = data.is_active;
                
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
    }

    function deleteCoupon(id, code) {
        document.getElementById('deleteCouponName').textContent = code;
        document.getElementById('deleteForm').action = `/admin/coupons/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

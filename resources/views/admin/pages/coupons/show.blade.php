<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Coupon: {{ $coupon->code }}</title>
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
                                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                                        <i data-lucide="arrow-left" class="icon-sm me-1"></i> Back to Coupons
                                    </a>
                                    <h3 class="mb-1 fw-bold">{{ $coupon->code }}</h3>
                                    <div class="gap-2 d-flex align-items-center">
                                        <span class="badge bg-{{ $coupon->status_badge }}">
                                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <span class="badge bg-{{ $coupon->discount_type_badge }}">
                                            @if($coupon->discount_type === 'percentage')
                                                {{ $coupon->discount_value }}% Off
                                            @else
                                                ${{ number_format($coupon->discount_value, 2) }} Off
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="gap-2 d-flex">
                                    <button class="btn btn-primary" onclick="editCoupon({{ $coupon->id }})">
                                        <i data-lucide="edit" class="icon-sm me-1"></i>Edit
                                    </button>
                                    <button class="btn btn-danger" onclick="deleteCoupon({{ $coupon->id }}, '{{ $coupon->code }}')">
                                        <i data-lucide="trash-2" class="icon-sm me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Coupon Details -->
                        <div class="col-lg-4">
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">Coupon Details</h5>
                                    
                                    @if($coupon->details)
                                    <div class="mb-3">
                                        <label class="text-muted fs-sm">Description</label>
                                        <p class="mb-0">{{ $coupon->details }}</p>
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="text-muted fs-sm">Discount</label>
                                        <div class="fs-4 fw-bold text-primary">
                                            @if($coupon->discount_type === 'percentage')
                                                {{ $coupon->discount_value }}%
                                            @else
                                                ${{ number_format($coupon->discount_value, 2) }}
                                            @endif
                                        </div>
                                    </div>

                                    @if($coupon->min_order_value > 0)
                                    <div class="mb-3">
                                        <label class="text-muted fs-sm">Min Order Value</label>
                                        <div class="fw-semibold">${{ number_format($coupon->min_order_value, 2) }}</div>
                                    </div>
                                    @endif

                                    @if($coupon->max_discount_value > 0)
                                    <div class="mb-3">
                                        <label class="text-muted fs-sm">Max Discount</label>
                                        <div class="fw-semibold">${{ number_format($coupon->max_discount_value, 2) }}</div>
                                    </div>
                                    @endif

                                    <hr>

                                    <div class="mb-3">
                                        <label class="text-muted fs-sm">Usage</label>
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ ($coupon->used_times / $coupon->usage_limit) * 100 }}%">
                                                {{ $coupon->used_times }} / {{ $coupon->usage_limit }}
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $coupon->usage_limit_client }} uses per client</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="text-muted fs-sm">Valid Period</label>
                                        <div class="fs-sm">
                                            <strong>From:</strong> {{ $coupon->start_date->format('M d, Y') }}<br>
                                            <strong>To:</strong> {{ $coupon->end_date->format('M d, Y') }}
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="mb-0">
                                        <label class="text-muted fs-sm">Created</label>
                                        <div class="fs-sm">{{ $coupon->created_at->format('M d, Y h:i A') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Usage History -->
                        <div class="col-lg-8">
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">
                                        <i data-lucide="history" class="icon-sm me-2"></i>Usage History
                                    </h5>

                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Client</th>
                                                    <th>Order</th>
                                                    <th>Discount</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($coupon->usages as $usage)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $usage->client->name }}</strong><br>
                                                            <small class="text-muted">{{ $usage->client->email }}</small>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="text-decoration-none">
                                                                #{{ $usage->order_id }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <strong class="text-success">${{ number_format($usage->discount_value, 2) }}</strong>
                                                        </td>
                                                        <td>
                                                            <small>{{ $usage->created_at->format('M d, Y h:i A') }}</small>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted py-4">
                                                            <i data-lucide="inbox" class="icon-lg mb-2" style="opacity: 0.3;"></i>
                                                            <p class="mb-0">No usage history yet</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
    @include('admin.pages.coupons.editModal')
    @include('admin.pages.coupons.deleteModal')

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
</body>
</html>

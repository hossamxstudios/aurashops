<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Return Order #{{ $returnOrder->id }}</title>
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
                                    <a href="{{ route('admin.return-orders.index') }}" class="mb-2 btn btn-outline-secondary btn-sm">
                                        <i data-lucide="arrow-left" class="icon-sm me-1"></i> Back
                                    </a>
                                    <h3 class="mb-1 fw-bold">Return Order #{{ $returnOrder->id }}</h3>
                                    <div class="gap-2 d-flex align-items-center">
                                        <span class="badge bg-{{ $returnOrder->status_badge }}">
                                            {{ ucfirst($returnOrder->status) }}
                                        </span>
                                        @if($returnOrder->is_refunded)
                                            <span class="badge bg-success">Refunded</span>
                                        @endif
                                        @if($returnOrder->is_all_approved === true)
                                            <span class="badge bg-success">All Approved</span>
                                        @elseif($returnOrder->is_all_approved === false)
                                            <span class="badge bg-danger">Some Rejected</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="gap-2 d-flex">
                                    @if($returnOrder->status == 'pending')
                                        <form action="{{ route('admin.return-orders.approve-all', $returnOrder->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i data-lucide="check-circle" class="icon-sm me-1"></i>Approve All
                                            </button>
                                        </form>
                                    @endif
                                    @if($returnOrder->is_all_approved && !$returnOrder->is_refunded)
                                        <form action="{{ route('admin.return-orders.refund-all', $returnOrder->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                <i data-lucide="dollar-sign" class="icon-sm me-1"></i>Refund All
                                            </button>
                                        </form>
                                    @endif
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i data-lucide="edit" class="icon-sm me-1"></i>Edit
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
                        <!-- Left Column - Details -->
                        <div class="col-lg-4">
                            <!-- Client Info -->
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">Client Information</h5>
                                    <div class="mb-3">
                                        <label class="text-muted fs-sm">Name</label>
                                        <div class="fw-semibold">{{ $returnOrder->client->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted fs-sm">Email</label>
                                        <div>{{ $returnOrder->client->email }}</div>
                                    </div>
                                    <div class="mb-0">
                                        <label class="text-muted fs-sm">Phone</label>
                                        <div>{{ $returnOrder->client->phone }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Info -->
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">Original Order</h5>
                                    <div class="mb-3">
                                        <label class="text-muted fs-sm">Order Number</label>
                                        <div class="fw-semibold text-primary">#{{ $returnOrder->order_id }}</div>
                                    </div>
                                    <div class="mb-0">
                                        <label class="text-muted fs-sm">Order Date</label>
                                        <div>{{ $returnOrder->order?->created_at?->format('M d, Y h:i A') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Summary -->
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">Financial Summary</h5>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span class="text-muted">Return Fee</span>
                                        <span class="fw-semibold">${{ number_format($returnOrder->return_fee, 2) }}</span>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span class="text-muted">Shipping Fee</span>
                                        <span class="fw-semibold">${{ number_format($returnOrder->shipping_fee, 2) }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold">Total Refund</span>
                                        <span class="fw-bold text-success fs-4">${{ number_format($returnOrder->total_refund_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Addresses -->
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">Return Address</h5>
                                    <div class="mb-3">
                                        <strong>{{ $returnOrder->address->label ?? 'Address' }}</strong><br>
                                        {{ $returnOrder->address->street }}<br>
                                        {{ $returnOrder->address->district->name }}, {{ $returnOrder->address->city->name }}
                                    </div>
                                    <h6 class="mb-2 fw-semibold">Dropoff Location</h6>
                                    <div>{{ $returnOrder->dropoffLocation->name }}</div>
                                </div>
                            </div>

                            <!-- Notes -->
                            @if($returnOrder->details || $returnOrder->admin_notes)
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">Notes</h5>
                                    @if($returnOrder->details)
                                        <div class="mb-3">
                                            <label class="text-muted fs-sm">Details</label>
                                            <div>{{ $returnOrder->details }}</div>
                                        </div>
                                    @endif
                                    @if($returnOrder->admin_notes)
                                        <div class="mb-0">
                                            <label class="text-muted fs-sm">Admin Notes</label>
                                            <div>{{ $returnOrder->admin_notes }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Right Column - Items -->
                        <div class="col-lg-8">
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">
                                        <i data-lucide="package" class="icon-sm me-2"></i>Return Items
                                    </h5>

                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Reason</th>
                                                    <th>Qty</th>
                                                    <th>Refund</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($returnOrder->items as $item)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $item->orderItem->product->name }}</strong>
                                                            @if($item->orderItem->variant)
                                                                <br><small class="text-muted">{{ $item->orderItem->variant->name }}</small>
                                                            @endif
                                                            @if($item->details)
                                                                <br><small class="text-muted fst-italic">{{ $item->details }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-secondary">{{ $item->reason->name }}</span>
                                                        </td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>
                                                            <strong class="text-success">${{ number_format($item->refund_amount, 2) }}</strong>
                                                            @if($item->is_refunded)
                                                                <br><span class="mt-1 badge bg-success">Refunded</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $item->approval_badge }}">
                                                                {{ $item->approval_status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                @if(is_null($item->is_approved))
                                                                    <form action="{{ route('admin.return-orders.items.approve', $item->id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-outline-success" title="Approve">
                                                                            <i data-lucide="check" class="icon-sm"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ route('admin.return-orders.items.reject', $item->id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-outline-danger" title="Reject">
                                                                            <i data-lucide="x" class="icon-sm"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                                @if($item->is_approved && !$item->is_refunded)
                                                                    <form action="{{ route('admin.return-orders.items.refund', $item->id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-outline-primary" title="Mark as Refunded">
                                                                            <i data-lucide="dollar-sign" class="icon-sm"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
    @include('admin.pages.return-orders.editModal')

    <style>
        .btn-group .btn {border-radius: 0;}
        .btn-group .btn:first-child {border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;}
        .btn-group .btn:last-child {border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;}
    </style>

    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>

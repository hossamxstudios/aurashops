<div class="card mb-3">
    <div class="card-header bg-light">
        <h6 class="card-title mb-0">
            <i class="ti ti-info-circle me-2"></i>
            Order Information
        </h6>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <small class="text-muted d-block">Order ID</small>
            <strong>#{{ $order->id }}</strong>
        </div>

        <div class="mb-3 p-3 bg-light rounded">
            <small class="text-muted d-block mb-2 fw-semibold">
                <i class="ti ti-flag me-1"></i>
                Order Status
            </small>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                @if($order->orderStatus)
                    <span class="badge fs-6" style="background-color: {{ $order->orderStatus->color }}; padding: 8px 12px;">
                        {{ $order->orderStatus->name }}
                    </span>
                @else
                    <span class="badge bg-secondary fs-6" style="padding: 8px 12px;">N/A</span>
                @endif
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                    <i class="ti ti-edit me-1"></i>
                    Change Status
                </button>
            </div>
            <small class="text-muted d-block mt-2">
                <i class="ti ti-info-circle"></i>
                Change from all available statuses
            </small>
        </div>

        <div class="mb-3">
            <small class="text-muted d-block">Date</small>
            <strong>{{ $order->created_at->format('M d, Y - h:i A') }}</strong>
        </div>

        <div class="mb-3">
            <small class="text-muted d-block">Payment Method</small>
            <strong>{{ $order->paymentMethod->name ?? 'N/A' }}</strong>
        </div>

        <div class="mb-3">
            <small class="text-muted d-block">Source</small>
            @if($order->source === 'POS')
                <span class="badge bg-info">
                    <i class="ti ti-device-desktop me-1"></i>
                    POS
                </span>
                @if($order->posSession)
                    <br>
                    <small class="text-muted">Session #{{ $order->posSession->id }}</small>
                @endif
            @else
                <span class="badge bg-primary">
                    <i class="ti ti-world me-1"></i>
                    Online
                </span>
            @endif
        </div>

        <hr class="my-3">

        <h6 class="text-muted mb-3">
            <i class="ti ti-toggle-left me-1"></i>
            Quick Toggle Actions
        </h6>

        <div class="mb-3">
            <small class="text-muted d-block mb-2">Payment Status</small>
            <form action="{{ route('admin.orders.toggle-paid', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to toggle payment status?');">
                @csrf
                @if($order->is_paid)
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="ti ti-check me-1"></i>
                        Paid
                    </button>
                @else
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="ti ti-x me-1"></i>
                        Unpaid
                    </button>
                @endif
            </form>
            <small class="text-muted d-block mt-1">Click to toggle</small>
        </div>

        <div class="mb-3">
            <small class="text-muted d-block mb-2">Completion Status</small>
            <form action="{{ route('admin.orders.toggle-done', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to toggle completion status?');">
                @csrf
                @if($order->is_done)
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="ti ti-check me-1"></i>
                        Completed
                    </button>
                @else
                    <button type="submit" class="btn btn-sm btn-warning">
                        <i class="ti ti-clock me-1"></i>
                        In Progress
                    </button>
                @endif
            </form>
            <small class="text-muted d-block mt-1">Click to toggle</small>
        </div>

        <hr class="my-3">

        @if(!$order->is_canceled)
            <div class="mb-0">
                <h6 class="text-danger mb-2">
                    <i class="ti ti-alert-triangle me-1"></i>
                    Danger Zone
                </h6>
                <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('⚠️ WARNING: This will cancel the entire order!\n\nAre you absolutely sure?');">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger w-100">
                        <i class="ti ti-ban me-1"></i>
                        Cancel Order
                    </button>
                </form>
                <small class="text-muted d-block mt-1">
                    <i class="ti ti-info-circle"></i>
                    This action cannot be undone
                </small>
            </div>
        @else
            <div class="alert alert-danger mb-0">
                <i class="ti ti-ban me-2"></i>
                <strong>⚠️ Order Canceled</strong>
            </div>
        @endif
    </div>
</div>

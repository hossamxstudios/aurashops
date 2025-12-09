<div class="card mb-3">
    <div class="card-header bg-light">
        <h6 class="card-title mb-0">
            <i class="ti ti-note me-2"></i>
            Admin Notes
        </h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.orders.update-notes', $order->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="admin_notes" class="form-control" rows="4" placeholder="Add notes about this order...">{{ $order->admin_notes }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm w-100">
                <i class="ti ti-device-floppy me-1"></i>
                Save Notes
            </button>
        </form>
    </div>
</div>

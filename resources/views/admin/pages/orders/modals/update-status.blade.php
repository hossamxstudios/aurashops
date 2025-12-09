<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">
                        <i class="ti ti-edit me-2"></i>
                        Update Order Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Status</label>
                        <div>
                            @if($order->orderStatus)
                                <span class="badge" style="background-color: {{ $order->orderStatus->color }};">
                                    {{ $order->orderStatus->name }}
                                </span>
                            @else
                                <span class="badge bg-secondary">N/A</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select New Status <span class="text-danger">*</span></label>
                        <select name="status_id" class="form-select form-select-lg" required>
                            <option value="">-- Choose Order Status --</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" 
                                        {{ $order->order_status_id == $status->id ? 'selected' : '' }}
                                        data-color="{{ $status->color }}">
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Choose from all available order statuses</small>
                    </div>

                    <div class="alert alert-primary mb-0">
                        <i class="ti ti-info-circle me-2"></i>
                        <strong>Note:</strong> This change will be recorded in the order history timeline.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

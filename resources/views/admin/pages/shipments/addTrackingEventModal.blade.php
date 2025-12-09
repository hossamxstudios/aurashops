<div class="modal fade" id="addTrackingEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.shipments.tracking-events.store', $shipment->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Tracking Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control" name="status" placeholder="e.g., In Transit, Delivered">
                        <small class="text-muted">Optional: Custom status for this event</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Carrier Status Code</label>
                            <input type="text" class="form-control" name="carrier_status_code" placeholder="e.g., DLVD">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Carrier Status Label</label>
                            <input type="text" class="form-control" name="carrier_status_label" placeholder="e.g., Delivered">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" placeholder="e.g., Cairo Distribution Center">
                        <small class="text-muted">Where did this event occur?</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location Details</label>
                        <input type="text" class="form-control" name="location_details" placeholder="e.g., Warehouse 5, Bay 12">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Details</label>
                        <textarea class="form-control" name="details" rows="3" placeholder="Additional information about this tracking event..."></textarea>
                    </div>

                    <div class="alert alert-info">
                        <i data-lucide="info" class="icon-sm me-2"></i>
                        <small>The timestamp will be automatically set to the current time when this event is created.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Re-initialize Lucide icons when modal is shown
    document.getElementById('addTrackingEventModal')?.addEventListener('shown.bs.modal', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

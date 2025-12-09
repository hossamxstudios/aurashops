<div class="modal fade" id="subtractPointsModal" tabindex="-1" aria-labelledby="subtractPointsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-warning" id="subtractPointsModalLabel">
                    <i class="ti ti-minus me-2"></i>Subtract Loyalty Points
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.clients.manage-points', $client->id) }}" method="POST">
                @csrf
                <input type="hidden" name="action" value="subtract">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="subtract_points" class="form-label">Points to Subtract <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="subtract_points" name="points" required min="1" step="1" max="{{ $client->loyaltyAccount->points ?? 0 }}" placeholder="Enter points amount">
                        <small class="text-muted">Current balance: {{ number_format($client->loyaltyAccount->points ?? 0, 0) }} points</small>
                    </div>

                    <div class="mb-3">
                        <label for="subtract_note" class="form-label">Note/Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="subtract_note" name="note" rows="3" required placeholder="Enter reason for subtracting points"></textarea>
                    </div>

                    <div class="alert alert-warning">
                        <i class="ti ti-alert-triangle me-2"></i>Points will be deducted from the client's account immediately. This action cannot be undone.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-check me-1"></i>Subtract Points
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

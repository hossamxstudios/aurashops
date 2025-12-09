<div class="modal fade" id="addPointsModal" tabindex="-1" aria-labelledby="addPointsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success-subtle">
                <h5 class="modal-title text-success" id="addPointsModalLabel">
                    <i class="ti ti-plus me-2"></i>Add Loyalty Points
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.clients.manage-points', $client->id) }}" method="POST">
                @csrf
                <input type="hidden" name="action" value="add">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="points" class="form-label">Points to Add <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="points" name="points" required min="1" step="1" placeholder="Enter points amount">
                        <small class="text-muted">Current balance: {{ number_format($client->loyaltyAccount->points ?? 0, 0) }} points</small>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">Note/Reason</label>
                        <textarea class="form-control" id="note" name="note" rows="3" placeholder="Enter reason for adding points (optional)"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="expires_at" class="form-label">Expiry Date (Optional)</label>
                        <input type="date" class="form-control" id="expires_at" name="expires_at" min="{{ date('Y-m-d') }}">
                        <small class="text-muted">Leave empty if points don't expire</small>
                    </div>

                    <div class="alert alert-success">
                        <i class="ti ti-info-circle me-2"></i>Points will be added to the client's account immediately
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-check me-1"></i>Add Points
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

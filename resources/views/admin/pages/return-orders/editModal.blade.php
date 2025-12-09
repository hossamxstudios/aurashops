<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.return-orders.update', $returnOrder->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Return Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" required>
                            <option value="pending" {{ $returnOrder->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $returnOrder->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $returnOrder->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="completed" {{ $returnOrder->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Return Fee ($)</label>
                        <input type="number" class="form-control" name="return_fee" step="0.01" min="0" value="{{ $returnOrder->return_fee }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Shipping Fee ($)</label>
                        <input type="number" class="form-control" name="shipping_fee" step="0.01" min="0" value="{{ $returnOrder->shipping_fee }}">
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Admin Notes</label>
                        <textarea class="form-control" name="admin_notes" rows="4">{{ $returnOrder->admin_notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" name="code" id="edit_code" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active">
                                <label class="form-check-label" for="edit_is_active">Active</label>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Details</label>
                            <textarea class="form-control" name="details" id="edit_details" rows="2"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="discount_type" id="edit_discount_type" required>
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount ($)</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="discount_value" id="edit_discount_value" step="0.01" min="0" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Min Order Value ($)</label>
                            <input type="number" class="form-control" name="min_order_value" id="edit_min_order_value" min="0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Max Discount ($)</label>
                            <input type="number" class="form-control" name="max_discount_value" id="edit_max_discount_value" min="0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Usage Limit <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="usage_limit" id="edit_usage_limit" min="1" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Usage Per Client <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="usage_limit_client" id="edit_usage_limit_client" min="1" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="start_date" id="edit_start_date" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="end_date" id="edit_end_date" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>

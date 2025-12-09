<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control text-uppercase" name="code" id="coupon_code" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="generateCode()">
                                    <i data-lucide="refresh-cw" class="icon-sm"></i>
                                </button>
                            </div>
                            <small class="text-muted">Unique coupon code (auto-uppercase)</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Details</label>
                            <textarea class="form-control" name="details" rows="2" placeholder="Optional description"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="discount_type" required>
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount ($)</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="discount_value" step="0.01" min="0" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Min Order Value ($)</label>
                            <input type="number" class="form-control" name="min_order_value" value="0" min="0">
                            <small class="text-muted">Minimum order amount to use coupon</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Max Discount ($)</label>
                            <input type="number" class="form-control" name="max_discount_value" value="0" min="0">
                            <small class="text-muted">0 = unlimited</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Usage Limit <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="usage_limit" value="100" min="1" required>
                            <small class="text-muted">Total uses allowed</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Usage Per Client <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="usage_limit_client" value="1" min="1" required>
                            <small class="text-muted">Uses per client</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="start_date" value="{{ now()->format('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="end_date" value="{{ now()->addMonth()->format('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function generateCode() {
        fetch('/admin/coupons/generate-code')
            .then(response => response.json())
            .then(data => {
                document.getElementById('coupon_code').value = data.code;
            });
    }
</script>

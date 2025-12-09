<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.shippers.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Shipper</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Carrier Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="carrier_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">API Endpoint <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" name="api_endpoint" placeholder="https://api.example.com" required>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">API Key <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="api_key" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">API Secret</label>
                            <input type="text" class="form-control" name="api_secret">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">API Password</label>
                            <input type="password" class="form-control" name="api_password">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Delivery Time <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="delivery_time" placeholder="e.g., 2-3 Days" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Delivery Days <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="delivery_days" placeholder="e.g., Mon-Fri" required>
                        </div>
                    </div>

                    <h6 class="mt-3 mb-3">COD Configuration</h6>

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">COD Fee <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="cod_fee" step="0.01" min="0" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">COD Fee Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="cod_fee_type" required>
                                <option value="fixed">Fixed</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <div class="mt-4 form-check">
                                <input type="checkbox" class="form-check-input" id="create_is_support_cod" name="is_support_cod" value="1" checked>
                                <label class="form-check-label" for="create_is_support_cod">
                                    Support COD
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">COD Minimum <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">EGP</span>
                                <input type="number" class="form-control" name="cod_min" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">COD Maximum <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">EGP</span>
                                <input type="number" class="form-control" name="cod_max" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="create_is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="create_is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Shipper</button>
                </div>
            </form>
        </div>
    </div>
</div>

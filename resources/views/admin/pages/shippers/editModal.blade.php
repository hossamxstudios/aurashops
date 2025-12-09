<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Shipper</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Carrier Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="carrier_name" id="edit_carrier_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">API Endpoint <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" name="api_endpoint" id="edit_api_endpoint" placeholder="https://api.example.com" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">API Key <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="api_key" id="edit_api_key" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">API Secret</label>
                            <input type="text" class="form-control" name="api_secret" id="edit_api_secret">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">API Password</label>
                            <input type="password" class="form-control" name="api_password" id="edit_api_password">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Delivery Time <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="delivery_time" id="edit_delivery_time" placeholder="e.g., 2-3 Days" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Delivery Days <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="delivery_days" id="edit_delivery_days" placeholder="e.g., Mon-Fri" required>
                        </div>
                    </div>

                    <h6 class="mt-3 mb-3">COD Configuration</h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">COD Fee <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="cod_fee" id="edit_cod_fee" step="0.01" min="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">COD Fee Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="cod_fee_type" id="edit_cod_fee_type" required>
                                <option value="fixed">Fixed</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox" class="form-check-input" id="edit_is_support_cod" name="is_support_cod" value="1">
                                <label class="form-check-label" for="edit_is_support_cod">
                                    Support COD
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">COD Minimum <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">EGP</span>
                                <input type="number" class="form-control" name="cod_min" id="edit_cod_min" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">COD Maximum <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">EGP</span>
                                <input type="number" class="form-control" name="cod_max" id="edit_cod_max" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active" value="1">
                            <label class="form-check-label" for="edit_is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Shipper</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editShipper(id) {
        fetch(`/admin/shippers/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/shippers/${id}`;
                document.getElementById('edit_carrier_name').value = data.carrier_name;
                document.getElementById('edit_api_endpoint').value = data.api_endpoint;
                document.getElementById('edit_api_key').value = data.api_key || '';
                document.getElementById('edit_api_secret').value = data.api_secret || '';
                document.getElementById('edit_api_password').value = '';
                document.getElementById('edit_delivery_time').value = data.delivery_time;
                document.getElementById('edit_delivery_days').value = data.delivery_days;
                document.getElementById('edit_cod_fee').value = data.cod_fee;
                document.getElementById('edit_cod_fee_type').value = data.cod_fee_type;
                document.getElementById('edit_cod_min').value = data.cod_min;
                document.getElementById('edit_cod_max').value = data.cod_max;
                document.getElementById('edit_is_support_cod').checked = data.is_support_cod;
                document.getElementById('edit_is_active').checked = data.is_active;

                const modal = new bootstrap.Modal(document.getElementById('editModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load shipper details');
            });
    }
</script>

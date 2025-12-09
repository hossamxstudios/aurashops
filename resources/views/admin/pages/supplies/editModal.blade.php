<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Supply</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Supplier <span class="text-danger">*</span></label>
                        <select class="form-select" name="supplier_id" id="edit_supplier_id" required>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warehouse <span class="text-danger">*</span></label>
                        <select class="form-select" name="warehouse_id" id="edit_warehouse_id" required>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" id="edit_status" required>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tax Rate (%)</label>
                        <input type="number" class="form-control" name="tax_rate" id="edit_tax_rate" step="0.01" min="0" max="100">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="discount_type" id="edit_discount_type" required>
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Amount</label>
                            <input type="number" class="form-control" name="discount_amount" id="edit_discount_amount" step="0.01" min="0">
                        </div>
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

<script>
    function editSupply(id) {
        fetch(`/admin/supplies/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/supplies/${id}`;
                document.getElementById('edit_supplier_id').value = data.supplier_id;
                document.getElementById('edit_warehouse_id').value = data.warehouse_id;
                document.getElementById('edit_status').value = data.status;
                document.getElementById('edit_tax_rate').value = data.tax_rate;
                document.getElementById('edit_discount_type').value = data.discount_type || 'percentage';
                document.getElementById('edit_discount_amount').value = data.discount_amount;
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
    }
</script>

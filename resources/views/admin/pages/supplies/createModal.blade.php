<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.supplies.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">New Supply Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Supplier <span class="text-danger">*</span></label>
                        <select class="form-select" name="supplier_id" required>
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warehouse <span class="text-danger">*</span></label>
                        <select class="form-select" name="warehouse_id" required>
                            <option value="">Select Warehouse</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" required>
                            <option value="pending" selected>Pending</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tax Rate (%)</label>
                            <input type="number" class="form-control" name="tax_rate" step="0.01" min="0" max="100" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Amount</label>
                            <input type="number" class="form-control" name="discount_amount" step="0.01" min="0" value="0">
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i data-lucide="info" class="icon-sm me-2"></i>
                        <small>After creating the supply order, you can add items to it.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create & Add Items</button>
                </div>
            </form>
        </div>
    </div>
</div>

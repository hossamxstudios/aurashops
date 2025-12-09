<div class="modal fade" id="addStockLogModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.stocks.logs.store', $stock->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Stock Movement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i data-lucide="info" class="icon-sm me-2"></i>
                        <small>Current Stock: <strong>{{ $stock->qty }}</strong> units</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Movement Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="type" id="movement_type" required>
                                <option value="">Select Type</option>
                                <optgroup label="Increase Stock">
                                    <option value="add">Add (Manual Increase)</option>
                                    <option value="purchase">Purchase (Supplier Order)</option>
                                    <option value="return">Return (Customer Return)</option>
                                </optgroup>
                                <optgroup label="Decrease Stock">
                                    <option value="remove">Remove (Manual Decrease)</option>
                                    <option value="sale">Sale (Order Fulfillment)</option>
                                    <option value="damage">Damage (Damaged Goods)</option>
                                    <option value="loss">Loss (Lost/Stolen)</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="adjustment">Adjustment (Manual Correction)</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="qty" min="1" value="1" required>
                            <small class="text-muted">Number of units affected</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Reference Type</label>
                            <select class="form-select" name="reference_type">
                                <option value="">None</option>
                                <option value="order">Order</option>
                                <option value="order_cancel">Order Cancel</option>
                                <option value="order_return">Order Return</option>
                                <option value="purchase_order">Purchase Order</option>
                                <option value="transfer">Transfer</option>
                                <option value="manual">Manual</option>
                            </select>
                            <small class="text-muted">Link this movement to a reference</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Reference ID</label>
                            <input type="text" class="form-control" name="reference_id" placeholder="e.g., Order #12345">
                            <small class="text-muted">ID or number of the reference</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cost Per Unit</label>
                            <input type="number" class="form-control" name="cost_per_unit" min="0" step="0.01" placeholder="0.00">
                            <small class="text-muted">Cost for purchases or value for losses</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Cost (Auto-calculated)</label>
                            <input type="text" class="form-control" id="total_cost_display" readonly placeholder="0.00" disabled>
                            <small class="text-muted">Quantity × Cost Per Unit</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Additional notes about this movement..."></textarea>
                    </div>

                    <div class="alert alert-warning" id="decrease_warning" style="display: none;">
                        <i data-lucide="alert-triangle" class="me-2"></i>
                        <strong>Warning:</strong> This movement will decrease the stock quantity.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Movement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Calculate total cost automatically
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInput = document.querySelector('input[name="qty"]');
        const costInput = document.querySelector('input[name="cost_per_unit"]');
        const totalDisplay = document.getElementById('total_cost_display');
        const typeSelect = document.getElementById('movement_type');
        const decreaseWarning = document.getElementById('decrease_warning');

        function updateTotal() {
            const qty = parseFloat(qtyInput.value) || 0;
            const cost = parseFloat(costInput.value) || 0;
            const total = qty * cost;
            totalDisplay.value = total.toFixed(2);
        }

        function updateWarning() {
            const type = typeSelect.value;
            const decreaseTypes = ['remove', 'sale', 'damage', 'loss'];
            
            if (decreaseTypes.includes(type)) {
                decreaseWarning.style.display = 'block';
            } else {
                decreaseWarning.style.display = 'none';
            }
        }

        qtyInput.addEventListener('input', updateTotal);
        costInput.addEventListener('input', updateTotal);
        typeSelect.addEventListener('change', updateWarning);

        // Re-initialize Lucide icons when modal is shown
        document.getElementById('addStockLogModal')?.addEventListener('shown.bs.modal', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    });
</script>

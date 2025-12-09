<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.supplies.items.store', $supply->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Item to Supply</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Product <span class="text-danger">*</span></label>
                        <select class="form-select" name="product_id" id="supply_product_id" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Variant</label>
                        <select class="form-select" name="variant_id" id="supply_variant_id" disabled>
                            <option value="">Select Product First</option>
                        </select>
                        <small class="text-muted">Optional for simple products</small>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="qty" id="supply_qty" min="1" value="1" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unit Price <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="unit_price" id="supply_unit_price" step="0.01" min="0" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total (Auto)</label>
                            <input type="text" class="form-control" id="supply_item_total" readonly disabled>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i data-lucide="info" class="icon-sm me-2"></i>
                        <small>The total will be calculated automatically. Supply totals will be recalculated after adding this item.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Initialize Choices.js for product dropdown
    let supplyProductChoices;
    
    document.addEventListener('DOMContentLoaded', function() {
        supplyProductChoices = new Choices('#supply_product_id', {
            searchEnabled: true,
            searchPlaceholderValue: 'Search products...',
            itemSelectText: '',
            shouldSort: false
        });
    });

    // Load variants when product is selected
    document.getElementById('supply_product_id').addEventListener('change', function() {
        const productId = this.value;
        const variantSelect = document.getElementById('supply_variant_id');
        
        variantSelect.innerHTML = '<option value="">Select Variant</option>';
        variantSelect.disabled = true;
        
        if (productId) {
            fetch(`/admin/supplies/variants/${productId}`)
                .then(response => response.json())
                .then(variants => {
                    if (variants.length === 0) {
                        variantSelect.innerHTML = '<option value="">No Variant (Simple Product)</option>';
                        variantSelect.disabled = true;
                    } else {
                        variantSelect.innerHTML = '<option value="">Select Variant</option>';
                        variants.forEach(variant => {
                            const option = document.createElement('option');
                            option.value = variant.id;
                            option.textContent = `${variant.sku} - ${variant.attribute_values || 'Default'}`;
                            variantSelect.appendChild(option);
                        });
                        variantSelect.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error loading variants:', error);
                    variantSelect.innerHTML = '<option value="">Error loading variants</option>';
                });
        }
    });

    // Calculate total automatically
    const qtyInput = document.getElementById('supply_qty');
    const priceInput = document.getElementById('supply_unit_price');
    const totalInput = document.getElementById('supply_item_total');

    function updateItemTotal() {
        const qty = parseFloat(qtyInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = qty * price;
        totalInput.value = total.toFixed(2);
    }

    qtyInput.addEventListener('input', updateItemTotal);
    priceInput.addEventListener('input', updateItemTotal);

    // Re-initialize icons when modal is shown
    document.getElementById('addItemModal')?.addEventListener('shown.bs.modal', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

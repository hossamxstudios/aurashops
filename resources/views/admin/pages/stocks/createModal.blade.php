<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.stocks.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Warehouse <span class="text-danger">*</span></label>
                            <select class="form-select" name="warehouse_id" required>
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product <span class="text-danger">*</span></label>
                            <select class="form-select" name="product_id" id="create_product_id" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Variant <span class="text-danger">*</span></label>
                        <select class="form-select" name="variant_id" id="create_variant_id" disabled required>
                            <option value="">Select Product First</option>
                        </select>
                        <small class="text-muted">Select a product first to load its variants</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="qty" min="0" value="0" required>
                            <small class="text-muted">Current stock quantity</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Reorder Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="reorder_qty" min="0" value="10" required>
                            <small class="text-muted">Alert when stock falls below this level</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="is_active" id="create_is_active" value="1" checked>
                            <label class="form-check-label" for="create_is_active">
                                Active
                            </label>
                        </div>
                        <small class="text-muted d-block">Stock is available for orders</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Initialize Choices.js for searchable product dropdown
    let createProductChoices;
    
    document.addEventListener('DOMContentLoaded', function() {
        createProductChoices = new Choices('#create_product_id', {
            searchEnabled: true,
            searchPlaceholderValue: 'Search products...',
            itemSelectText: '',
            shouldSort: false
        });
    });

    // Cascading dropdown for variants based on product
    document.getElementById('create_product_id').addEventListener('change', function() {
        const productId = this.value;
        const variantSelect = document.getElementById('create_variant_id');
        
        // Reset variants
        variantSelect.innerHTML = '<option value="">Select Variant</option>';
        variantSelect.disabled = true;
        
        if (productId) {
            // Enable and load variants
            fetch(`/admin/stocks/variants/${productId}`)
                .then(response => response.json())
                .then(variants => {
                    if (variants.length === 0) {
                        variantSelect.innerHTML = '<option value="">No variants available</option>';
                    } else {
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
</script>

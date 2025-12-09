<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Warehouse <span class="text-danger">*</span></label>
                            <select class="form-select" name="warehouse_id" id="edit_warehouse_id" required>
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product <span class="text-danger">*</span></label>
                            <select class="form-select" name="product_id" id="edit_product_id" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Variant <span class="text-danger">*</span></label>
                        <select class="form-select" name="variant_id" id="edit_variant_id" disabled required>
                            <option value="">Select Product First</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="qty" id="edit_qty" min="0" required>
                            <small class="text-muted">Current stock quantity</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Reorder Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="reorder_qty" id="edit_reorder_qty" min="0" required>
                            <small class="text-muted">Alert when stock falls below this level</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="is_active" id="edit_is_active" value="1">
                            <label class="form-check-label" for="edit_is_active">
                                Active
                            </label>
                        </div>
                        <small class="text-muted d-block">Stock is available for orders</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Initialize Choices.js for searchable product dropdown
    let editProductChoices;
    
    document.addEventListener('DOMContentLoaded', function() {
        editProductChoices = new Choices('#edit_product_id', {
            searchEnabled: true,
            searchPlaceholderValue: 'Search products...',
            itemSelectText: '',
            shouldSort: false
        });
    });

    function editStock(id) {
        fetch(`/admin/stocks/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/stocks/${id}`;
                document.getElementById('edit_warehouse_id').value = data.warehouse_id;
                document.getElementById('edit_qty').value = data.qty;
                document.getElementById('edit_reorder_qty').value = data.reorder_qty;
                document.getElementById('edit_is_active').checked = data.is_active;

                // Set product using Choices.js
                editProductChoices.setChoiceByValue(data.product_id ? data.product_id.toString() : '');

                // Load variants if product is selected
                if (data.product_id) {
                    const variantSelect = document.getElementById('edit_variant_id');
                    variantSelect.disabled = false;
                    variantSelect.innerHTML = '<option value="">Loading variants...</option>';
                    
                    fetch(`/admin/stocks/variants/${data.product_id}`)
                        .then(response => response.json())
                        .then(variants => {
                            variantSelect.innerHTML = '<option value="">Select Variant</option>';
                            variants.forEach(variant => {
                                const option = document.createElement('option');
                                option.value = variant.id;
                                option.textContent = `${variant.sku} - ${variant.attribute_values || 'Default'}`;
                                if (variant.id == data.variant_id) {
                                    option.selected = true;
                                }
                                variantSelect.appendChild(option);
                            });
                        });
                }

                const modal = new bootstrap.Modal(document.getElementById('editModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load stock details');
            });
    }

    // Cascading dropdown for variants based on product (edit modal)
    document.getElementById('edit_product_id').addEventListener('change', function() {
        const productId = this.value;
        const variantSelect = document.getElementById('edit_variant_id');
        
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

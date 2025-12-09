<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-0 fw-semibold">Variant Management</h5>
                <small class="text-muted">Generate and manage product variants based on attributes</small>
            </div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#generateVariantsModal">
                <i class="ti ti-refresh me-1"></i>Generate Variants
            </button>
        </div>

        @if($product->variants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Variant Name</th>
                            <th class="border-0">SKU</th>
                            <th class="border-0">Price</th>
                            <th class="border-0">Sale Price</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->variants as $variant)
                            <tr>
                                <td>
                                    <div class="fw-medium">{{ $variant->name }}</div>
                                    <small class="text-muted">{{ $variant->getVariantName() }}</small>
                                </td>
                                <td>{{ $variant->sku }}</td>
                                <td class="fw-bold text-primary">${{ number_format($variant->price, 2) }}</td>
                                <td>
                                    @if($variant->sale_price > 0)
                                        <span class="text-success">${{ number_format($variant->sale_price, 2) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($variant->is_active)
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <button class="btn btn-light btn-sm" onclick="editVariant({{ $variant->id }})" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn btn-danger-subtle text-danger btn-sm" onclick="deleteVariantConfirm({{ $variant->id }})" title="Delete">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="ti ti-versions text-muted" style="font-size: 3rem; opacity: 0.15;"></i>
                <h6 class="text-muted fw-semibold mt-3">No Variants Generated</h6>
                <p class="text-muted fs-sm mb-3">Click "Generate Variants" to create variant combinations</p>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#generateVariantsModal">
                    <i class="ti ti-refresh me-1"></i>Generate Variants
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Generate Variants Modal -->
<div class="modal fade" id="generateVariantsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold">Generate Product Variants</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.products.generate-variants', $product->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted fs-sm mb-3">Select the values for each attribute to generate all possible variant combinations.</p>
                    
                    @foreach($product->attributes as $index => $attribute)
                        <div class="mb-4">
                            <label class="form-label fw-medium">{{ $attribute->name }} <span class="text-danger">*</span></label>
                            <input type="hidden" name="attributes[{{ $index }}][attribute_id]" value="{{ $attribute->id }}">
                            <div class="row g-2">
                                @foreach($attribute->values as $value)
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form-check border rounded p-2">
                                            <input class="form-check-input" type="checkbox" name="attributes[{{ $index }}][values][]" value="{{ $value->id }}" id="val_{{ $value->id }}">
                                            <label class="form-check-label" for="val_{{ $value->id }}">
                                                {{ $value->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    @if($product->attributes->count() === 0)
                        <div class="alert alert-warning">
                            <i class="ti ti-alert-triangle me-2"></i>
                            No attributes selected for this product. Please add attributes first in the Basic Info tab.
                        </div>
                    @endif
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" {{ $product->attributes->count() === 0 ? 'disabled' : '' }}>
                        <i class="ti ti-refresh me-1"></i>Generate Variants
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Variant Modal -->
<div class="modal fade" id="editVariantModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title fw-semibold">
                    <i class="ti ti-edit me-2 text-primary"></i>Edit Variant
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editVariantForm" onsubmit="updateVariant(event)">
                <div class="modal-body">
                    <input type="hidden" id="variant_id" name="variant_id">
                    
                    <div class="row g-3">
                        <!-- Variant Name -->
                        <div class="col-12">
                            <label for="variant_name" class="form-label fw-medium">Variant Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="variant_name" name="name" required>
                            <small class="text-muted">This is the display name (e.g., "Red / Large")</small>
                        </div>

                        <!-- SKU -->
                        <div class="col-md-6">
                            <label for="variant_sku" class="form-label fw-medium">SKU</label>
                            <input type="text" class="form-control" id="variant_sku" name="sku">
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="variant_is_active" name="is_active" value="1">
                                <label class="form-check-label" for="variant_is_active">Active</label>
                            </div>
                        </div>

                        <!-- Pricing Section -->
                        <div class="col-12">
                            <hr class="my-2">
                            <h6 class="fw-semibold mb-3">Pricing</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="variant_price" class="form-label fw-medium">Regular Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="variant_price" name="price" step="0.01" min="0" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="variant_sale_price" class="form-label fw-medium">Sale Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="variant_sale_price" name="sale_price" step="0.01" min="0">
                            </div>
                        </div>

                        <!-- SEO Section -->
                        <div class="col-12">
                            <hr class="my-2">
                            <h6 class="fw-semibold mb-3">SEO (Optional)</h6>
                        </div>

                        <div class="col-12">
                            <label for="variant_meta_title" class="form-label fw-medium">Meta Title</label>
                            <input type="text" class="form-control" id="variant_meta_title" name="meta_title">
                        </div>

                        <div class="col-12">
                            <label for="variant_meta_desc" class="form-label fw-medium">Meta Description</label>
                            <textarea class="form-control" id="variant_meta_desc" name="meta_desc" rows="2"></textarea>
                        </div>

                        <div class="col-12">
                            <label for="variant_meta_keywords" class="form-label fw-medium">Meta Keywords</label>
                            <input type="text" class="form-control" id="variant_meta_keywords" name="meta_keywords">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Update Variant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Variant Modal -->
<div class="modal fade" id="deleteVariantModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger-subtle border-0">
                <h5 class="modal-title text-danger">
                    <i class="ti ti-alert-triangle me-2"></i>Delete Variant
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <div class="mx-auto mb-3 avatar-xl">
                        <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                            <i class="ti ti-trash fs-1"></i>
                        </div>
                    </div>
                    <h5 class="mb-2">Are you sure?</h5>
                    <p class="text-muted mb-0">Do you really want to delete this variant?</p>
                    <p class="text-muted">This action cannot be undone.</p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteVariant()">
                    <i class="ti ti-trash me-1"></i>Delete Variant
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentVariantId = null;
    let deleteVariantId = null;

    function editVariant(variantId) {
        currentVariantId = variantId;
        
        // Fetch variant data
        fetch(`/admin/variants/${variantId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('variant_id').value = data.id;
                document.getElementById('variant_name').value = data.name;
                document.getElementById('variant_sku').value = data.sku || '';
                document.getElementById('variant_price').value = data.price;
                document.getElementById('variant_sale_price').value = data.sale_price || '';
                document.getElementById('variant_is_active').checked = data.is_active == 1;
                document.getElementById('variant_meta_title').value = data.meta_title || '';
                document.getElementById('variant_meta_desc').value = data.meta_desc || '';
                document.getElementById('variant_meta_keywords').value = data.meta_keywords || '';

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('editVariantModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load variant data');
            });
    }

    function updateVariant(event) {
        event.preventDefault();
        
        const variantId = document.getElementById('variant_id').value;
        
        // Collect form data manually to handle checkbox properly
        const data = {
            name: document.getElementById('variant_name').value,
            sku: document.getElementById('variant_sku').value,
            price: document.getElementById('variant_price').value,
            sale_price: document.getElementById('variant_sale_price').value || 0,
            is_active: document.getElementById('variant_is_active').checked ? 1 : 0,
            meta_title: document.getElementById('variant_meta_title').value,
            meta_desc: document.getElementById('variant_meta_desc').value,
            meta_keywords: document.getElementById('variant_meta_keywords').value,
            _token: '{{ csrf_token() }}'
        };

        console.log('Updating variant:', variantId, data);

        // Make AJAX request
        fetch(`/admin/variants/${variantId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('editVariantModal'));
                if (modal) modal.hide();
                
                // Show success message and reload page
                alert(data.message);
                window.location.reload();
            } else {
                // Show validation errors
                if (data.errors) {
                    let errorMessage = 'Validation errors:\n';
                    Object.values(data.errors).forEach(errors => {
                        errorMessage += errors.join('\n') + '\n';
                    });
                    alert(errorMessage);
                } else {
                    alert('Failed to update variant: ' + (data.message || 'Unknown error'));
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update variant: ' + error.message);
        });

        return false;
    }

    function deleteVariantConfirm(variantId) {
        deleteVariantId = variantId;
        const modal = new bootstrap.Modal(document.getElementById('deleteVariantModal'));
        modal.show();
    }

    function confirmDeleteVariant() {
        if (!deleteVariantId) return;

        fetch(`/admin/variants/${deleteVariantId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteVariantModal'));
                if (modal) modal.hide();
                
                // Show success message and reload page
                alert(data.message);
                window.location.reload();
            } else {
                alert('Failed to delete variant: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete variant: ' + error.message);
        });
    }
</script>

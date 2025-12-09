<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="e.g., Credit Card, Cash on Delivery" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Details <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="details" placeholder="e.g., Pay with Visa, MasterCard, or AmEx" required>
                        <small class="text-muted">Brief description of the payment method</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <input type="file" class="form-control" name="icon" accept="image/*" onchange="previewCreateImage(event)">
                        <small class="text-muted">Supported formats: JPG, PNG, GIF, SVG (Max: 2MB)</small>
                        <div class="mt-2">
                            <img id="create_image_preview" src="" alt="Preview" style="max-width: 150px; max-height: 150px; display: none;" class="rounded border">
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
                    <button type="submit" class="btn btn-primary">Create Payment Method</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewCreateImage(event) {
        const preview = document.getElementById('create_image_preview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>

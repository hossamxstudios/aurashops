<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="edit_name" placeholder="e.g., Credit Card, Cash on Delivery" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Details <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="details" id="edit_details" placeholder="e.g., Pay with Visa, MasterCard, or AmEx" required>
                        <small class="text-muted">Brief description of the payment method</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <div class="mb-2" id="edit_current_image_container" style="display: none;">
                            <label class="small text-muted">Current Icon:</label>
                            <div>
                                <img id="edit_current_image" src="" alt="Current" style="max-width: 150px; max-height: 150px;" class="rounded border">
                            </div>
                        </div>
                        <input type="file" class="form-control" name="icon" accept="image/*" onchange="previewEditImage(event)">
                        <small class="text-muted">Supported formats: JPG, PNG, GIF, SVG (Max: 2MB). Leave empty to keep current icon.</small>
                        <div class="mt-2">
                            <img id="edit_image_preview" src="" alt="Preview" style="max-width: 150px; max-height: 150px; display: none;" class="rounded border">
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
                    <button type="submit" class="btn btn-primary">Update Payment Method</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editMethod(id) {
        fetch(`/admin/payment-methods/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/payment-methods/${id}`;
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_details').value = data.details;
                document.getElementById('edit_is_active').checked = data.is_active;

                // Show current icon if exists
                const currentImageContainer = document.getElementById('edit_current_image_container');
                const currentImage = document.getElementById('edit_current_image');
                const preview = document.getElementById('edit_image_preview');
                
                if (data.icon_url) {
                    currentImage.src = data.icon_url;
                    currentImageContainer.style.display = 'block';
                } else {
                    currentImageContainer.style.display = 'none';
                }
                
                // Reset preview
                preview.src = '';
                preview.style.display = 'none';

                const modal = new bootstrap.Modal(document.getElementById('editModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load payment method details');
            });
    }

    function previewEditImage(event) {
        const preview = document.getElementById('edit_image_preview');
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

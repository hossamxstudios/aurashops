<div class="offcanvas offcanvas-end" tabindex="-1" id="editOffCanvas" style="width: 500px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Edit Skin Tone</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editSkinToneForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="edit_name" class="form-label">Skin Tone Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name" name="name" required placeholder="e.g. Fair, Medium, Dark">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Enter a unique skin tone name</div>
            </div>

            <div class="mb-3">
                <label for="edit_image" class="form-label">Skin Tone Image</label>
                
                <!-- Current Image Display -->
                <div id="currentImageContainer" class="mb-2 d-none">
                    <label class="form-label fs-xs text-muted">Current Image:</label>
                    <div class="position-relative d-inline-block">
                        <img id="currentImage" src="" alt="Current" class="rounded border" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                    </div>
                </div>
                
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="edit_image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Upload a new image to replace the current one (JPEG, PNG, JPG, WEBP - Max: 2MB)</div>
                
                <!-- New Image Preview -->
                <div id="editImagePreview" class="mt-2 d-none">
                    <label class="form-label fs-xs text-muted">New Image Preview:</label>
                    <img id="editPreviewImg" src="" alt="Preview" class="rounded border" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Update Skin Tone
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editSkinTone(skinToneId) {
        // Reset preview
        document.getElementById('editImagePreview').classList.add('d-none');
        document.getElementById('currentImageContainer').classList.add('d-none');
        document.getElementById('edit_image').value = '';
        
        // Fetch skin tone data
        fetch(`/admin/skin-tones/${skinToneId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('edit_name').value = data.name;
                
                // Display current image if exists
                if (data.image_url) {
                    document.getElementById('currentImage').src = data.image_url;
                    document.getElementById('currentImageContainer').classList.remove('d-none');
                }
                
                // Set form action
                document.getElementById('editSkinToneForm').action = `/admin/skin-tones/${skinToneId}`;
                
                // Show offcanvas
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('editOffCanvas'));
                offcanvas.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load skin tone data');
            });
    }

    // Image preview for edit form
    document.getElementById('edit_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('editPreviewImg').src = event.target.result;
                document.getElementById('editImagePreview').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('editImagePreview').classList.add('d-none');
        }
    });
</script>

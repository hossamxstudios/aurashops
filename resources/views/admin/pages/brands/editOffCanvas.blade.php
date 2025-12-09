<div class="offcanvas offcanvas-end" tabindex="-1" id="editOffCanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Edit Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editBrandForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="edit_name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="edit_website" class="form-label">Website</label>
                <input type="url" class="form-control" id="edit_website" name="website" placeholder="https://example.com">
            </div>

            <div class="mb-3">
                <label for="edit_details" class="form-label">Details</label>
                <textarea class="form-control" id="edit_details" name="details" rows="3" placeholder="Brand description"></textarea>
            </div>

            <div class="mb-3">
                <label for="edit_logo" class="form-label">Logo</label>
                <input type="file" class="form-control" id="edit_logo" name="logo" accept="image/*" onchange="previewEditLogo(event)">
                <small class="text-muted">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF, WEBP, SVG</small>
            </div>

            <!-- Current Logo -->
            <div id="currentLogo" class="mb-3" style="display: none;">
                <label class="form-label">Current Logo</label>
                <div class="p-2 text-center rounded border">
                    <img id="current_logo_preview" src="" alt="Current" class="rounded img-fluid" style="max-height: 200px;">
                </div>
            </div>

            <!-- New Logo Preview -->
            <div id="editLogoPreview" class="mb-3" style="display: none;">
                <label class="form-label">New Preview</label>
                <div class="p-2 text-center rounded border">
                    <img id="edit_logo_preview" src="" alt="Preview" class="rounded img-fluid" style="max-height: 200px;">
                </div>
            </div>

            <div class="gap-2 mt-4 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Update Brand
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editBrand(brandId) {
        // Fetch brand data
        fetch(`/admin/brands/${brandId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_website').value = data.website || '';
                document.getElementById('edit_details').value = data.details || '';

                // Show current logo if exists
                if (data.logo_url) {
                    document.getElementById('current_logo_preview').src = data.logo_url;
                    document.getElementById('currentLogo').style.display = 'block';
                } else {
                    document.getElementById('currentLogo').style.display = 'none';
                }

                // Hide new preview
                document.getElementById('editLogoPreview').style.display = 'none';

                // Set form action
                document.getElementById('editBrandForm').action = `/admin/brands/${brandId}`;

                // Show offcanvas
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('editOffCanvas'));
                offcanvas.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load brand data');
            });
    }

    function previewEditLogo(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('edit_logo_preview').src = e.target.result;
                document.getElementById('editLogoPreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('editLogoPreview').style.display = 'none';
        }
    }
</script>

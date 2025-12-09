<div class="offcanvas offcanvas-end" tabindex="-1" id="editOffCanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="edit_name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="edit_gender_id" class="form-label">Gender</label>
                <select class="form-select" id="edit_gender_id" name="gender_id">
                    <option value="">Select Gender</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="edit_parent_id" class="form-label">Parent Category</label>
                <select class="form-select" id="edit_parent_id" name="parent_id">
                    <option value="">None (Top Level)</option>
                    @foreach($categories as $cat)
                        @if(!$cat->parent_id)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="edit_image" class="form-label">Image</label>
                <input type="file" class="form-control" id="edit_image" name="image" accept="image/*" onchange="previewEditImage(event)">
                <small class="text-muted">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF, WEBP</small>
            </div>

            <!-- Current Image -->
            <div id="currentImage" class="mb-3" style="display: none;">
                <label class="form-label">Current Image</label>
                <div class="p-2 text-center rounded border">
                    <img id="current_preview" src="" alt="Current" class="rounded img-fluid" style="max-height: 200px;">
                </div>
            </div>

            <!-- New Image Preview -->
            <div id="editImagePreview" class="mb-3" style="display: none;">
                <label class="form-label">New Preview</label>
                <div class="p-2 text-center rounded border">
                    <img id="edit_preview" src="" alt="Preview" class="rounded img-fluid" style="max-height: 200px;">
                </div>
            </div>

            <div class="gap-2 mt-4 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Update Category
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editCategory(categoryId) {
        // Fetch category data
        fetch(`/admin/categories/${categoryId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_gender_id').value = data.gender_id || '';
                document.getElementById('edit_parent_id').value = data.parent_id || '';

                // Disable the current category in parent dropdown to prevent circular reference
                const parentSelect = document.getElementById('edit_parent_id');
                Array.from(parentSelect.options).forEach(option => {
                    if (option.value == categoryId) {
                        option.disabled = true;
                        option.hidden = true;
                    } else {
                        option.disabled = false;
                        option.hidden = false;
                    }
                });

                // Show current image if exists
                if (data.image_url) {
                    document.getElementById('current_preview').src = data.image_url;
                    document.getElementById('currentImage').style.display = 'block';
                } else {
                    document.getElementById('currentImage').style.display = 'none';
                }

                // Hide new preview
                document.getElementById('editImagePreview').style.display = 'none';

                // Set form action
                document.getElementById('editCategoryForm').action = `/admin/categories/${categoryId}`;

                // Show offcanvas
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('editOffCanvas'));
                offcanvas.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load category data');
            });
    }

    function previewEditImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('edit_preview').src = e.target.result;
                document.getElementById('editImagePreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('editImagePreview').style.display = 'none';
        }
    }
</script>

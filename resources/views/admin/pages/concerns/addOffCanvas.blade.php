<div class="offcanvas offcanvas-end" tabindex="-1" id="addOffCanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Add New Concern</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('admin.concerns.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                    <option value="">Select Type</option>
                    <option value="skin" {{ old('type') == 'skin' ? 'selected' : '' }}>Skin</option>
                    <option value="hair" {{ old('type') == 'hair' ? 'selected' : '' }}>Hair</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="details" class="form-label">Details</label>
                <textarea class="form-control @error('details') is-invalid @enderror" id="details" name="details" rows="3">{{ old('details') }}</textarea>
                @error('details')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF, WEBP</small>
            </div>

            <!-- Image Preview -->
            <div id="imagePreview" class="mb-3" style="display: none;">
                <label class="form-label">Preview</label>
                <div class="p-2 text-center rounded border">
                    <img id="preview" src="" alt="Preview" class="rounded img-fluid" style="max-height: 200px;">
                </div>
            </div>

            <div class="gap-2 mt-4 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Add Concern
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('imagePreview').style.display = 'none';
        }
    }
</script>

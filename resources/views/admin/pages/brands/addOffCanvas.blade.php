<div class="offcanvas offcanvas-end" tabindex="-1" id="addOffCanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Add New Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="website" class="form-label">Website</label>
                <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website') }}" placeholder="https://example.com">
                @error('website')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="details" class="form-label">Details</label>
                <textarea class="form-control @error('details') is-invalid @enderror" id="details" name="details" rows="3" placeholder="Brand description">{{ old('details') }}</textarea>
                @error('details')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*" onchange="previewLogo(event)">
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF, WEBP, SVG</small>
            </div>

            <!-- Logo Preview -->
            <div id="logoPreview" class="mb-3" style="display: none;">
                <label class="form-label">Preview</label>
                <div class="p-2 text-center rounded border">
                    <img id="preview" src="" alt="Preview" class="rounded img-fluid" style="max-height: 200px;">
                </div>
            </div>

            <div class="gap-2 mt-4 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Add Brand
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewLogo(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('logoPreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('logoPreview').style.display = 'none';
        }
    }
</script>

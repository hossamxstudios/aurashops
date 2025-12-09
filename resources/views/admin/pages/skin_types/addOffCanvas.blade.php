<div class="offcanvas offcanvas-end" tabindex="-1" id="addOffCanvas" style="width: 500px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Add New Skin Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('admin.skin-types.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Skin Type Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}" placeholder="e.g. Oily, Dry, Combination">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Enter a unique skin type name</div>
            </div>

            <div class="mb-3">
                <label for="details" class="form-label">Details</label>
                <textarea class="form-control @error('details') is-invalid @enderror" id="details" name="details" rows="4" placeholder="Enter description or characteristics of this skin type">{{ old('details') }}</textarea>
                @error('details')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Optional: Add details about this skin type</div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Skin Type Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Upload an image representing this skin type (JPEG, PNG, JPG, WEBP - Max: 2MB)</div>
                
                <!-- Image Preview -->
                <div id="imagePreview" class="mt-2 d-none">
                    <img id="previewImg" src="" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Create Skin Type
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Image preview for add form
    document.getElementById('image')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('previewImg').src = event.target.result;
                document.getElementById('imagePreview').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('imagePreview').classList.add('d-none');
        }
    });
</script>

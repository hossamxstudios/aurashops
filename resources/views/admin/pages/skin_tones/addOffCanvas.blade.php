<div class="offcanvas offcanvas-end" tabindex="-1" id="addOffCanvas" style="width: 500px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Add New Skin Tone</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('admin.skin-tones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Skin Tone Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}" placeholder="e.g. Fair, Medium, Dark">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Enter a unique skin tone name</div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Skin Tone Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Upload an image representing this skin tone (JPEG, PNG, JPG, WEBP - Max: 2MB)</div>
                
                <!-- Image Preview -->
                <div id="imagePreview" class="mt-2 d-none">
                    <img id="previewImg" src="" alt="Preview" class="rounded" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Create Skin Tone
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Image preview for add form
    document.getElementById('image').addEventListener('change', function(e) {
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

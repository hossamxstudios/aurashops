<div class="offcanvas offcanvas-end" tabindex="-1" id="addOffCanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Add New Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gender_id" class="form-label">Gender</label>
                <select class="form-select @error('gender_id') is-invalid @enderror" id="gender_id" name="gender_id">
                    <option value="">Select Gender</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender->id }}" {{ old('gender_id') == $gender->id ? 'selected' : '' }}>
                            {{ $gender->name }}
                        </option>
                    @endforeach
                </select>
                @error('gender_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Category</label>
                <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                    <option value="">None (Top Level)</option>
                    @foreach($categories as $cat)
                        @if(!$cat->parent_id)
                            <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('parent_id')
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
                    <i class="ti ti-check me-1"></i>Add Category
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

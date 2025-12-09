<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <h5 class="mb-3 fw-semibold">Product Thumbnail</h5>
        <div class="row">
            <div class="col-md-6">
                @if($product->getMedia('product_thumbnail')->first())
                    <div class="mb-3">
                        <img src="{{ $product->getMedia('product_thumbnail')->first()->getUrl() }}" alt="Thumbnail" class="rounded img-fluid" style="max-height: 200px;">
                    </div>
                @else
                    <div class="mb-3 text-center p-4 bg-light rounded">
                        <i class="ti ti-photo text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">No thumbnail uploaded</p>
                    </div>
                @endif
                
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="{{ $product->type }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="details" value="{{ $product->details }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <input type="hidden" name="base_price" value="{{ $product->base_price }}">
                    
                    <div class="mb-2">
                        <input type="file" class="form-control" name="thumbnail" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-upload me-1"></i>Upload Thumbnail
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold">Product Gallery</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#uploadGallery">
                <i class="ti ti-upload me-1"></i>Upload Images
            </button>
        </div>

        <!-- Upload Form (Collapsed) -->
        <div class="collapse mb-3" id="uploadGallery">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="border rounded p-3 bg-light">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="{{ $product->type }}">
                <input type="hidden" name="name" value="{{ $product->name }}">
                <input type="hidden" name="details" value="{{ $product->details }}">
                <input type="hidden" name="price" value="{{ $product->price }}">
                <input type="hidden" name="base_price" value="{{ $product->base_price }}">
                
                <div class="mb-2">
                    <label class="form-label fw-medium">Select Images</label>
                    <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
                    <small class="text-muted">You can select multiple images</small>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ti ti-upload me-1"></i>Upload Images
                </button>
            </form>
        </div>

        <!-- Gallery Images -->
        @if($product->getMedia('product_images')->count() > 0)
            <div class="row g-3">
                @foreach($product->getMedia('product_images') as $image)
                    <div class="col-md-3 col-sm-6">
                        <div class="position-relative">
                            <img src="{{ $image->getUrl() }}" alt="Product Image" class="rounded img-fluid w-100" style="height: 150px; object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="deleteImage({{ $image->id }})">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="ti ti-photo text-muted" style="font-size: 3rem; opacity: 0.15;"></i>
                <h6 class="text-muted fw-semibold mt-3">No Gallery Images</h6>
                <p class="text-muted fs-sm">Upload images to create a product gallery</p>
            </div>
        @endif
    </div>
</div>

<script>
    function deleteImage(imageId) {
        if (confirm('Are you sure you want to delete this image?')) {
            // Implementation would require a delete image route
            alert('Delete image functionality to be implemented');
        }
    }
</script>

<!-- Basic Information -->
<div class="mb-3 border-0 shadow-sm card">
    <div class="card-body">
        <h5 class="mb-3 fw-semibold">Basic Information</h5>
        <div class="row g-3">
            <div class="col-md-8">
                <label for="name" class="form-label fw-medium">Product Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name', $product->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="sku" class="form-label fw-medium">SKU</label>
                <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
            </div>

            <div class="col-md-8">
                <label for="barcode" class="form-label fw-medium">
                    <i class="ti ti-barcode me-1"></i>Barcode
                </label>
                <div class="input-group">
                    <input type="text" class="form-control @error('barcode') is-invalid @enderror" id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}" placeholder="Enter or scan barcode">
                    <button type="button" class="btn btn-warning" onclick="openEditBarcodeScan()">
                        <i class="ti ti-qrcode me-1"></i>Scan
                    </button>
                </div>
                @error('barcode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">
                    <i class="ti ti-info-circle"></i>
                    Use barcode scanner or enter manually
                </small>
            </div>

            <div class="col-12">
                <label for="details" class="form-label fw-medium">Details <span class="text-danger">*</span></label>
                <textarea class="form-control" id="details" name="details" rows="4" required>{{ old('details', $product->details) }}</textarea>
            </div>

        </div>
    </div>
</div>

<!-- Classification (Gender, Brand, Categories) -->
<div class="mb-3 border-0 shadow-sm card">
    <div class="card-body">
        <h5 class="mb-3 fw-semibold"><i class="ti ti-category me-2 text-success"></i>Product Classification</h5>
        <div class="row g-3">
            <!-- Gender Selection -->
            <div class="col-md-6">
                <label for="gender_id" class="form-label fw-medium">Gender <span class="text-danger">*</span></label>
                <select class="form-select @error('gender_id') is-invalid @enderror" id="gender_id" name="gender_id" required onchange="filterCategoriesByGender()">
                    <option value="">Select Gender</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender->id }}" {{ old('gender_id', $product->gender_id) == $gender->id ? 'selected' : '' }}>{{ $gender->name }}</option>
                    @endforeach
                </select>
                @error('gender_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Brand Selection -->
            <div class="col-md-6">
                <label for="brand_id" class="form-label fw-medium">Brand <span class="text-danger">*</span></label>
                <select class="form-select @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id" required>
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
                @error('brand_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Categories Selection -->
            <div class="col-12" id="categories-section">
                <label class="form-label fw-medium">Main Categories <span class="text-danger">*</span></label>
                <p class="mb-2 text-muted fs-sm">Select at least one category</p>
                @error('categories')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <!-- Message when no gender selected -->
                <div id="no-gender-message" class="alert alert-info" style="display: {{ old('gender_id', $product->gender_id) ? 'none' : 'block' }};">
                    <i class="ti ti-info-circle me-2"></i>Please select a gender first to see available categories
                </div>

                <!-- Message when no categories for selected gender -->
                <div id="no-categories-message" class="alert alert-warning" style="display: none;">
                    <i class="ti ti-alert-triangle me-2"></i>No categories available for this gender
                </div>

                <div id="main-categories-container" class="row g-2" style="display: {{ old('gender_id', $product->gender_id) ? 'flex' : 'none' }};">
                    @if($categories->count() > 0)
                        @foreach($categories as $category)
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 category-item" data-gender-id="{{ $category->gender_id }}" style="display: {{ old('gender_id', $product->gender_id) == $category->gender_id ? 'block' : 'none' }};">
                                <input type="checkbox" class="btn-check main-category-checkbox" name="categories[]" value="{{ $category->id }}" id="cat_{{ $category->id }}" {{ $product->categories->contains($category->id) ? 'checked' : '' }} onchange="toggleSubcategories({{ $category->id }})">
                                <label class="p-2 btn btn-outline-primary w-100" for="cat_{{ $category->id }}">
                                    <div class="text-center">
                                        @if($category->getMedia('category_image')->first())
                                            <img src="{{ $category->getMedia('category_image')->first()->getUrl() }}" alt="{{ $category->name }}" class="mb-2 rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <i class="ti ti-folder fs-5"></i>
                                        @endif
                                        <div class="mt-1 fw-medium fs-xs">{{ $category->name }}</div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    @else
                        <div class="py-3 text-center col-12">
                            <i class="ti ti-folder text-muted" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="mt-2 text-muted">No categories available</p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Subcategories (Dynamic) -->
            @foreach($categories as $category)
                @if($category->children->count() > 0)
                    <div class="col-12 subcategory-container" id="subcategories_{{ $category->id }}" style="display: {{ $product->categories->contains($category->id) ? 'block' : 'none' }};">
                        <label class="form-label fw-medium text-primary">
                            <i class="ti ti-chevron-right me-1"></i>Subcategories of "{{ $category->name }}"
                        </label>
                        <div class="row g-2">
                            @foreach($category->children as $subcategory)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <input type="checkbox" class="btn-check" name="categories[]" value="{{ $subcategory->id }}" id="cat_{{ $subcategory->id }}" {{ $product->categories->contains($subcategory->id) ? 'checked' : '' }}>
                                    <label class="p-2 btn btn-outline-secondary w-100" for="cat_{{ $subcategory->id }}">
                                        <div class="text-center">
                                            @if($subcategory->getMedia('category_image')->first())
                                                <img src="{{ $subcategory->getMedia('category_image')->first()->getUrl() }}" alt="{{ $subcategory->name }}" class="mb-2 rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <i class="ti ti-folder-open fs-5"></i>
                                            @endif
                                            <div class="mt-1 fw-medium fs-xs">{{ $subcategory->name }}</div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Pricing -->
<div class="mb-3 border-0 shadow-sm card">
    <div class="card-body">
        <h5 class="mb-3 fw-semibold">Pricing</h5>
        <div class="row g-3">
            @if($product->type === 'simple')
                <div class="col-md-4">
                    <label for="base_price" class="form-label fw-medium">Base Price (Wholesale)</label>
                    <div class="input-group">
                        <span class="input-group-text">EGP</span>
                        <input type="number" class="form-control" id="base_price" name="base_price" step="0.01" min="0" value="{{ old('base_price', $product->base_price) }}">
                    </div>
                    <small class="text-muted">Cost/wholesale price (Optional)</small>
                </div>

                <div class="col-md-4">
                    <label for="price" class="form-label fw-medium">Regular Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">EGP</span>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="sale_price" class="form-label fw-medium">Sale Price</label>
                    <div class="input-group">
                        <span class="input-group-text">EGP</span>
                        <input type="number" class="form-control" id="sale_price" name="sale_price" step="0.01" min="0" value="{{ old('sale_price', $product->sale_price) }}">
                    </div>
                </div>
            @else
                <div class="col-md-4">
                    <label for="base_price" class="form-label fw-medium">Base Price (Wholesale)</label>
                    <div class="input-group">
                        <span class="input-group-text">EGP</span>
                        <input type="number" class="form-control" id="base_price" name="base_price" step="0.01" min="0" value="{{ old('base_price', $product->base_price) }}">
                    </div>
                    <small class="text-muted">Cost/wholesale price (Optional)</small>
                </div>

                <div class="col-md-4">
                    <label for="price" class="form-label fw-medium">Regular Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">EGP</span>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
                    </div>
                    <small class="text-muted">Default regular price for variants</small>
                </div>

                <div class="col-md-4">
                    <label for="sale_price" class="form-label fw-medium">Sale Price</label>
                    <div class="input-group">
                        <span class="input-group-text">EGP</span>
                        <input type="number" class="form-control" id="sale_price" name="sale_price" step="0.01" min="0" value="{{ old('sale_price', $product->sale_price) }}">
                    </div>
                    <small class="text-muted">Default sale price for variants (optional)</small>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Attributes (Variant Only) -->
@if($product->type === 'variant')
<div class="mb-3 border-0 shadow-sm card">
    <div class="card-body">
        <h5 class="mb-3 fw-semibold"><i class="ti ti-tag me-2 text-warning"></i>Product Attributes</h5>
        <p class="mb-3 text-muted fs-sm">Update product attributes. Regenerate variants after changing attributes.</p>
        <div class="row g-3">
            @foreach($attributes as $attribute)
                <div class="col-md-4 col-sm-6">
                    <input type="checkbox" class="btn-check" name="attributes[]" value="{{ $attribute->id }}" id="attr_{{ $attribute->id }}" {{ $product->attributes->contains($attribute->id) ? 'checked' : '' }}>
                    <label class="p-3 btn btn-outline-primary w-100 text-start" for="attr_{{ $attribute->id }}" style="height: 100%; border-width: 2px;">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <i class="ti ti-tag text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $attribute->name }}</div>
                                <small class="text-muted fs-xs">{{ $attribute->values->count() }} values</small>
                            </div>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Tags -->
<div class="mb-3 border-0 shadow-sm card">
    <div class="card-body">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-semibold"><i class="ti ti-tags me-2 text-primary"></i>Product Tags</h5>
                <p class="mb-0 text-muted fs-sm">Select tags to help customers find this product</p>
            </div>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTagModal">
                <i class="ti ti-plus me-1"></i>Add New Tag
            </button>
        </div>
        <div id="tags-container" class="row g-2">
            @if($tags->count() > 0)
                @foreach($tags as $tag)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <input type="checkbox" class="btn-check" name="tags[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}" {{ $product->tags->contains($tag->id) ? 'checked' : '' }}>
                        <label class="p-2 btn btn-outline-primary w-100" for="tag_{{ $tag->id }}">
                            <div class="text-center">
                                <i class="ti ti-tag fs-5"></i>
                                <div class="mt-1 fw-medium fs-xs">{{ $tag->name }}</div>
                            </div>
                        </label>
                    </div>
                @endforeach
            @else
                <div class="py-4 text-center col-12" id="no-tags-message">
                    <i class="ti ti-tags text-muted" style="font-size: 2rem; opacity: 0.3;"></i>
                    <p class="mt-2 text-muted">No tags available yet</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Tag Modal -->
<div class="modal fade" id="addTagModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-tag me-2"></i>Add New Tag
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="new_tag_name" class="form-label fw-medium">Tag Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="new_tag_name" placeholder="Enter tag name">
                    <small class="text-muted">e.g., Summer Collection, Best Seller, New Arrival</small>
                </div>
                <div id="tag-error-message" class="alert alert-danger" style="display: none;"></div>
                <div id="tag-success-message" class="alert alert-success" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="createNewTag()">
                    <i class="ti ti-check me-1"></i>Create & Select
                </button>
            </div>
        </div>
    </div>
</div>

<!-- SEO & Settings -->
<div class="mb-3 border-0 shadow-sm card">
    <div class="card-body">
        <h5 class="mb-3 fw-semibold">SEO & Settings</h5>
        <div class="row g-3">
            <div class="col-12">
                <label for="meta_title" class="form-label fw-medium">Meta Title</label>
                <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}">
            </div>

            <div class="col-12">
                <label for="meta_desc" class="form-label fw-medium">Meta Description</label>
                <textarea class="form-control" id="meta_desc" name="meta_desc" rows="2">{{ old('meta_desc', $product->meta_desc) }}</textarea>
            </div>

            <div class="col-12">
                <label for="meta_keywords" class="form-label fw-medium">Meta Keywords</label>
                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $product->meta_keywords) }}">
            </div>

            <div class="col-md-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured</label>
                </div>
            </div>
        </div>
    </div>
</div>

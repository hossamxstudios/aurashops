<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Create Product</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="py-1 pt-4 row justify-content-center">
                        <div class="text-center col-xxl-9 col-xl-10">
                            <a href="{{ route('admin.products.index') }}" class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm">
                                <i data-lucide="arrow-left" class="fs-sm me-1"></i> Back to Products
                            </a>
                            <h3 class="fw-bold">Create New Product</h3>
                        </div>
                    </div>
                    <!-- Form -->
                    <div class="row justify-content-center">
                        <div class="col-xxl-9 col-xl-10">
                            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                                @csrf
                                <!-- Product Type Selection -->
                                <div class="mb-3 border-0 shadow-sm card">
                                    <div class="card-body">
                                        <h5 class="mb-3 fw-semibold">Choose Product Type</h5>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <input type="radio" class="btn-check" name="type" id="type_simple" value="simple" {{ old('type', 'simple') == 'simple' ? 'checked' : '' }} onchange="toggleProductType()">
                                                <label class="p-4 btn btn-outline-primary w-100 text-start product-type-card" for="type_simple" style="height: 100%; border-width: 2px;">
                                                    <div class="d-flex align-items-start">
                                                        <div class="p-3 rounded-3 bg-primary-subtle me-3">
                                                            <i class="ti ti-box text-primary" style="font-size: 2.5rem;"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h4 class="mb-2 fw-bold">Simple Product</h4>
                                                            <p class="mb-2 fs-sm">Perfect for standalone items with a single price point</p>
                                                            <ul class="mb-0 list-unstyled fs-xs">
                                                                <li><i class="ti ti-check me-1"></i>Fixed pricing</li>
                                                                <li><i class="ti ti-check me-1"></i>No variations</li>
                                                                <li><i class="ti ti-check me-1"></i>Quick setup</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="radio" class="btn-check" name="type" id="type_variant" value="variant" {{ old('type') == 'variant' ? 'checked' : '' }} onchange="toggleProductType()">
                                                <label class="p-4 btn btn-outline-primary w-100 text-start product-type-card" for="type_variant" style="height: 100%; border-width: 2px;">
                                                    <div class="d-flex align-items-start">
                                                        <div class="p-3 rounded-3 bg-primary-subtle me-3">
                                                            <i class="ti ti-versions text-primary" style="font-size: 2.5rem;"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="mb-2 fw-bold">Variant Product</h5>
                                                            <p class="mb-2 fs-sm">For products with multiple options like size, color, etc.</p>
                                                            <ul class="mb-0 list-unstyled fs-xs">
                                                                <li><i class="ti ti-check me-1"></i>Multiple variants</li>
                                                                <li><i class="ti ti-check me-1"></i>Flexible attributes</li>
                                                                <li><i class="ti ti-check me-1"></i>Auto-generation</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="radio" class="btn-check" name="type" id="type_bundle" value="bundle" {{ old('type') == 'bundle' ? 'checked' : '' }} onchange="toggleProductType()">
                                                <label class="p-4 btn btn-outline-primary w-100 text-start product-type-card" for="type_bundle" style="height: 100%; border-width: 2px;">
                                                    <div class="d-flex align-items-start">
                                                        <div class="p-3 rounded-3 bg-primary-subtle me-3">
                                                            <i class="ti ti-box-multiple text-primary" style="font-size: 2.5rem;"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="mb-2 fw-bold">Bundle Product</h5>
                                                            <p class="mb-2 fs-sm">Combine multiple products into a single package</p>
                                                            <ul class="mb-0 list-unstyled fs-xs">
                                                                <li><i class="ti ti-check me-1"></i>Multiple products</li>
                                                                <li><i class="ti ti-check me-1"></i>Bundle pricing</li>
                                                                <li><i class="ti ti-check me-1"></i>Variant options</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Basic Information -->
                                <div class="mb-3 border-0 shadow-sm card">
                                    <div class="card-body">
                                        <h5 class="mb-3 fw-semibold">Basic Information</h5>
                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <label for="name" class="form-label fw-medium">Product Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}" placeholder="Enter product name">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="sku" class="form-label fw-medium">SKU</label>
                                                <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku') }}" placeholder="Product SKU">
                                                @error('sku')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-8">
                                                <label for="barcode" class="form-label fw-medium">
                                                    <i class="ti ti-barcode me-1"></i>Barcode
                                                </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control @error('barcode') is-invalid @enderror" id="barcode" name="barcode" value="{{ old('barcode') }}" placeholder="Enter or scan barcode">
                                                    <button type="button" class="btn btn-warning" onclick="openCreateBarcodeScan()">
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
                                                <textarea class="form-control @error('details') is-invalid @enderror" id="details" name="details" rows="4" required placeholder="Product description">{{ old('details') }}</textarea>
                                                @error('details')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                                        <option value="{{ $gender->id }}" {{ old('gender_id') == $gender->id ? 'selected' : '' }}>{{ $gender->name }}</option>
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
                                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
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
                                                <div id="no-gender-message" class="alert alert-info">
                                                    <i class="ti ti-info-circle me-2"></i>Please select a gender first to see available categories
                                                </div>

                                                <!-- Message when no categories for selected gender -->
                                                <div id="no-categories-message" class="alert alert-warning" style="display: none;">
                                                    <i class="ti ti-alert-triangle me-2"></i>No categories available for this gender
                                                </div>

                                                <div id="main-categories-container" class="row g-2" style="display: none;">
                                                    @if($categories->count() > 0)
                                                        @foreach($categories as $category)
                                                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 category-item" data-gender-id="{{ $category->gender_id }}" style="display: none;">
                                                                <input type="checkbox" class="btn-check main-category-checkbox" name="categories[]" value="{{ $category->id }}" id="cat_{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }} onchange="toggleSubcategories({{ $category->id }})">
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
                                                    <div class="col-12 subcategory-container" id="subcategories_{{ $category->id }}" style="display: none;">
                                                        <label class="form-label fw-medium text-primary">
                                                            <i class="ti ti-chevron-right me-1"></i>Subcategories of "{{ $category->name }}"
                                                        </label>
                                                        <div class="row g-2">
                                                            @foreach($category->children as $subcategory)
                                                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                                                    <input type="checkbox" class="btn-check" name="categories[]" value="{{ $subcategory->id }}" id="cat_{{ $subcategory->id }}" {{ in_array($subcategory->id, old('categories', [])) ? 'checked' : '' }}>
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

                                <!-- Base Price (Always Visible) -->
                                <div class="mb-3 border-0 shadow-sm card">
                                    <div class="card-body">
                                        <h5 class="mb-3 fw-semibold">
                                            <i class="ti ti-shopping-cart me-2"></i>Base Price (Cost)
                                        </h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="base_price" class="form-label fw-medium">Wholesale / Cost Price <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">EGP</span>
                                                    <input type="number" class="form-control @error('base_price') is-invalid @enderror" id="base_price" name="base_price" step="0.01" min="0" value="{{ old('base_price') }}" placeholder="0.00" required>
                                                </div>
                                                <small class="text-muted">The cost price you pay for this product (used for profit calculation)</small>
                                                @error('base_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing (Simple Product) -->
                                <div class="mb-3 border-0 shadow-sm card" id="simple_pricing">
                                    <div class="card-body">
                                        <h5 class="mb-3 fw-semibold">Pricing</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="price" class="form-label fw-medium">Regular Price <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">EGP</span>
                                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" step="0.01" min="0" value="{{ old('price') }}" placeholder="0.00">
                                                </div>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="sale_price" class="form-label fw-medium">Sale Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">EGP</span>
                                                    <input type="number" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" step="0.01" min="0" value="{{ old('sale_price') }}" placeholder="0.00">
                                                </div>
                                                @error('sale_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Pricing (Variant Product) -->
                                <div class="mb-3 border-0 shadow-sm card" id="variant_pricing" style="display: none;">
                                    <div class="card-body">
                                        <h5 class="mb-3 fw-semibold">Default Pricing for Variants</h5>
                                        <p class="mb-3 text-muted fs-sm">Set default prices that will be applied to all generated variants</p>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="variant_price" class="form-label fw-medium">Regular Price <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">EGP</span>
                                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="variant_price" name="variant_price" step="0.01" min="0" value="{{ old('variant_price') }}" placeholder="0.00">
                                                </div>
                                                <small class="text-muted">Default regular price for all variants</small>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="variant_sale_price" class="form-label fw-medium">Sale Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">EGP</span>
                                                    <input type="number" class="form-control @error('sale_price') is-invalid @enderror" id="variant_sale_price" name="variant_sale_price" step="0.01" min="0" value="{{ old('variant_sale_price') }}" placeholder="0.00">
                                                </div>
                                                <small class="text-muted">Default sale price for all variants (optional)</small>
                                                @error('sale_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Attributes (Variant Product Only) -->
                                <div class="mb-3 border-0 shadow-sm card" id="variant_attributes" style="display: none;">
                                    <div class="card-body">
                                        <h5 class="mb-3 fw-semibold"><i class="ti ti-tag me-2 text-warning"></i>Product Attributes & Values</h5>
                                        <p class="mb-4 text-muted fs-sm">Select attributes and their values. All combinations will be auto-generated as variants.</p>
                                        @if($attributes->count() > 0)
                                            <div class="accordion" id="attributesAccordion">
                                                @foreach($attributes as $index => $attribute)
                                                    <div class="mb-2 rounded border accordion-item">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#attr_collapse_{{ $attribute->id }}">
                                                                <div class="form-check me-3" onclick="event.stopPropagation();">
                                                                    <input class="form-check-input attribute-checkbox" type="checkbox" id="attr_check_{{ $attribute->id }}" data-attr-id="{{ $attribute->id }}" onchange="toggleAttributeValues({{ $attribute->id }})">
                                                                </div>
                                                                <div class="d-flex align-items-center flex-grow-1">
                                                                    <div class="me-3">
                                                                        <i class="ti ti-tag text-primary" style="font-size: 1.5rem;"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0 fw-semibold">{{ $attribute->name }}</h6>
                                                                        <small class="text-muted">{{ $attribute->values->count() }} available values</small>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </h2>
                                                        <div id="attr_collapse_{{ $attribute->id }}" class="accordion-collapse collapse" data-bs-parent="#attributesAccordion">
                                                            <div class="accordion-body">
                                                                <p class="mb-3 text-muted fs-sm">Select the values you want to use for this attribute:</p>
                                                                <div class="row g-2">
                                                                    @foreach($attribute->values as $value)
                                                                        <div class="col-md-3 col-sm-4 col-6">
                                                                            <div class="value-select-card">
                                                                                <input type="checkbox" class="btn-check value-checkbox" name="attribute_values[{{ $attribute->id }}][]" value="{{ $value->id }}" id="val_{{ $value->id }}" data-attr-id="{{ $attribute->id }}" disabled>
                                                                                <label class="btn btn-outline-primary w-100 text-start" for="val_{{ $value->id }}" style="padding: 0.5rem;">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <i class="ti ti-circle-filled me-2 fs-xs"></i>
                                                                                        <span class="fw-medium">{{ $value->name }}</span>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="py-4 text-center">
                                                <i class="ti ti-tag text-muted" style="font-size: 2rem; opacity: 0.3;"></i>
                                                <p class="mt-2 text-muted">No attributes available. Please create attributes first.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Bundle Items (Bundle Product Only) -->
                                <div id="bundle_items" style="display: none;">
                                    @include('admin.pages.products.parts.bundle-manager')
                                </div>
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
                                                        <input type="checkbox" class="btn-check" name="tags[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
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

                                <!-- Images -->
                                <div class="mb-3 border-0 shadow-sm card">
                                    <div class="card-body">
                                        <h5 class="mb-3 fw-semibold">Product Images</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="thumbnail" class="form-label fw-medium">Thumbnail Image</label>
                                                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewThumbnail(event)">
                                                <small class="text-muted">Recommended: 500x500px</small>
                                                @error('thumbnail')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div id="thumbnailPreview" class="mt-2" style="display: none;">
                                                    <img id="thumbnail_preview" src="" alt="Preview" class="rounded img-fluid" style="max-height: 150px;">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="images" class="form-label fw-medium">Gallery Images</label>
                                                <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" accept="image/*" multiple onchange="previewGallery(event)">
                                                <small class="text-muted">You can select multiple images</small>
                                                @error('images')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div id="galleryPreview" class="flex-wrap gap-2 mt-2 d-flex"></div>
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
                                                <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" placeholder="SEO title">
                                            </div>

                                            <div class="col-12">
                                                <label for="meta_desc" class="form-label fw-medium">Meta Description</label>
                                                <textarea class="form-control" id="meta_desc" name="meta_desc" rows="2" placeholder="SEO description">{{ old('meta_desc') }}</textarea>
                                            </div>

                                            <div class="col-12">
                                                <label for="meta_keywords" class="form-label fw-medium">Meta Keywords</label>
                                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check form-control-lg form-switch">
                                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">Active</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check form-switch form-control-lg">
                                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_featured">Featured</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="mb-3 border-0 shadow-sm card">
                                    <div class="card-body">
                                        <div class="gap-2 d-flex justify-content-end">
                                            <a href="{{ route('admin.products.index') }}" class="btn btn-light">Cancel</a>
                                            <button type="submit" class="btn btn-primary" onclick="return validateCategorySelection()">
                                                <i class="ti ti-check me-1"></i>Create Product
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')

    <script>
        function toggleProductType() {
            const type = document.querySelector('input[name="type"]:checked').value;

            if (type === 'simple') {
                document.getElementById('simple_pricing').style.display = 'block';
                document.getElementById('variant_pricing').style.display = 'none';
                document.getElementById('variant_attributes').style.display = 'none';
                document.getElementById('bundle_items').style.display = 'none';
                document.getElementById('price').required = true;
                document.getElementById('variant_price').required = false;
            } else if (type === 'variant') {
                document.getElementById('simple_pricing').style.display = 'none';
                document.getElementById('variant_pricing').style.display = 'block';
                document.getElementById('variant_attributes').style.display = 'block';
                document.getElementById('bundle_items').style.display = 'none';
                document.getElementById('price').required = false;
                document.getElementById('variant_price').required = true;
            } else if (type === 'bundle') {
                document.getElementById('simple_pricing').style.display = 'block';
                document.getElementById('variant_pricing').style.display = 'none';
                document.getElementById('variant_attributes').style.display = 'none';
                document.getElementById('bundle_items').style.display = 'block';
                document.getElementById('price').required = true;
                document.getElementById('variant_price').required = false;
            }
        }

        function previewThumbnail(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('thumbnail_preview').src = e.target.result;
                    document.getElementById('thumbnailPreview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }

        function previewGallery(event) {
            const files = event.target.files;
            const container = document.getElementById('galleryPreview');
            container.innerHTML = '';

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'rounded';
                    img.style.maxHeight = '100px';
                    container.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }

        function toggleAttributeValues(attributeId) {
            const checkbox = document.getElementById('attr_check_' + attributeId);
            const valueCheckboxes = document.querySelectorAll('.value-checkbox[data-attr-id="' + attributeId + '"]');

            if (checkbox.checked) {
                // Enable all value checkboxes for this attribute
                valueCheckboxes.forEach(cb => {
                    cb.disabled = false;
                });
            } else {
                // Disable and uncheck all value checkboxes for this attribute
                valueCheckboxes.forEach(cb => {
                    cb.disabled = true;
                    cb.checked = false;
                });
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleProductType();
        });

        // Filter Categories by Gender
        function filterCategoriesByGender() {
            const genderId = document.getElementById('gender_id').value;
            const categoryItems = document.querySelectorAll('.category-item');
            const categoriesContainer = document.getElementById('main-categories-container');
            const noGenderMessage = document.getElementById('no-gender-message');
            const noCategoriesMessage = document.getElementById('no-categories-message');

            // If no gender selected, hide all categories and show message
            if (!genderId) {
                categoriesContainer.style.display = 'none';
                noGenderMessage.style.display = 'block';
                noCategoriesMessage.style.display = 'none';

                // Uncheck all categories and hide subcategories
                categoryItems.forEach(item => {
                    item.style.display = 'none';
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    if (checkbox && checkbox.checked) {
                        checkbox.checked = false;
                        const categoryId = checkbox.value;
                        const subcategoryContainer = document.getElementById('subcategories_' + categoryId);
                        if (subcategoryContainer) {
                            subcategoryContainer.style.display = 'none';
                        }
                    }
                });
                return;
            }

            // Gender selected - hide no-gender message
            noGenderMessage.style.display = 'none';

            let hasVisibleCategories = false;

            categoryItems.forEach(item => {
                const itemGenderId = item.getAttribute('data-gender-id');

                if (itemGenderId === genderId) {
                    item.style.display = 'block';
                    hasVisibleCategories = true;
                } else {
                    item.style.display = 'none';
                    // Uncheck hidden category
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    if (checkbox && checkbox.checked) {
                        checkbox.checked = false;
                        // Hide its subcategories if any
                        const categoryId = checkbox.value;
                        const subcategoryContainer = document.getElementById('subcategories_' + categoryId);
                        if (subcategoryContainer) {
                            subcategoryContainer.style.display = 'none';
                        }
                    }
                }
            });

            // If no categories for this gender, show warning message
            if (!hasVisibleCategories) {
                categoriesContainer.style.display = 'none';
                noCategoriesMessage.style.display = 'block';
            } else {
                categoriesContainer.style.display = 'flex';
                noCategoriesMessage.style.display = 'none';
            }
        }

        // Toggle Subcategories Display
        function toggleSubcategories(categoryId) {
            const checkbox = document.getElementById('cat_' + categoryId);
            const subcategoryContainer = document.getElementById('subcategories_' + categoryId);

            if (subcategoryContainer) {
                if (checkbox.checked) {
                    subcategoryContainer.style.display = 'block';
                } else {
                    subcategoryContainer.style.display = 'none';
                    // Uncheck all subcategories
                    const subcategoryCheckboxes = subcategoryContainer.querySelectorAll('input[type="checkbox"]');
                    subcategoryCheckboxes.forEach(sub => {
                        sub.checked = false;
                    });
                }
            }
        }

        // Validate Category Selection
        function validateCategorySelection() {
            const categoryCheckboxes = document.querySelectorAll('input[name="categories[]"]:checked');

            if (categoryCheckboxes.length === 0) {
                alert('Please select at least one category!');
                // Scroll to categories section
                document.getElementById('categories-section').scrollIntoView({ behavior: 'smooth', block: 'center' });
                return false;
            }

            return true;
        }

        // Create New Tag
        function createNewTag() {
            const tagName = document.getElementById('new_tag_name').value.trim();
            const errorDiv = document.getElementById('tag-error-message');
            const successDiv = document.getElementById('tag-success-message');

            // Reset messages
            errorDiv.style.display = 'none';
            successDiv.style.display = 'none';

            if (!tagName) {
                errorDiv.textContent = 'Please enter a tag name';
                errorDiv.style.display = 'block';
                return;
            }

            // Send AJAX request
            fetch('/admin/tags/quick-create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: tagName
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add tag to the list
                    addTagToList(data.tag);

                    // Show success message
                    successDiv.textContent = 'Tag created successfully!';
                    successDiv.style.display = 'block';

                    // Clear input
                    document.getElementById('new_tag_name').value = '';

                    // Close modal after 1 second
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addTagModal'));
                        modal.hide();
                        successDiv.style.display = 'none';
                    }, 1000);
                } else {
                    errorDiv.textContent = data.message || 'Failed to create tag';
                    errorDiv.style.display = 'block';
                }
            })
            .catch(error => {
                errorDiv.textContent = 'An error occurred. Please try again.';
                errorDiv.style.display = 'block';
            });
        }

        // Add Tag to List
        function addTagToList(tag) {
            const tagsContainer = document.getElementById('tags-container');
            const noTagsMessage = document.getElementById('no-tags-message');

            // Remove "no tags" message if exists
            if (noTagsMessage) {
                noTagsMessage.remove();
            }

            // Create new tag HTML
            const tagHtml = `
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <input type="checkbox" class="btn-check" name="tags[]" value="${tag.id}" id="tag_${tag.id}" checked>
                    <label class="p-2 btn btn-outline-primary w-100" for="tag_${tag.id}">
                        <div class="text-center">
                            <i class="ti ti-tag fs-5"></i>
                            <div class="mt-1 fw-medium fs-xs">${tag.name}</div>
                        </div>
                    </label>
                </div>
            `;

            // Add to container
            tagsContainer.insertAdjacentHTML('beforeend', tagHtml);
        }
    </script>

    <style>
        /* Product Type Card Hover Effects */
        .product-type-card {
            transition: all 0.3s ease;
        }

        .product-type-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .btn-check:checked + .product-type-card {
            border-width: 3px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* Category Card Hover Effects */
        .category-card {
            transition: all 0.3s ease;
            border-width: 2px !important;
        }

        .category-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .btn-check:checked + .category-card {
            border-width: 2px !important;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }

        /* Value Select Cards */
        .value-select-card .btn {
            transition: all 0.2s ease;
        }

        .value-select-card .btn:hover:not(:disabled) {
            transform: scale(1.02);
        }

        .value-checkbox:checked + .btn {
            font-weight: 600;
        }

        .value-checkbox:disabled + .btn {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Accordion customization */
        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
        }

        .accordion-button::after {
            margin-left: auto;
        }

        .accordion-button .form-check {
            margin-bottom: 0;
        }
    </style>

    <!-- Barcode Scanner Modal -->
    <div class="modal fade" id="createBarcodeScanModal" tabindex="-1" aria-labelledby="createBarcodeScanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title" id="createBarcodeScanModalLabel">
                        <i class="ti ti-qrcode me-2"></i>
                        Scan Product Barcode
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Barcode Input -->
                    <div class="mb-3">
                        <label for="barcodeInputModal" class="form-label fw-semibold">
                            <i class="ti ti-scan me-1"></i>
                            Barcode
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light">
                                <i class="ti ti-barcode"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="barcodeInputModal"
                                placeholder="Scan or enter barcode..."
                                autocomplete="off"
                            >
                        </div>
                        <small class="form-text text-muted">
                            <i class="ti ti-info-circle me-1"></i>
                            Use a barcode scanner or manually enter the barcode number
                        </small>
                    </div>

                    <!-- Scanner Icon Animation -->
                    <div class="py-4 text-center">
                        <div class="scanner-animation">
                            <i class="ti ti-qrcode text-warning" style="font-size: 5rem; opacity: 0.3;"></i>
                            <div class="scanner-line"></div>
                        </div>
                        <p class="mt-3 text-muted">
                            Ready to scan barcode
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>
                        Cancel
                    </button>
                    <button type="button" class="btn btn-warning" id="applyBarcodeBtn" onclick="applyScannedBarcode()">
                        <i class="ti ti-check me-1"></i>
                        Apply Barcode
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .scanner-animation {
            position: relative;
            display: inline-block;
        }

        .scanner-line {
            position: absolute;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #ffc107, transparent);
            top: 0;
            left: 0;
            animation: scan 2s ease-in-out infinite;
            box-shadow: 0 0 10px #ffc107;
        }

        @keyframes scan {
            0%, 100% {
                top: 0;
                opacity: 0;
            }
            50% {
                top: 100%;
                opacity: 1;
            }
        }

        #barcodeInputModal:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        }
    </style>

    <script>
        function openCreateBarcodeScan() {
            document.getElementById('barcodeInputModal').value = '';
            const modal = new bootstrap.Modal(document.getElementById('createBarcodeScanModal'));
            modal.show();
            // Focus on input for scanner
            setTimeout(() => {
                document.getElementById('barcodeInputModal').focus();
            }, 500);
        }

        function applyScannedBarcode() {
            const barcode = document.getElementById('barcodeInputModal').value.trim();

            if (barcode) {
                // Apply to main form
                document.getElementById('barcode').value = barcode;

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('createBarcodeScanModal'));
                modal.hide();

                // Show success feedback
                const barcodeInput = document.getElementById('barcode');
                barcodeInput.classList.add('is-valid');
                setTimeout(() => {
                    barcodeInput.classList.remove('is-valid');
                }, 2000);
            }
        }

        // Handle Enter key in barcode modal input
        document.addEventListener('DOMContentLoaded', function() {
            const barcodeModalInput = document.getElementById('barcodeInputModal');
            if (barcodeModalInput) {
                barcodeModalInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        applyScannedBarcode();
                    }
                });
            }
        });
    </script>
</body>
</html>

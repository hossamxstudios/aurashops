<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Edit Product</title>
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
                        <div class="text-center col-xxl-10">
                            <a href="{{ route('admin.products.index') }}" class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm">
                                <i data-lucide="arrow-left" class="fs-sm me-1"></i> Back to Products
                            </a>
                            <h3 class="fw-bold">Edit Product: {{ $product->name }}</h3>
                            <div class="mt-2">
                                <span class="badge {{ $product->type === 'simple' ? 'bg-info' : 'bg-warning' }}">{{ ucfirst($product->type) }} Product</span>
                                @if($product->type === 'variant' && $product->variants->count() > 0)
                                    <a href="{{ route('admin.products.set-variant-prices', $product->id) }}" class="btn btn-sm btn-primary">
                                        <i class="ti ti-currency-dollar me-1"></i>Set Variant Prices
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @include('admin.main.messages')

                    <div class="row justify-content-center">
                        <div class="col-xxl-10">
                            <!-- Nav Tabs -->
                            <ul class="nav nav-tabs mb-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                        <i class="ti ti-info-circle me-1"></i>Basic Info
                                    </button>
                                </li>
                                @if($product->type === 'variant')
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#variants" type="button" role="tab">
                                        <i class="ti ti-versions me-1"></i>Variants ({{ $product->variants->count() }})
                                    </button>
                                </li>
                                @endif
                                @if($product->type === 'bundle')
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bundle" type="button" role="tab">
                                        <i class="ti ti-box-multiple me-1"></i>Bundle Items ({{ $product->bundleItems->count() }})
                                    </button>
                                </li>
                                @endif
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab">
                                        <i class="ti ti-photo me-1"></i>Images
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- Basic Info Tab -->
                                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="type" value="{{ $product->type }}">

                                        @include('admin.pages.products.parts.basic-form')

                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <a href="{{ route('admin.products.index') }}" class="btn btn-light">Cancel</a>
                                                    <button type="submit" class="btn btn-primary" onclick="return validateCategorySelection()">
                                                        <i class="ti ti-check me-1"></i>Update Product
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Variants Tab -->
                                @if($product->type === 'variant')
                                <div class="tab-pane fade" id="variants" role="tabpanel">
                                    @include('admin.pages.products.parts.variants-manager')
                                </div>
                                @endif

                                <!-- Bundle Items Tab -->
                                @if($product->type === 'bundle')
                                <div class="tab-pane fade" id="bundle" role="tabpanel">
                                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="type" value="{{ $product->type }}">
                                        <input type="hidden" name="name" value="{{ $product->name }}">
                                        <input type="hidden" name="sku" value="{{ $product->sku }}">
                                        <input type="hidden" name="barcode" value="{{ $product->barcode }}">
                                        <input type="hidden" name="details" value="{{ $product->details }}">
                                        <input type="hidden" name="price" value="{{ $product->price }}">
                                        <input type="hidden" name="sale_price" value="{{ $product->sale_price }}">
                                        <input type="hidden" name="brand_id" value="{{ $product->brand_id }}">
                                        <input type="hidden" name="gender_id" value="{{ $product->gender_id }}">
                                        <input type="hidden" name="is_active" value="{{ $product->is_active ? 1 : 0 }}">
                                        <input type="hidden" name="is_featured" value="{{ $product->is_featured ? 1 : 0 }}">

                                        {{-- Preserve categories --}}
                                        @foreach($product->categories as $category)
                                            <input type="hidden" name="categories[]" value="{{ $category->id }}">
                                        @endforeach

                                        {{-- Preserve tags --}}
                                        @foreach($product->tags as $tag)
                                            <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                                        @endforeach

                                        @include('admin.pages.products.parts.bundle-manager')

                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="ti ti-check me-1"></i>Update Bundle Items
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @endif

                                <!-- Images Tab -->
                                <div class="tab-pane fade" id="images" role="tabpanel">
                                    @include('admin.pages.products.parts.images-manager')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')

    <!-- Barcode Scanner Modal -->
    <div class="modal fade" id="editBarcodeScanModal" tabindex="-1" aria-labelledby="editBarcodeScanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title" id="editBarcodeScanModalLabel">
                        <i class="ti ti-qrcode me-2"></i>
                        Scan Product Barcode
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Barcode Input -->
                    <div class="mb-3">
                        <label for="barcodeInputEditModal" class="form-label fw-semibold">
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
                                id="barcodeInputEditModal"
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
                    <div class="text-center py-4">
                        <div class="scanner-animation">
                            <i class="ti ti-qrcode text-warning" style="font-size: 5rem; opacity: 0.3;"></i>
                            <div class="scanner-line"></div>
                        </div>
                        <p class="text-muted mt-3">
                            Ready to scan barcode
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>
                        Cancel
                    </button>
                    <button type="button" class="btn btn-warning" onclick="applyEditScannedBarcode()">
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

        #barcodeInputEditModal:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        }
    </style>

    <script>
        function openEditBarcodeScan() {
            document.getElementById('barcodeInputEditModal').value = '';
            const modal = new bootstrap.Modal(document.getElementById('editBarcodeScanModal'));
            modal.show();
            // Focus on input for scanner
            setTimeout(() => {
                document.getElementById('barcodeInputEditModal').focus();
            }, 500);
        }

        function applyEditScannedBarcode() {
            const barcode = document.getElementById('barcodeInputEditModal').value.trim();

            if (barcode) {
                // Apply to main form
                document.getElementById('barcode').value = barcode;

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('editBarcodeScanModal'));
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
            const barcodeEditModalInput = document.getElementById('barcodeInputEditModal');
            if (barcodeEditModalInput) {
                barcodeEditModalInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        applyEditScannedBarcode();
                    }
                });
            }
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
                    // Uncheck all subcategory checkboxes
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
</body>
</html>

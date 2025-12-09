<!-- Include Product Selector Modal -->
@include('admin.pages.products.parts.product-selector-modal')

<!-- Bundle Items Manager -->
<div class="mb-3 border-0 shadow-sm card">
    <div class="card-body">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-semibold"><i class="ti ti-box-multiple me-2 text-success"></i>Bundle Items</h5>
                <p class="mb-0 text-muted fs-sm">Add products to this bundle</p>
            </div>
            <button type="button" class="btn btn-sm btn-primary" onclick="addBundleItemSlot()">
                <i class="ti ti-plus me-1"></i>Add Item
            </button>
        </div>

        <div id="bundle-items-container">
            @if(isset($product) && $product->bundleItems->count() > 0)
                @foreach($product->bundleItems as $index => $item)
                    <div class="p-3 mb-3 rounded border bundle-item" data-index="{{ $index }}" data-has-product="true">
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold">Item #<span class="item-number">{{ $index + 1 }}</span></h6>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeBundleItem(this)">
                                <i class="ti ti-trash"></i> Remove
                            </button>
                        </div>

                        <!-- Selected Product Card -->
                        <div class="p-3 mb-3 rounded border bg-light product-card">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    @if($item->child && $item->child->getMedia('product_thumbnail')->first())
                                        <img src="{{ $item->child->getMedia('product_thumbnail')->first()->getUrl() }}"
                                             alt="{{ $item->child->name }}"
                                             class="rounded"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="rounded bg-primary-subtle d-flex align-items-center justify-content-center"
                                             style="width: 60px; height: 60px;">
                                            <i class="ti ti-box text-primary fs-3"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <h6 class="mb-1 fw-semibold">{{ $item->child->name }}</h6>
                                    <p class="mb-1 text-muted small">
                                        <i class="ti ti-barcode me-1"></i>{{ $item->child->sku }}
                                    </p>
                                    <div class="gap-2 d-flex align-items-center">
                                        <span class="badge {{ $item->type === 'simple' ? 'bg-info' : 'bg-warning' }}">
                                            {{ ucfirst($item->type) }}
                                        </span>
                                        <span class="fw-bold text-primary">${{ number_format($item->child->price, 2) }}</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <label class="mb-1 form-label fw-medium small">Quantity</label>
                                    <input type="number" class="form-control form-control-sm" style="width: 80px;"
                                           name="bundle_items[{{ $index }}][qty]" value="{{ $item->qty }}" min="1" required>
                                </div>
                            </div>
                            <input type="hidden" name="bundle_items[{{ $index }}][product_id]" value="{{ $item->child_id }}">
                            <input type="hidden" name="bundle_items[{{ $index }}][type]" value="{{ $item->type }}">
                        </div>

                        @if($item->type === 'variant' && $item->child)
                            <div class="variant-options-container">
                                <label class="mb-2 form-label fw-medium">Select Variant Options</label>
                                <div class="p-3 rounded border bg-light">
                                    @if($item->child->variants->count() > 0)
                                        <div class="row g-2">
                                            @foreach($item->child->variants as $variant)
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="bundle_items[{{ $index }}][variants][]"
                                                               value="{{ $variant->id }}"
                                                               id="variant_{{ $index }}_{{ $variant->id }}"
                                                               {{ $item->options->contains('variant_id', $variant->id) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="variant_{{ $index }}_{{ $variant->id }}">
                                                            {{ $variant->name }} - ${{ number_format($variant->getDisplayPrice(), 2) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <small class="text-muted">Customers can choose from these variants</small>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

        <div id="no-items-message" class="py-4 text-center {{ (isset($product) && $product->bundleItems->count() > 0) ? 'd-none' : '' }}">
            <i class="ti ti-box-multiple text-muted" style="font-size: 2rem; opacity: 0.3;"></i>
            <p class="mt-2 text-muted">No items added yet. Click "Add Item" to start building your bundle.</p>
        </div>
    </div>
</div>

<script>
let bundleItemIndex = {{ isset($product) && $product->bundleItems->count() > 0 ? $product->bundleItems->count() : 0 }};

function addBundleItemSlot() {
    const container = document.getElementById('bundle-items-container');
    const noItemsMsg = document.getElementById('no-items-message');

    const itemHtml = `
        <div class="p-3 mb-3 rounded border bundle-item" data-index="${bundleItemIndex}" data-has-product="false">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold">Item #<span class="item-number">${bundleItemIndex + 1}</span></h6>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeBundleItem(this)">
                    <i class="ti ti-trash"></i> Remove
                </button>
            </div>

            <div class="py-4 text-center select-product-placeholder">
                <i class="mb-3 ti ti-package text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                <p class="mb-3 text-muted">No product selected</p>
                <button type="button" class="btn btn-primary" onclick="openProductSelector(${bundleItemIndex})">
                    <i class="ti ti-plus me-1"></i>Select Product
                </button>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('afterbegin', itemHtml);
    bundleItemIndex++;
    noItemsMsg.classList.add('d-none');
    updateItemNumbers();
}

function addSelectedProductToBundleItem(index, productData) {
    const bundleItem = document.querySelector(`.bundle-item[data-index="${index}"]`);
    if (!bundleItem) return;

    // Mark as having product
    bundleItem.setAttribute('data-has-product', 'true');

    // Remove placeholder
    const placeholder = bundleItem.querySelector('.select-product-placeholder');
    if (placeholder) placeholder.remove();

    // Remove existing product card if any
    const existingCard = bundleItem.querySelector('.product-card');
    if (existingCard) existingCard.remove();

    // Remove existing variant options
    const existingVariants = bundleItem.querySelector('.variant-options-container');
    if (existingVariants) existingVariants.remove();

    // Create product card
    const thumbnail = productData.thumbnail || '/images/placeholder.png';
    const displayPrice = productData.sale_price > 0 ? productData.sale_price : productData.price;
    const typeColor = productData.type === 'simple' ? 'bg-info' : 'bg-warning';

    const productCardHtml = `
        <div class="p-3 mb-3 rounded border bg-light product-card">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="${thumbnail}" alt="${escapeHtml(productData.name)}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                </div>
                <div class="col">
                    <h6 class="mb-1 fw-semibold">${escapeHtml(productData.name)}</h6>
                    <p class="mb-1 text-muted small">
                        <i class="ti ti-barcode me-1"></i>SKU: ${productData.id}
                    </p>
                    <div class="gap-2 d-flex align-items-center">
                        <span class="badge ${typeColor}">
                            ${productData.type.charAt(0).toUpperCase() + productData.type.slice(1)}
                        </span>
                        <span class="fw-bold text-primary">$${parseFloat(displayPrice).toFixed(2)}</span>
                    </div>
                </div>
                <div class="col-auto">
                    <label class="mb-1 form-label fw-medium small">Quantity</label>
                    <input type="number" class="form-control form-control-sm" style="width: 80px;"
                           name="bundle_items[${index}][qty]" value="1" min="1" required>
                </div>
            </div>
            <input type="hidden" name="bundle_items[${index}][product_id]" value="${productData.id}">
            <input type="hidden" name="bundle_items[${index}][type]" value="${productData.type}">
        </div>
    `;

    // Insert after header
    const header = bundleItem.querySelector('.d-flex.justify-content-between');
    header.insertAdjacentHTML('afterend', productCardHtml);

    // If variant product, load and show variant options
    if (productData.type === 'variant') {
        loadVariantOptions(index, productData.id);
    }
}

function loadVariantOptions(bundleItemIndex, productId) {
    fetch(`/admin/products/${productId}`)
        .then(response => response.text())
        .then(html => {
            // Parse the response to extract variants data
            // For now, we'll fetch via AJAX API
            fetch(`/admin/products/search?product_id=${productId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.variants && data.variants.length > 0) {
                    renderVariantOptions(bundleItemIndex, data.variants);
                }
            });
        })
        .catch(error => console.error('Error loading variants:', error));
}

function renderVariantOptions(index, variants) {
    const bundleItem = document.querySelector(`.bundle-item[data-index="${index}"]`);
    if (!bundleItem) return;

    let variantOptionsHtml = `
        <div class="variant-options-container">
            <label class="mb-2 form-label fw-medium">Select Variant Options</label>
            <div class="p-3 rounded border bg-light">
                <div class="row g-2">
    `;

    variants.forEach(variant => {
        const displayPrice = variant.sale_price > 0 ? variant.sale_price : variant.price;
        variantOptionsHtml += `
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           name="bundle_items[${index}][variants][]"
                           value="${variant.id}"
                           id="variant_${index}_${variant.id}">
                    <label class="form-check-label" for="variant_${index}_${variant.id}">
                        ${escapeHtml(variant.name)} - $${parseFloat(displayPrice).toFixed(2)}
                    </label>
                </div>
            </div>
        `;
    });

    variantOptionsHtml += `
                </div>
            </div>
            <small class="text-muted">Customers can choose from these variants</small>
        </div>
    `;

    const productCard = bundleItem.querySelector('.product-card');
    if (productCard) {
        productCard.insertAdjacentHTML('afterend', variantOptionsHtml);
    }
}

function removeBundleItem(button) {
    const item = button.closest('.bundle-item');
    item.remove();

    const container = document.getElementById('bundle-items-container');
    const noItemsMsg = document.getElementById('no-items-message');

    if (container.children.length === 0) {
        noItemsMsg.classList.remove('d-none');
    }

    updateItemNumbers();
}

function updateItemNumbers() {
    const items = document.querySelectorAll('.bundle-item');
    items.forEach((item, idx) => {
        const numberSpan = item.querySelector('.item-number');
        if (numberSpan) {
            numberSpan.textContent = idx + 1;
        }
    });
}
</script>

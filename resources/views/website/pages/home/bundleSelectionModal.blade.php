<!-- Bundle Variant Selection Modal -->
<div class="modal fullRight fade modal-quick-view" id="bundleSelectionModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="max-width: min(546px, 90vw) !important;">
            <div class="wrap">
                <div class="header">
                    <h5 class="title">Complete Your Bundle</h5>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="tf-product-info-list" style="margin-left: 0px!important;">
                    <div class="tf-product-info-heading">
                        <p class="text-caption-1 text-secondary mb_20">Please select options for each item in your
                            bundle</p>
                    </div>
                    @foreach ($product->bundleItems as $bundleItem)
                        @php
                            $childProduct = $bundleItem->child;
                        @endphp
                        @if ($childProduct && $childProduct->isVariant())
                            @for ($qtyIndex = 0; $qtyIndex < $bundleItem->qty; $qtyIndex++)
                                <div class="tf-product-info-item mb_30" data-bundle-item-id="{{ $bundleItem->id }}" data-qty-index="{{ $qtyIndex }}">
                                    <div class="tf-product-info-heading mb_15">
                                        <div class="d-flex align-items-start gap-15">
                                            <div class="tf-product-info-image" style="flex-shrink: 0;">
                                                <img src="{{ $childProduct->getFirstMediaUrl('product_thumbnail') }}"
                                                    alt="{{ $childProduct->name }}"
                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-5 mb_4">{{ $childProduct->name }}</h6>
                                                @if ($bundleItem->qty > 1)
                                                    <div class="text-caption-1 text-secondary">Item {{ $qtyIndex + 1 }}
                                                        of {{ $bundleItem->qty }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        // Group attributes correctly
                                        $attributeGroups = [];
                                        foreach ($childProduct->variants as $variant) {
                                            if (!$variant->is_active) {
                                                continue;
                                            }
                                            foreach ($variant->values as $value) {
                                                $attrId = $value->attribute_id;
                                                $attrName = $value->attribute->name;
                                                if (!isset($attributeGroups[$attrId])) {
                                                    $attributeGroups[$attrId] = [
                                                        'id' => $attrId,
                                                        'name' => $attrName,
                                                        'values' => [],
                                                    ];
                                                }
                                                if (!isset($attributeGroups[$attrId]['values'][$value->id])) {
                                                    $attributeGroups[$attrId]['values'][$value->id] = $value->name;
                                                }
                                            }
                                        }
                                    @endphp
                                    @foreach ($attributeGroups as $attribute)
                                        <div class="variant-picker-item">
                                            <div class="variant-picker-label mb_12">
                                                {{ $attribute['name'] }}:<span class="text-title variant-picker-label-value selected-value-{{ $bundleItem->id }}-{{ $qtyIndex }}-{{ $attribute['id'] }}"></span>
                                            </div>
                                            <div class="variant-picker-values gap12">
                                                @foreach ($attribute['values'] as $valueId => $valueName)
                                                    <input type="radio"
                                                        name="bundle_{{ $bundleItem->id }}_{{ $qtyIndex }}_attr_{{ $attribute['id'] }}"
                                                        id="bundle_{{ $bundleItem->id }}_{{ $qtyIndex }}_{{ $valueId }}"
                                                        class="bundle-variant-radio" value="{{ $valueId }}"
                                                        data-bundle-item-id="{{ $bundleItem->id }}"
                                                        data-qty-index="{{ $qtyIndex }}"
                                                        data-attribute-id="{{ $attribute['id'] }}"
                                                        data-value-name="{{ $valueName }}">
                                                    <label class="style-text-1 style-rounded radius-60 color-btn"
                                                        for="bundle_{{ $bundleItem->id }}_{{ $qtyIndex }}_{{ $valueId }}"
                                                        data-value-name="{{ $valueName }}">
                                                        <span class="text-title">{{ $valueName }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endfor
                        @endif
                    @endforeach

                    <div class="tf-product-info-variant-picker d-none mb_15" id="bundleValidationAlert{{ $product->id }}">
                        <div class="text-caption-1 text-secondary">
                            <i class="icon icon-alert-triangle"></i>
                            <span id="bundleValidationMessage{{ $product->id }}">Please select all options</span>
                        </div>
                    </div>

                    <div class="tf-product-info-by-btn">
                        <a href="javascript:void(0);" class="tf-btn btn-fill radius-4 justify-content-center align-items-center w-100 animate-hover-btn" id="confirmBundleSelection{{ $product->id }}" onclick="confirmBundleSelection{{ $product->id }}()">
                            <span>Add Bundle to Cart</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Variant picker label value for bundle modal */
    #bundleSelectionModal{{ $product->id }} .variant-picker-label-value {
        margin-left: 5px;
        font-weight: 500;
    }

    /* Rounded color button style for bundle modal */
    #bundleSelectionModal{{ $product->id }} .color-btn {
        min-width: 50px;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }

    #bundleSelectionModal{{ $product->id }} .color-btn:hover {
        border-color: #000;
    }

    /* Selected state - black background for bundle modal */
    #bundleSelectionModal{{ $product->id }} input[type="radio"]:checked + .color-btn {
        border-color: #000;
        background-color: #000;
        color: #fff;
    }

    #bundleSelectionModal{{ $product->id }} input[type="radio"]:checked + .color-btn .text-title {
        color: #fff;
    }
</style>

<script>
    // Feature 1: Store bundle variants data for Quick View to detect and open this modal
    window['bundleVariants{{ $product->id }}'] = {!! json_encode(
        $product->bundleItems->map(function ($bundleItem) {
                $child = $bundleItem->child;
                if (!$child || !$child->isVariant()) {
                    return null;
                }
                return [
                    'bundle_item_id' => $bundleItem->id,
                    'product_id' => $child->id,
                    'product_name' => $child->name,
                    'qty' => $bundleItem->qty,
                    'variants' => $child->variants->filter(fn($v) => $v->is_active)->map(function($variant) {
                        return [
                            'id' => $variant->id,
                            'name' => $variant->name,
                            'price' => $variant->price,
                            'sale_price' => $variant->sale_price,
                            'value_ids' => $variant->values->pluck('id')->toArray()
                        ];
                    })->values()
                ];
            })->filter()->values(),
    ) !!};

    // Feature 2: Handle variant selection changes - show selected value
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('#bundleSelectionModal{{ $product->id }} .bundle-variant-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const bundleItemId = this.getAttribute('data-bundle-item-id');
                const qtyIndex = this.getAttribute('data-qty-index');
                const attributeId = this.getAttribute('data-attribute-id');
                const valueName = this.getAttribute('data-value-name');

                const selectedSpan = document.querySelector(`.selected-value-${bundleItemId}-${qtyIndex}-${attributeId}`);
                if (selectedSpan) {
                    selectedSpan.textContent = valueName;
                }

                // Hide validation alert if showing
                const alertEl = document.getElementById('bundleValidationAlert{{ $product->id }}');
                if (alertEl) {
                    alertEl.classList.add('d-none');
                }
            });
        });
    });

    // Feature 3: Validate selections and prepare bundle data for cart
    window['confirmBundleSelection{{ $product->id }}'] = function() {
        console.log('🎯 Confirm Bundle Selection clicked');

        const bundleData = window['bundleVariants{{ $product->id }}'];
        const selections = [];
        const alertEl = document.getElementById('bundleValidationAlert{{ $product->id }}');
        const messageEl = document.getElementById('bundleValidationMessage{{ $product->id }}');

        alertEl.classList.add('d-none');

        // Validate and collect selections for each bundle item
        for (const bundleItem of bundleData) {
            if (!bundleItem) continue;

            for (let qtyIndex = 0; qtyIndex < bundleItem.qty; qtyIndex++) {
                const selectionContainer = document.querySelector(
                    `#bundleSelectionModal{{ $product->id }} [data-bundle-item-id="${bundleItem.bundle_item_id}"][data-qty-index="${qtyIndex}"]`
                );

                if (!selectionContainer) {
                    console.warn('Container not found for bundle item', bundleItem.bundle_item_id, 'qty index', qtyIndex);
                    continue;
                }

                // Get all selected radio buttons for this item
                const selectedRadios = selectionContainer.querySelectorAll('.bundle-variant-radio:checked');
                const selectedValueIds = Array.from(selectedRadios).map(r => parseInt(r.value));

                console.log('Selected value IDs for item', bundleItem.product_name, ':', selectedValueIds);

                // Find matching variant based on selected attribute values
                let matchedVariant = null;
                for (const variant of bundleItem.variants) {
                    const variantValueIds = [...variant.value_ids].sort((a, b) => a - b);
                    const selectedSorted = [...selectedValueIds].sort((a, b) => a - b);

                    if (JSON.stringify(variantValueIds) === JSON.stringify(selectedSorted)) {
                        matchedVariant = variant;
                        console.log('✅ Matched variant:', variant.name);
                        break;
                    }
                }

                if (!matchedVariant) {
                    console.error('❌ No matching variant found for', bundleItem.product_name);
                    messageEl.textContent = 'Please select all options for ' + bundleItem.product_name;
                    alertEl.classList.remove('d-none');
                    return;
                }

                selections.push({
                    bundle_item_id: bundleItem.bundle_item_id,
                    variant_id: matchedVariant.id
                });
            }
        }

        console.log('✅ All selections validated:', selections);

        // Show loading state
        const confirmBtn = document.getElementById('confirmBundleSelection{{ $product->id }}');
        const originalBtnText = confirmBtn.innerHTML;
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

        // Call add to cart function (Feature 4)
        addBundleToCart{{ $product->id }}(selections, function() {
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = originalBtnText;

            const modal = bootstrap.Modal.getInstance(document.getElementById('bundleSelectionModal{{ $product->id }}'));
            if (modal) {
                modal.hide();
            }
        });
    };

    // Feature 4: Add bundle to cart via AJAX
    window['addBundleToCart{{ $product->id }}'] = function(selections, callback) {
        console.log('🛒 Adding bundle to cart:', selections);

        const productId = {{ $product->id }};
        const quantityInput = document.getElementById('quantity-' + productId);
        const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('/cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                qty: quantity,
                bundle_items: selections
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Cart response:', data);

            if (data.success) {
                // Show minimal success notification
                if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                    window.ShopFeatures.showNotification('✓ Bundle added to cart', 'success');
                }

                if (window.ShopFeatures && window.ShopFeatures.updateCartCount) {
                    window.ShopFeatures.updateCartCount(data.cart.count);
                }

                // Refresh cart content dynamically
                if (window.refreshCartContent) {
                    window.refreshCartContent();
                }

                // Close quick view modal
                const quickViewModal = document.getElementById('quickView' + productId);
                if (quickViewModal) {
                    const bsModal = bootstrap.Modal.getInstance(quickViewModal);
                    if (bsModal) {
                        bsModal.hide();
                    }
                }
            } else {
                if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                    window.ShopFeatures.showNotification(data.message || 'Failed to add bundle to cart', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Add bundle to cart error:', error);
            if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                window.ShopFeatures.showNotification('An error occurred. Please try again.', 'error');
            }
        })
        .finally(() => {
            if (callback && typeof callback === 'function') {
                callback();
            }
        });
    };
</script>

<div class="modal fullRight fade modal-quick-view" id="quickView{{ $product->id }}">
        <div class="modal-dialog">
            <div class="modal-content" style="max-width: min(1046px, 90vw) !important;">
                <div class="tf-quick-view-image">
                    <div class="wrap-quick-view wrapper-scroll-quickview">
                        <div class="quickView-item item-scroll-quickview" data-scroll-quickview="beige">
                            <img class="lazyload" data-src="{{ $product->getFirstMediaUrl('product_thumbnail') }}"
                                src="{{ $product->getFirstMediaUrl('product_thumbnail') }}" alt="">
                        </div>

                        @foreach ($product->getMedia('product_images') as $media)
                            <div class="quickView-item item-scroll-quickview" data-scroll-quickview="beige">
                                <img class="lazyload" data-src="{{ $media->getUrl() }}" src="{{ $media->getUrl() }}" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="wrap">
                    <div class="header">
                        <h5 class="title">Quick View</h5>
                        <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                    </div>
                    <div class="ml-0 tf-product-info-list" style="margin-left: 0px !important;">
                        <div class="tf-product-info-heading">
                            <div class="tf-product-info-name">
                                <div class="text text-btn-uppercase">{{ $product->categories->first()?->name }} | {{ $product->brand->name }}</div>
                                <h3 class="name">{{ $product->name }}</h3>
                                <div class="sub">
                                    <div class="tf-product-info-rate">
                                        <div class="list-star">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="icon icon-star{{ $i <= floor($product->rating ?? 5) ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                        <div class="text text-caption-1">({{ $product->reviews->count() }} reviews)</div>
                                    </div>
                                    <div class="tf-product-info-sold">
                                        <i class="icon icon-lightning"></i>
                                        <div class="text text-caption-1">{{ $product->orders_count ?? 0 }} sold in last 32 hours</div>
                                    </div>
                                </div>
                            </div>
                            <div class="tf-product-info-desc">
                                <div class="tf-product-info-price">
                                    <h5 class="price-on-sale font-2" id="quickViewPrice-{{ $product->id }}">
                                        EGP {{ number_format($product->getDisplayPrice(), 2) }}
                                    </h5>
                                    @if($product->sale_price > 0)
                                        <div class="compare-at-price font-2" id="quickViewOriginalPrice-{{ $product->id }}">
                                            EGP {{ number_format($product->price, 2) }}
                                        </div>
                                        <div class="badges-on-sale text-btn-uppercase" id="quickViewDiscount-{{ $product->id }}">
                                            -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                        </div>
                                    @endif
                                </div>
                                <p>{{ $product->details ?? 'No description available.' }}</p>
                                <div class="tf-product-info-liveview">
                                    <i class="icon icon-eye"></i>
                                    <p class="text-caption-1"><span class="liveview-count">{{ $product->views_count ?? 0 }}</span> people are viewing this right now</p>
                                </div>
                            </div>
                        </div>
                        <div class="tf-product-info-choose-option" id="quickViewOptions-{{ $product->id }}">
                            @if($product->isVariant() && $product->variants->count())
                                @php
                                    // Group variants by attributes
                                    $attributesMap = [];
                                    foreach ($product->variants->where('is_active', 1) as $variant) {
                                        foreach ($variant->values as $value) {
                                            $attrId = $value->attribute_id;
                                            if (!isset($attributesMap[$attrId])) {
                                                $attributesMap[$attrId] = [
                                                    'name' => $value->attribute->name ?? 'Attribute',
                                                    'values' => []
                                                ];
                                            }
                                            $attributesMap[$attrId]['values'][$value->id] = $value->name;
                                        }
                                    }
                                @endphp

                                @foreach($attributesMap as $attributeId => $attribute)
                                    <div class="variant-picker-item">
                                        <div class="variant-picker-label mb_12">
                                            {{ $attribute['name'] }}:<span class="text-title variant-picker-label-value value-attr-{{ $attributeId }}-{{ $product->id }}"></span>
                                        </div>
                                        <div class="variant-picker-values gap12">
                                            @foreach($attribute['values'] as $valueId => $valueName)
                                                <input type="radio"
                                                       name="attribute_{{ $attributeId }}_{{ $product->id }}"
                                                       id="attr-{{ $attributeId }}-val-{{ $valueId }}-{{ $product->id }}"
                                                       data-attribute-id="{{ $attributeId }}">
                                                <label class="style-text-1 style-rounded radius-60 color-btn"
                                                       for="attr-{{ $attributeId }}-val-{{ $valueId }}-{{ $product->id }}"
                                                       data-value-id="{{ $valueId }}"
                                                       data-value-name="{{ $valueName }}">
                                                    <span class="text-title">{{ $valueName }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @elseif($product->isBundle() && $product->bundleItems->count())
                                <div class="variant-picker-item">
                                    <div class="variant-picker-label mb_12">
                                        Bundle Items:
                                    </div>
                                    <div class="bundle-items-list">
                                        @foreach($product->bundleItems as $bundleItem)
                                            @php $child = $bundleItem->child; @endphp
                                            @if($child)
                                                <div class="gap-12 d-flex align-items-center mb_12 pb_12 border-bottom">
                                                    <div style="width:60px;height:60px;overflow:hidden;border-radius:4px;">
                                                        <img src="{{ $child->image }}" alt="{{ $child->name }}" style="width:100%;height:100%;object-fit:cover;">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="text-title text-line-clamp-1">{{ $child->name }}</div>
                                                        <div class="text-caption-1 text-secondary">Qty: {{ $bundleItem->qty }}</div>
                                                        <div class="text-button fw-6">EGP {{ number_format($child->getDisplayPrice(), 2) }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(!$product->isBundle())
                                <div class="tf-product-info-quantity">
                                    <div class="title mb_12">Quantity:</div>
                                    <div class="wg-quantity" id="quantityWidget-{{ $product->id }}">
                                        <span class="btn-quantity btn-decrease">-</span>
                                        <input class="quantity-product" type="text" name="number" value="1" id="quantity-{{ $product->id }}">
                                        <span class="btn-quantity btn-increase">+</span>
                                    </div>
                                </div>
                            @else
                                {{-- Hidden quantity input for bundle products (always 1) --}}
                                <input type="hidden" id="quantity-{{ $product->id }}" value="1">
                            @endif

                            <div>
                                <div class="tf-product-info-by-btn mb_10">
                                    <a href="javascript:void(0);"
                                       class="btn-style-2 flex-grow-1 text-btn-uppercase fw-6 position-relative"
                                       data-add-to-cart
                                       data-product-id="{{ $product->id }}"
                                       data-product-type="{{ $product->type }}"
                                       id="addToCartBtn-{{ $product->id }}"
                                       data-no-theme-price-update="true"
                                       @if($product->isVariant()) data-requires-selection="true" @endif
                                       onclick="validateAndAddToCart{{ $product->id }}(event)">
                                        <span>Add to cart -&nbsp;</span>
                                        <span class="tf-qty-price-custom" id="totalPrice-{{ $product->id }}" data-original-price="{{ $product->getDisplayPrice() }}">EGP {{ number_format($product->getDisplayPrice(), 2) }}</span>
                                        @if($product->isVariant())
                                            <span class="selection-tooltip" id="selectionTooltip-{{ $product->id }}" style="display:none;">
                                                Please select all options
                                            </span>
                                        @endif
                                    </a>
                                    <a href="javascript:void(0);"
                                       class="box-icon hover-tooltip text-caption-2 wishlist btn-icon-action"
                                       data-wishlist-product="{{ $product->id }}">
                                        <span class="icon icon-heart"></span>
                                        <span class="tooltip text-caption-2">Wishlist</span>
                                    </a>
                                </div>
                                <a href="{{ route('product.show', $product->slug) }}" class="btn-style-3 text-btn-uppercase w-100">View Full Details</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Variant picker label value */
        .variant-picker-label-value {
            margin-left: 5px;
            font-weight: 500;
        }

        /* Rounded color button style */
        .color-btn {
            min-width: 50px;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .color-btn:hover {
            border-color: #000;
        }

        /* Selected state - black background */
        input[type="radio"]:checked + .color-btn {
            border-color: #000;
            background-color: #000;
            color: #fff;
        }

        input[type="radio"]:checked + .color-btn .text-title {
            color: #fff;
        }
    </style>

    @if(!$product->isBundle())
        <style>
            #addToCartBtn-{{ $product->id }} {
                position: relative;
            }

            #addToCartBtn-{{ $product->id }}.disabled {
                cursor: not-allowed;
                opacity: 0.6;
            }

            #addToCartBtn-{{ $product->id }} .selection-tooltip {
                display: none;
                position: absolute;
                bottom: calc(100% + 10px);
                left: 50%;
                transform: translateX(-50%);
                background-color: #333;
                color: white;
                padding: 8px 12px;
                border-radius: 4px;
                font-size: 13px;
                white-space: nowrap;
                margin-bottom: 8px;
                z-index: 1000;
            }

            #addToCartBtn-{{ $product->id }} .selection-tooltip::after {
                content: '';
                position: absolute;
                top: 100%;
                left: 50%;
                transform: translateX(-50%);
                border: 6px solid transparent;
                border-top-color: #333;
            }

            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
        </style>
    @endif

    <script>
        // Validation function for Add to Cart
        window['validateAndAddToCart{{ $product->id }}'] = function(event) {
            event.preventDefault();
            const modalId = {{ $product->id }};
            const productType = '{{ $product->type }}';

            console.log('🛒 Add to Cart clicked for product', modalId, 'Type:', productType);

            // Check if product is variant type
            if (productType === 'variant') {
                const optionsContainer = document.getElementById('quickViewOptions-' + modalId);

                if (optionsContainer) {
                    // Get all variant picker items (attribute groups)
                    const attributeGroups = optionsContainer.querySelectorAll('.variant-picker-item');
                    const totalGroups = attributeGroups.length;

                    // Count selected attributes
                    let selectedCount = 0;
                    const radioNames = new Set();

                    attributeGroups.forEach(group => {
                        const radios = group.querySelectorAll('input[type="radio"]');
                        radios.forEach(radio => {
                            if (radio.checked) {
                                radioNames.add(radio.name);
                            }
                        });
                    });

                    selectedCount = radioNames.size;

                    console.log('  📊 Attributes: selected', selectedCount, '/', totalGroups);

                    // If not all attributes are selected, show warning
                    if (selectedCount < totalGroups) {
                        console.warn('  ⚠️  Not all attributes selected!');

                        // Don't show alert, button is already disabled
                        return false;
                    }

                    // Check if variant-id is set
                    const addToCartBtn = document.getElementById('addToCartBtn-' + modalId);
                    const variantId = addToCartBtn ? addToCartBtn.getAttribute('data-variant-id') : null;

                    if (!variantId) {
                        console.warn('  ⚠️  No variant ID found!');
                        // Don't show alert, button is already disabled
                        return false;
                    }

                    console.log('  ✅ Validation passed! Variant ID:', variantId);
                }
            }

            // Check if product is bundle type with variant items
            if (productType === 'bundle') {
                // Check if bundle has any variant items that need selection
                const bundleData = window['bundleVariants' + modalId];

                if (bundleData && Object.keys(bundleData).length > 0) {
                    console.log('  📦 Bundle product with variant items - opening selection modal');

                    // Open bundle selection modal
                    const bundleModal = new bootstrap.Modal(document.getElementById('bundleSelectionModal' + modalId));
                    bundleModal.show();

                    return false;
                } else {
                    console.log('  📦 Bundle product with no variant items - adding directly to cart');
                    // Bundle has no variant items, proceed with normal add to cart
                }
            }

            // If validation passed or simple product, trigger add to cart via API
            console.log('  ✅ Validation passed! Making API call...');

            // Get the add to cart button and make direct API call
            const addToCartBtn = document.getElementById('addToCartBtn-' + modalId);
            if (!addToCartBtn) return false;

            const quantityInput = document.getElementById('quantity-' + modalId);
            const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const variantId = addToCartBtn.getAttribute('data-variant-id');

            // Disable button and show loading state
            addToCartBtn.style.pointerEvents = 'none';
            addToCartBtn.style.opacity = '0.6';
            const originalHtml = addToCartBtn.innerHTML;
            addToCartBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Adding...';

            // Make API call
            fetch('/cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: modalId,
                    variant_id: variantId,
                    qty: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                        window.ShopFeatures.showNotification('✓ Added to cart', 'success');
                    }
                    if (window.ShopFeatures && window.ShopFeatures.updateCartCount) {
                        window.ShopFeatures.updateCartCount(data.cart.count);
                    }
                    if (typeof window.refreshCartContent === 'function') {
                        window.refreshCartContent();
                    }
                } else {
                    if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                        window.ShopFeatures.showNotification(data.message || 'Failed to add to cart', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Add to cart error:', error);
                if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                    window.ShopFeatures.showNotification('An error occurred. Please try again.', 'error');
                }
            })
            .finally(() => {
                addToCartBtn.style.pointerEvents = '';
                addToCartBtn.style.opacity = '';
                addToCartBtn.innerHTML = originalHtml;
            });

            return false; // Prevent event bubbling to avoid double submission
        };

        @if($product->isVariant())
        // Check variant selection status and update button state
        window['checkVariantSelection{{ $product->id }}'] = function() {
            const modalId = {{ $product->id }};
            const optionsContainer = document.getElementById('quickViewOptions-' + modalId);
            const addToCartBtn = document.getElementById('addToCartBtn-' + modalId);
            const tooltip = document.getElementById('selectionTooltip-' + modalId);

            if (!optionsContainer || !addToCartBtn) return;

            // Get all variant picker items
            const attributeGroups = optionsContainer.querySelectorAll('.variant-picker-item');
            const totalGroups = attributeGroups.length;

            // Count selected attributes
            const radioNames = new Set();
            attributeGroups.forEach(group => {
                const radios = group.querySelectorAll('input[type="radio"]');
                radios.forEach(radio => {
                    if (radio.checked) {
                        radioNames.add(radio.name);
                    }
                });
            });

            const selectedCount = radioNames.size;
            const variantId = addToCartBtn.getAttribute('data-variant-id');

            // Enable/disable button based on selection
            if (selectedCount < totalGroups || !variantId) {
                addToCartBtn.classList.add('disabled');
                // Keep tooltip hidden - will show on hover/click only
            } else {
                addToCartBtn.classList.remove('disabled');
                if (tooltip) tooltip.style.display = 'none';
            }
        };

        // Show tooltip on hover or click for disabled button
        (function() {
            const addToCartBtn = document.getElementById('addToCartBtn-{{ $product->id }}');
            const tooltip = document.getElementById('selectionTooltip-{{ $product->id }}');

            if (addToCartBtn && tooltip) {
                // Show tooltip on hover
                addToCartBtn.addEventListener('mouseenter', function() {
                    if (this.classList.contains('disabled')) {
                        tooltip.style.display = 'block';
                    }
                });

                addToCartBtn.addEventListener('mouseleave', function() {
                    if (this.classList.contains('disabled')) {
                        tooltip.style.display = 'none';
                    }
                });

                // Show tooltip on click attempt
                addToCartBtn.addEventListener('click', function(e) {
                    if (this.classList.contains('disabled')) {
                        e.preventDefault();
                        e.stopPropagation();

                        // Flash the tooltip
                        tooltip.style.display = 'block';

                        // Add shake animation
                        this.style.animation = 'shake 0.3s';
                        setTimeout(() => {
                            this.style.animation = '';
                        }, 300);

                        // Hide tooltip after 2 seconds
                        setTimeout(() => {
                            if (this.classList.contains('disabled')) {
                                tooltip.style.display = 'none';
                            }
                        }, 2000);

                        return false;
                    }
                });
            }
        })();

        // Initial check
        setTimeout(function() {
            window['checkVariantSelection{{ $product->id }}']();
        }, 100);
        @endif
    </script>

    @if(!$product->isBundle())
        <script>
            // Price Calculator for product {{ $product->id }}
            (function() {
                const modalId = {{ $product->id }};
                console.log('🚀 [Product ' + modalId + '] Initializing price calculator');

                const quantityInput = document.getElementById('quantity-' + modalId);
                const totalPriceEl = document.getElementById('totalPrice-' + modalId);

                if (!quantityInput || !totalPriceEl) {
                    console.error('❌ [Product ' + modalId + '] Missing elements:', {
                        quantityInput: quantityInput,
                        totalPriceEl: totalPriceEl
                    });
                    return;
                }

                // Store base price and last quantity
                let basePrice = parseFloat({{ $product->getDisplayPrice() }});
                let lastQty = 1;

                console.log('  📊 Initial basePrice:', basePrice);
                console.log('  📦 Initial quantity:', lastQty);
                console.log('  🎯 Product type:', '{{ $product->type }}');

                function updateTotalPrice() {
                    // Get current value from input
                    const inputValue = quantityInput.value;
                    const currentQty = parseInt(inputValue);

                    // Skip if value is being modified (empty or invalid during typing)
                    if (inputValue === '' || inputValue === null) {
                        return;
                    }

                    // Only update if quantity actually changed
                    if (currentQty === lastQty) {
                        return; // Skip silently
                    }

                    // Log only when quantity changes
                    console.log('🔢 [Product ' + modalId + '] Quantity changed:', lastQty, '→', currentQty);

                    lastQty = currentQty;

                    let qty = currentQty;

                    // Validate quantity
                    if (isNaN(qty) || qty < 1) {
                        console.warn('  ⚠️  Invalid quantity, using last valid value');
                        qty = lastQty > 0 ? lastQty : 1;
                        lastQty = qty;
                    }

                    // Validate base price
                    if (isNaN(basePrice) || basePrice <= 0 || !isFinite(basePrice)) {
                        console.error('  ❌ Invalid base price:', basePrice, '- skipping update');
                        return;
                    }

                    const total = basePrice * qty;

                    // Only update DOM if we have a valid total
                    if (!isNaN(total) && total > 0 && isFinite(total)) {
                        // Store current text to avoid unnecessary DOM updates
                        const newText = 'EGP ' + total.toFixed(2);
                        if (totalPriceEl.textContent !== newText) {
                            totalPriceEl.textContent = newText;
                            console.log('  ✅ Total price updated:', newText, '(' + basePrice + ' × ' + qty + ')');
                        }
                    } else {
                        console.error('  ❌ Cannot update - invalid calculation:', {
                            total: total,
                            basePrice: basePrice,
                            qty: qty,
                            isNaN: isNaN(total),
                            isFinite: isFinite(total)
                        });
                    }
                }

                // Listen to input events
                quantityInput.addEventListener('input', function() {
                    console.log('📥 Input event fired');
                    updateTotalPrice();
                });
                quantityInput.addEventListener('change', function() {
                    console.log('📥 Change event fired');
                    updateTotalPrice();
                });
                quantityInput.addEventListener('keyup', function() {
                    console.log('📥 Keyup event fired');
                    updateTotalPrice();
                });

                // Watch for value property changes (most reliable for programmatic changes)
                let lastValue = quantityInput.value;
                const checkValueChange = function() {
                    const currentValue = quantityInput.value;
                    if (currentValue !== lastValue) {
                        console.log('🔄 Value changed (polling detected):', lastValue, '→', currentValue);
                        lastValue = currentValue;
                        updateTotalPrice();
                    }
                };

                // Fast polling to catch theme changes (100ms)
                const pollInterval = setInterval(checkValueChange, 100);

                // Also watch for DOM mutations as backup
                const observer = new MutationObserver(function(mutations) {
                    console.log('👀 Mutation detected on quantity input');
                    checkValueChange();
                });

                observer.observe(quantityInput, {
                    attributes: true,
                    attributeFilter: ['value'],
                    characterData: true
                });

                observer.observe(quantityInput.parentNode, {
                    childList: true,
                    subtree: true
                });

                // Expose function to update base price from variant selection
                window['updateBasePrice' + modalId] = function(newPrice) {
                    console.log('🔄 [Product ' + modalId + '] updateBasePrice called');
                    console.log('  📥 newPrice:', newPrice);
                    console.log('  📥 typeof newPrice:', typeof newPrice);

                    const parsedPrice = parseFloat(newPrice);
                    console.log('  💱 parsedPrice:', parsedPrice);

                    if (!isNaN(parsedPrice) && parsedPrice > 0) {
                        console.log('  ✅ Valid price, updating basePrice from', basePrice, 'to', parsedPrice);
                        basePrice = parsedPrice;
                        lastQty = -1; // Force update
                        updateTotalPrice();
                    } else {
                        console.error('  ❌ Invalid price rejected:', newPrice);
                    }
                };

                // Prevent theme's price update interference
                // Override jQuery text() for this specific element
                if (window.jQuery && totalPriceEl) {
                    const $totalPrice = jQuery(totalPriceEl);
                    const originalText = $totalPrice.text;

                    $totalPrice.text = function(value) {
                        // If theme tries to set text
                        if (arguments.length > 0) {
                            const strValue = String(value);
                            // Block any attempt to set NaN
                            if (strValue.includes('NaN') || strValue.includes('nan') || isNaN(parseFloat(strValue))) {
                                console.warn('🛑 Blocked theme attempt to set invalid price:', value);
                                return this; // Return jQuery object for chaining
                            }
                        }
                        // Call original method
                        return originalText.apply(this, arguments);
                    };
                }

                // Guard against NaN display - watch the total price element
                const priceGuard = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'childList' || mutation.type === 'characterData') {
                            const text = totalPriceEl.textContent;
                            // If NaN appears, immediately revert to last valid price
                            if (text.includes('NaN') || text.includes('nan')) {
                                console.error('🚨 NaN detected in price display! Reverting...');
                                const validTotal = basePrice * (lastQty || 1);
                                if (!isNaN(validTotal) && isFinite(validTotal)) {
                                    totalPriceEl.textContent = 'EGP ' + validTotal.toFixed(2);
                                }
                            }
                        }
                    });
                });

                priceGuard.observe(totalPriceEl, {
                    childList: true,
                    characterData: true,
                    subtree: true
                });

                // Initial update - immediate
                updateTotalPrice();
            })();
        </script>
    @endif

    @if($product->isVariant() && $product->variants->count())
        @php
            $quickViewVariants = $product->variants->where('is_active', 1)->map(function($variant) {
                $displayPrice = $variant->sale_price > 0 ? $variant->sale_price : $variant->price;
                return [
                    'id' => $variant->id,
                    'price' => (float) $displayPrice,
                    'original_price' => (float) $variant->price,
                    'sale_price' => (float) $variant->sale_price,
                    'value_ids' => $variant->values->pluck('id')->values()->all(),
                ];
            })->values();
        @endphp

        <script>
            (function() {
                const variants = @json($quickViewVariants);
                const modalId = {{ $product->id }};
                const optionsContainer = document.getElementById('quickViewOptions-' + modalId);
                if (!optionsContainer) return;

                const priceEl = document.getElementById('quickViewPrice-' + modalId);
                const originalPriceEl = document.getElementById('quickViewOriginalPrice-' + modalId);
                const discountEl = document.getElementById('quickViewDiscount-' + modalId);

                // Count total attribute groups
                const attributeGroups = optionsContainer.querySelectorAll('.variant-picker-item');
                const totalAttributeGroups = attributeGroups.length;

                function updatePriceForSelection() {
                    console.log('🎨 [Product ' + modalId + '] Variant selection changed');

                    const selectedValueIds = [];
                    const radioNames = new Set();
                    const radios = optionsContainer.querySelectorAll('input[type="radio"]');

                    radios.forEach(radio => {
                        if (radio.checked) {
                            radioNames.add(radio.name);
                            const label = optionsContainer.querySelector('label[for="' + radio.id + '"]');
                            if (label) {
                                const valueId = parseInt(label.getAttribute('data-value-id'));
                                if (!isNaN(valueId)) {
                                    selectedValueIds.push(valueId);
                                }
                            }
                        }
                    });

                    const selectedGroups = radioNames.size;

                    console.log('  📋 Selected value IDs:', selectedValueIds);
                    console.log('  📊 Selected groups:', selectedGroups, '/', totalAttributeGroups);

                    // Don't try to match if not all attributes are selected
                    if (selectedGroups < totalAttributeGroups) {
                        console.log('  ⏸️  Not all attributes selected yet, skipping price update');
                        // Clear variant-id
                        const addToCartBtn = document.querySelector('#quickView' + modalId + ' [data-product-id="' + modalId + '"]');
                        if (addToCartBtn) {
                            addToCartBtn.removeAttribute('data-variant-id');
                        }
                        return;
                    }

                    if (!selectedValueIds.length) return;

                    // Find matching variant
                    const match = variants.find(v => {
                        if (!v.value_ids || v.value_ids.length !== selectedValueIds.length) return false;
                        const sortedA = [...v.value_ids].sort();
                        const sortedB = [...selectedValueIds].sort();
                        return sortedA.every((val, idx) => val === sortedB[idx]);
                    });

                    console.log('  🔍 Variant match result:', match);

                    if (match && priceEl) {
                        if (match.price === undefined || match.price === null) {
                            console.error('  ❌ Match found but price is undefined/null');
                            return;
                        }

                        const price = parseFloat(match.price);
                        const originalPrice = parseFloat(match.original_price);
                        const salePrice = parseFloat(match.sale_price);

                        console.log('  💰 Variant prices:', { price, originalPrice, salePrice });
                        console.log('  🔍 Price validation:', {
                            isNaN_price: isNaN(price),
                            isFinite_price: isFinite(price),
                            price_value: price
                        });

                        if (!isNaN(price) && isFinite(price) && price > 0) {
                            // Update main display price
                            if (priceEl) {
                                priceEl.textContent = 'EGP ' + price.toFixed(2);
                                console.log('  ✅ Updated display price to:', priceEl.textContent);
                            }

                            // Update button price (totalPrice)
                            const totalPriceEl = document.getElementById('totalPrice-' + modalId);
                            if (totalPriceEl) {
                                totalPriceEl.textContent = 'EGP ' + price.toFixed(2);
                                totalPriceEl.setAttribute('data-original-price', price);
                                console.log('  ✅ Updated button price to:', totalPriceEl.textContent);
                            }

                            // Update base price in quantity widget
                            if (typeof window['updateBasePrice' + modalId] === 'function') {
                                console.log('  🔄 Calling updateBasePrice with:', price);
                                window['updateBasePrice' + modalId](price);
                            } else {
                                console.warn('  ⚠️  updateBasePrice function not available');
                            }

                            // Update Add to cart button variant-id
                            const addToCartBtn = document.getElementById('addToCartBtn-' + modalId);
                            if (addToCartBtn) {
                                addToCartBtn.setAttribute('data-variant-id', match.id);
                                console.log('  🏷️  Set variant-id to:', match.id);
                            }

                            // Update original price and discount
                            if (salePrice > 0 && !isNaN(originalPrice) && !isNaN(salePrice)) {
                                if (originalPriceEl) {
                                    originalPriceEl.style.display = '';
                                    originalPriceEl.textContent = 'EGP ' + originalPrice.toFixed(2);
                                }
                                if (discountEl) {
                                    const discount = Math.round(((originalPrice - salePrice) / originalPrice) * 100);
                                    discountEl.style.display = '';
                                    discountEl.textContent = '-' + discount + '%';
                                }
                            } else {
                                if (originalPriceEl) originalPriceEl.style.display = 'none';
                                if (discountEl) discountEl.style.display = 'none';
                            }
                        } else {
                            console.error('  ❌ Invalid price - cannot update:', {
                                price: price,
                                isNaN: isNaN(price),
                                isFinite: isFinite(price),
                                match: match
                            });
                        }
                    } else if (!match) {
                        console.warn('  ⚠️  No matching variant found for selected values');
                    }
                }

                // Listen to radio changes
                optionsContainer.addEventListener('change', function(e) {
                    if (e.target && e.target.matches('input[type="radio"]')) {
                        // Update selected value label
                        const attributeId = e.target.getAttribute('data-attribute-id');
                        const label = e.target.nextElementSibling;
                        const valueName = label ? label.getAttribute('data-value-name') : '';
                        const valueLabel = document.querySelector('.value-attr-' + attributeId + '-' + modalId);

                        if (valueLabel && valueName) {
                            valueLabel.textContent = valueName;
                        }

                        updatePriceForSelection();

                        // Also check if button should be enabled/disabled
                        if (typeof window['checkVariantSelection' + modalId] === 'function') {
                            window['checkVariantSelection' + modalId]();
                        }
                    }
                });
            })();
        </script>
    @endif

    {{-- Include Bundle Selection Modal for bundle products --}}
    @if($product->isBundle())
        @include('website.pages.home.bundleSelectionModal', ['product' => $product])
    @endif

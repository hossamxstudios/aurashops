<script>
// Shipping Functions
function updateShippingCost(cityId) {
    // console.log('💰 Fetching shipping rates for city:', cityId);
    if (!cityId) {
        $('#shipping-cost').text('Select city first');
        $('#shipping-options-container').hide();
        return;
    }
    $('#shipping-cost').text('Loading...');
    $('#shipping-options-container').hide();
    fetch(`/shipping/rate/${cityId}`)
        .then(response => response.json())
        .then(data => {
            // console.log('✅ Shipping rates:', data);
            const rates = data.rates || [];
            if (rates.length === 0) {
                // No rates found, use default
                applyShippingRate(100.00, null, 'Standard Shipping');
                return;
            }

            if (rates.length === 1) {
                // Only one rate, apply it automatically
                const rate = rates[0];
                // console.log('📦 Single rate found:', rate);
                // console.log('📦 Rate ID:', rate.id);
                // console.log('📦 Shipper Name:', rate.shipper_name);
                const cartSubtotal = parseFloat($('#cart-subtotal').text().replace(/[^0-9.]/g, '')) || 0;
                const freeThreshold = parseFloat(rate.free_shipping_threshold) || 0;
                const qualifiesForFree = rate.is_free_shipping && cartSubtotal >= freeThreshold;
                const finalRate = qualifiesForFree ? 0 : (parseFloat(rate.rate) || 0);
                // Show free shipping message if applicable
                if (qualifiesForFree) {
                    $('#shipping-cost').html(finalRate.toFixed(2) + ' EGP <span class="badge bg-success ms-2">✓ Free!</span>');
                }
                // console.log('🚀 Calling applyShippingRate with:', finalRate, rate.id, rate.shipper_name);
                applyShippingRate(finalRate, rate.id, rate.shipper_name);
            } else {
                // Multiple rates, show options
                displayShippingOptions(rates);
            }
        })
        .catch(error => {
            // console.error('❌ Error fetching shipping rates:', error);
            applyShippingRate(100.00, null, 'Standard Shipping (Default)');
        });
}
// Function to display shipping options when multiple rates available
function displayShippingOptions(rates) {
    const container = $('#shipping-options-list');
    container.empty();
    // Get current cart subtotal
    const cartSubtotal = parseFloat($('#cart-subtotal').text().replace(/[^0-9.]/g, '')) || 0;
    rates.forEach((rate, index) => {
        let rateValue = parseFloat(rate.rate) || 0;
        const freeThreshold = parseFloat(rate.free_shipping_threshold) || 0;
        const isFreeShipping = rate.is_free_shipping && freeThreshold > 0;
        // Check if order qualifies for free shipping
        const qualifiesForFree = isFreeShipping && cartSubtotal >= freeThreshold;
        let freeShippingText = '';
        let displayRate = rateValue;
        if (qualifiesForFree) {
            displayRate = 0;
            freeShippingText = `<span class="badge bg-success ms-2">✓ Free Shipping Applied!</span>`;
        } else if (isFreeShipping) {
            const remaining = freeThreshold - cartSubtotal;
            freeShippingText = `<span class="badge bg-warning text-dark ms-2">Add ${remaining.toFixed(2)} EGP for Free Shipping</span>`;
        }
        const optionHtml = `
            <div class="mb-2 form-check" style="padding: 10px; border: 2px solid #e5e5e5; border-radius: 6px; cursor: pointer;">
                <input class="form-check-input shipping-option" type="radio"
                       name="shipping_method"
                       id="shipping${index}"
                       value="${rate.id || ''}"
                       data-rate="${displayRate}"
                       data-original-rate="${rateValue}"
                       data-shipper="${rate.shipper_name || 'Standard'}"
                       data-free-shipping="${isFreeShipping}"
                       data-free-threshold="${freeThreshold}"
                       ${index === 0 ? 'checked' : ''}>
                <label class="form-check-label w-100" for="shipping${index}" style="cursor: pointer;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${rate.shipper_name || 'Standard Shipping'}</strong>
                            ${freeShippingText}
                        </div>
                        <div class="text-primary fw-bold ${qualifiesForFree ? 'text-decoration-line-through text-muted' : ''}">
                            ${qualifiesForFree ? rateValue.toFixed(2) : displayRate.toFixed(2)} EGP
                            ${qualifiesForFree ? '<span class="text-success ms-2">FREE</span>' : ''}
                        </div>
                    </div>
                </label>
            </div>
        `;
        container.append(optionHtml);
    });

    $('#shipping-options-container').show();

    // Apply first rate by default
    const firstRateElement = rates[0];
    const firstCartSubtotal = parseFloat($('#cart-subtotal').text().replace(/[^0-9.]/g, '')) || 0;
    const firstFreeThreshold = parseFloat(firstRateElement.free_shipping_threshold) || 0;
    const firstQualifies = firstRateElement.is_free_shipping && firstCartSubtotal >= firstFreeThreshold;
    const firstRateValue = firstQualifies ? 0 : (parseFloat(firstRateElement.rate) || 0);

    applyShippingRate(firstRateValue, firstRateElement.id, firstRateElement.shipper_name);

    // Handle shipping option change
    $('.shipping-option').on('change', function() {
        const selectedRate = parseFloat($(this).data('rate')) || 0;
        const selectedId = $(this).val();
        const selectedShipper = $(this).data('shipper');
        applyShippingRate(selectedRate, selectedId, selectedShipper);
    });
}

// Function to apply selected shipping rate
function applyShippingRate(shippingCost, rateId, shipperName) {
    // Ensure shippingCost is a valid number
    const cost = parseFloat(shippingCost) || 0;
    const subtotal = parseFloat($('#cart-subtotal').text().replace(/[^0-9.]/g, '')) || 0;
    const discount = parseFloat('{{ $cart->discount }}') || 0;
    const total = subtotal + cost - discount;

    // Update UI
    $('#shipping-cost').text(cost.toFixed(2) + ' EGP');
    $('#final-total').text(total.toFixed(2) + ' EGP');

    // Store shipping rate and rate ID in hidden inputs
    let shippingInput = $('#selected-shipping-rate');
    if (shippingInput.length === 0) {
        $('#checkoutForm').append('<input type="hidden" id="selected-shipping-rate" name="shipping_rate" value="' + cost + '">');
        $('#checkoutForm').append('<input type="hidden" id="selected-shipping-rate-id" name="shipping_rate_id" value="' + (rateId || '') + '">');
        // console.log('✅ Created hidden inputs - Rate ID:', rateId, 'Cost:', cost);
    } else {
        shippingInput.val(cost);
        $('#selected-shipping-rate-id').val(rateId || '');
        // console.log('✅ Updated hidden inputs - Rate ID:', rateId, 'Cost:', cost);
    }

    // console.log('💵 Applied:', shipperName, '- Subtotal:', subtotal, 'Shipping:', cost, 'Total:', total, 'Rate ID:', rateId);
}

// Update shipping when city is selected (guest checkout)
$(document).ready(function() {
    $('#citySelect').on('change', function() {
        const cityId = $(this).val();
        if (cityId) {
            updateShippingCost(cityId);
        }
    });

    // Update shipping when address is selected (logged in users)
    @if(Auth::guard('client')->check())
    // console.log('👤 User is logged in - Setting up address change listener');
    $(document).on('change', 'input[name="address_id"]', function() {
        const addressCard = $(this).closest('.address-item');
        const cityId = addressCard.data('city-id');
        // console.log('📍 Address selected, city ID:', cityId);
        if (cityId) {
            updateShippingCost(cityId);
        } else {
            // console.error('❌ No city ID found for selected address');
        }
    });

    setTimeout(function() {
        // console.log('🔍 Looking for default address...');
        // console.log('Found address radio inputs:', $('input[name="address_id"]').length);
        // console.log('Checked address:', $('input[name="address_id"]:checked').length);
        const defaultAddress = $('input[name="address_id"]:checked').closest('.address-item');
        if (defaultAddress.length) {
            const cityId = defaultAddress.data('city-id');
            // console.log('🏠 Default address found!');
            // console.log('City ID:', cityId);
            // console.log('Address data:', defaultAddress.data());

            if (cityId) {
                // console.log('✅ Triggering shipping update for default address...');
                updateShippingCost(cityId);
            } else {
                // console.error('❌ No city ID found for default address');
                // console.log('Address element:', defaultAddress[0]);
            }
        } else {
            // console.log('⚠️  No default address found');
            // console.log('All address items:', $('.address-item').length);

            // Manually trigger shipping for first address if exists
            if ($('.address-item').length > 0) {
                const firstAddress = $('.address-item').first();
                const cityId = firstAddress.data('city-id');
                // console.log('🔄 Trying first address, City ID:', cityId);
                if (cityId) {
                    updateShippingCost(cityId);
                }
            }
        }
    }, 1000);
    @endif
});
</script>

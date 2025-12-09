<script>
$(document).ready(function() {
    console.log('🛒 Cart initialized');
    // Remove any theme event listeners from remove buttons
    $('.remove.icon-close').off('click');
    console.log('✅ Removed theme listeners from remove buttons');
    // Remove item function (called from onclick)
    window.removeItem = function(itemId, event) {
        console.log('🗑️ Removing item:', itemId);
        // Stop any other handlers
        if (event) {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
        }
        // Confirmation
        if (!confirm('Are you sure you want to remove this item from your cart?')) {
            console.log('❌ User cancelled removal');
            return false;
        }
        console.log('✅ User confirmed removal');
        const $row = $(`tr:has([data-item-id="${itemId}"])`).first();
        const $btn = $row.find('.remove');
        // Disable button
        $btn.prop('disabled', true).css('opacity', '0.5');
        // Send AJAX DELETE request
        $.ajax({
            url: `/cart/${itemId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('✅ Response:', response);
                if (response.success) {
                    showNotification('Item removed from cart!', 'success');
                    // Animate and remove row
                    $row.fadeOut(300, function() {
                        $(this).remove();
                        // Check if cart is empty
                        const remainingItems = $('.tf-page-cart-item').length;
                        console.log('Remaining items:', remainingItems);
                        if (remainingItems === 0) {
                            console.log('Cart is empty, reloading...');
                            location.reload();
                            return;
                        }
                        // Update cart totals
                        updateCartTotals(response.cart);
                    });
                } else {
                    showNotification(response.message || 'Failed to remove item', 'error');
                    $btn.prop('disabled', false).css('opacity', '1');
                }
            },
            error: function(xhr, status, error) {
                console.error('❌ Error:', error);
                console.error('Response:', xhr.responseText);
                showNotification('Error removing item. Please try again.', 'error');
                $btn.prop('disabled', false).css('opacity', '1');
            }
        });
    }

    // ========================================
    // 2. UPDATE QUANTITY (+ / -)
    // ========================================
    $('.btn-quantity').off('click').on('click', function(e) {
        e.preventDefault();
        const $btn = $(this);
        if ($btn.hasClass('processing')) return false;
        $btn.addClass('processing');
        const itemId = $btn.data('item-id');
        const $input = $btn.siblings('.quantity-product');
        const currentQty = parseInt($input.val()) || 1;
        let newQty = currentQty;

        if ($btn.hasClass('btn-increase')) {
            newQty = currentQty + 1;
        } else if ($btn.hasClass('btn-decrease') && currentQty > 1) {
            newQty = currentQty - 1;
        }
        if (newQty !== currentQty) {
            $input.val(newQty);
            $('.btn-quantity').prop('disabled', true);
            updateCartItemQty(itemId, newQty);
        } else {
            $btn.removeClass('processing');
        }
        return false;
    });

    // ========================================
    // 3. MANUAL QUANTITY INPUT
    // ========================================
    $('.quantity-product').off('change').on('change', function() {
        const $input = $(this);
        const itemId = $input.data('item-id');
        let qty = parseInt($input.val()) || 1;

        if (qty < 1) {
            qty = 1;
            $input.val(1);
        }

        $('.btn-quantity, .quantity-product').prop('disabled', true);
        updateCartItemQty(itemId, qty);
    });

    // ========================================
    // 4. CLEAR CART
    // ========================================
    $('.clear-cart-form').off('submit').on('submit', function(e) {
        e.preventDefault();

        if (!confirm('Clear entire cart?')) return false;

        const $form = $(this);
        const $btn = $form.find('button');

        $btn.prop('disabled', true).css('opacity', '0.5');

        $.ajax({
            url: $form.attr('action'),
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                if (response.success) {
                    showNotification('Cart cleared!', 'success');
                    setTimeout(() => location.reload(), 500);
                }
            },
            error: function() {
                showNotification('Error clearing cart', 'error');
                $btn.prop('disabled', false).css('opacity', '1');
            }
        });
    });

    // ========================================
    // 5. SHIPPING COST CALCULATION
    // ========================================
    $('input[name="ship-check"]').off('change').on('change', function() {
        const $label = $(this).next('label');
        const priceText = $label.find('.price').text();
        const shippingCost = parseFloat(priceText.replace('$', ''));

        $('.shipping-amount').text('$' + shippingCost.toFixed(2));

        // Update grand total
        const subtotal = parseFloat($('.subtotal-amount').text().replace('$', '')) || 0;
        const grandTotal = subtotal + shippingCost;
        $('.total-order .total').text('$' + grandTotal.toFixed(2));
    });

    // ========================================
    // 6. CHECKOUT VALIDATION
    // ========================================
    $('.box-progress-checkout a.tf-btn').off('click').on('click', function(e) {
        const $checkbox = $('#check-agree');

        if (!$checkbox.is(':checked')) {
            e.preventDefault();
            showNotification('Please agree to terms and conditions', 'warning');
            $checkbox.closest('fieldset').addClass('shake');
            setTimeout(() => $checkbox.closest('fieldset').removeClass('shake'), 500);
        }
    });

    // ========================================
    // HELPER FUNCTIONS
    // ========================================

    // Update cart item quantity via AJAX
    function updateCartItemQty(itemId, qty) {
        $.ajax({
            url: `/cart/${itemId}`,
            type: 'PUT',
            data: {qty: qty},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                if (response.success) {
                    showNotification('Cart updated!', 'success');
                    // Update item subtotal in row
                    const $row = $(`[data-item-id="${itemId}"]`).closest('tr');
                    if (response.item && response.item.sub_total) {
                        $row.find('.cart-total').text('$' + parseFloat(response.item.sub_total).toFixed(2));
                    }
                    // Update cart totals
                    updateCartTotals(response.cart);
                    // Re-enable buttons
                    setTimeout(function() {
                        $('.btn-quantity').prop('disabled', false).removeClass('processing');
                        $('.quantity-product').prop('disabled', false);
                    }, 300);
                } else {
                    showNotification(response.message || 'Failed to update', 'error');
                    setTimeout(() => location.reload(), 1000);
                }
            },
            error: function() {
                showNotification('Error updating cart', 'error');
                setTimeout(() => location.reload(), 1000);
            }
        });
    }

    // Update cart totals in UI
    function updateCartTotals(cart) {
        if (!cart) return;

        // Update subtotal
        if (cart.subtotal !== undefined) {
            $('.subtotal-amount').text('$' + parseFloat(cart.subtotal).toFixed(2));
        }

        // Update grand total (with shipping)
        const shippingCost = parseFloat($('.shipping-amount').text().replace('$', '')) || 0;
        const grandTotal = parseFloat(cart.subtotal || 0) + shippingCost;
        $('.total-order .total').text('$' + grandTotal.toFixed(2));

        // Update cart count in navbar
        if (cart.count !== undefined) {
            $('.count-box, .cart-count-badge').text(cart.count);
        }
    }

    // Show notification
    function showNotification(message, type = 'success') {
        $('.cart-notification').remove();

        const alertClass = type === 'success' ? 'alert-success' :
                          type === 'warning' ? 'alert-warning' : 'alert-danger';

        const $notification = $(`
            <div class="cart-notification alert ${alertClass} alert-dismissible fade show"
                 style="position: fixed; top: 100px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

        $('body').append($notification);

        setTimeout(() => $notification.remove(), 3000);
    }

    // ========================================
    // CSS STYLES
    // ========================================
    $('<style>').text(`
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        .shake {
            animation: shake 0.5s;
            border: 2px solid #dc3545 !important;
            border-radius: 4px;
            padding: 5px;
        }
        .btn-quantity:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .remove.icon-close:hover {
            color: #dc3545;
            transform: scale(1.1);
            transition: all 0.3s ease;
        }
        @media (max-width: 768px) {
            .cart-action-buttons {
                flex-direction: column;
            }
            .cart-action-buttons .tf-btn {
                width: 100%;
            }
        }
    `).appendTo('head');
});
</script>



    <div class="modal fullRight fade modal-shopping-cart" id="shoppingCart">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- <div class="tf-minicart-recommendations">
                    <h6 class="title">You May Also Like</h6>
                    <div class="wrap-recommendations">
                        <div class="list-cart">
                            <div class="list-cart-item">
                                <div class="image">
                                    <img class="lazyload" data-src="website/images/products/womens/women-1.jpg"
                                        src="website/images/products/womens/women-1.jpg" alt="">
                                </div>
                                <div class="content">
                                    <div class="name">
                                        <a class="link text-line-clamp-1" href="product-detail.html">Belt wrap dress</a>
                                    </div>
                                    <div class="cart-item-bot">
                                        <div class="text-button price">$59.99</div>
                                        <a class="link text-button" href="#">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="d-flex flex-column flex-grow-1 h-100">
                    <div class="header">
                        <h5 class="title">Shopping Cart</h5>
                        <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                    </div>
                    <div class="wrap">
                        {{-- <div class="tf-mini-cart-threshold">
                            <div class="tf-progress-bar">
                                <div class="value" style="width: 0%;" data-progress="75">
                                    <i class="icon icon-shipping"></i>
                                </div>
                            </div>
                            <div class="text-caption-1">
                                Congratulations! You've got free shipping!
                            </div>
                        </div> --}}
                        <div class="tf-mini-cart-wrap">
                            <div class="tf-mini-cart-main">
                                <div class="tf-mini-cart-sroll">
                                    <div class="tf-mini-cart-items" id="cartItemsContainer">
                                        <!-- Cart items will be loaded dynamically -->
                                        @include('website.partials.cart-items', ['cart' => $cart])
                                    </div>
                                </div>
                            </div>
                            <div class="tf-mini-cart-bottom">
                                <div class="tf-mini-cart-bottom-wrap">
                                    <div class="tf-cart-totals-discounts">
                                        <h5>Subtotal</h5>
                                        <h5 class="tf-totals-total-value" id="cartTotal">{{ $cart?->items?->sum('sub_total') ?? '0' }}</h5>
                                    </div>
                                    <div class="tf-mini-cart-view-checkout">
                                        <a href="{{ route('cart.page') }}"
                                            class="tf-btn w-100 btn-white radius-4 has-border"><span class="text">View
                                                cart</span></a>
                                        <a href="{{ route('checkout.page') }}" class="tf-btn w-100 btn-fill radius-4"><span
                                                class="text">Check Out</span></a>
                                    </div>
                                    <div class="text-center">
                                        <a class="link text-btn-uppercase" href="{{ route('shop.all') }}">Or continue
                                            shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    // Handle cart item removal
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.tf-btn-remove').forEach(removeBtn => {
            removeBtn.addEventListener('click', function() {
                const itemId = this.getAttribute('data-item-id');
                const cartItemElement = document.querySelector(`[data-cart-item-id="${itemId}"]`);
                if (!itemId) {
                    console.error('Cart item ID not found');
                    return;
                }
                // Show loading state
                this.textContent = 'Removing...';
                this.style.pointerEvents = 'none';
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                // Send DELETE request
                fetch(`/cart/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Remove response:', data);
                    if (data.success) {
                        // Remove item from UI with animation
                        if (cartItemElement) {
                            cartItemElement.style.transition = 'opacity 0.3s, transform 0.3s';
                            cartItemElement.style.opacity = '0';
                            cartItemElement.style.transform = 'translateX(-20px)';
                            setTimeout(() => {
                                cartItemElement.remove();
                                // Check if cart is empty
                                const remainingItems = document.querySelectorAll('.tf-mini-cart-item').length;
                                if (remainingItems === 0) {
                                    // Reload page to show empty cart state
                                    location.reload();
                                }
                            }, 300);
                        }
                        // Update cart count
                        if (window.ShopFeatures && window.ShopFeatures.updateCartCount) {
                            window.ShopFeatures.updateCartCount(data.cart.count);
                        }
                        // Update cart total
                        const cartTotalElement = document.getElementById('cartTotal');
                        if (cartTotalElement && data.cart.total !== undefined) {
                            cartTotalElement.textContent = data.cart.total;
                        }
                        // Show minimal success notification
                        if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                            window.ShopFeatures.showNotification('✓ Item removed', 'success');
                        }
                    } else {
                        // Show error notification
                        if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                            window.ShopFeatures.showNotification(data.message || 'Failed to remove item', 'error');
                        }
                        // Reset button state
                        this.textContent = 'Remove';
                        this.style.pointerEvents = 'auto';
                    }
                })
                .catch(error => {
                    console.error('Remove item error:', error);
                    if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                        window.ShopFeatures.showNotification('An error occurred. Please try again.', 'error');
                    }
                    // Reset button state
                    this.textContent = 'Remove';
                    this.style.pointerEvents = 'auto';
                });
            });
        });
    });

    // Global function to refresh cart content
    window.refreshCartContent = function() {
        fetch('/cart/get/html')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart items HTML
                    const cartContainer = document.getElementById('cartItemsContainer');
                    if (cartContainer) {
                        cartContainer.innerHTML = data.html;
                        // Re-attach remove button listeners
                        document.querySelectorAll('.tf-btn-remove').forEach(removeBtn => {
                            removeBtn.addEventListener('click', function() {
                                const itemId = this.getAttribute('data-item-id');
                                const cartItemElement = document.querySelector(`[data-cart-item-id="${itemId}"]`);
                                if (!itemId) return;
                                this.textContent = 'Removing...';
                                this.style.pointerEvents = 'none';
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                                fetch(`/cart/${itemId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Refresh cart and show notification
                                        window.refreshCartContent();
                                        if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                                            window.ShopFeatures.showNotification('✓ Item removed', 'success');
                                        }
                                    }
                                });
                            });
                        });
                    }

                    // Update cart count badges
                    const cartCount = data.cart.count || 0;
                    console.log('Updating cart count to:', cartCount);

                    // Update all cart count elements directly
                    document.querySelectorAll('#cartCountBadge, #cartCountBadgeMobile, .count-box').forEach(el => {
                        el.textContent = cartCount;
                        el.style.display = cartCount > 0 ? '' : 'none';
                    });

                    // Also call ShopFeatures if available
                    if (window.ShopFeatures && window.ShopFeatures.updateCartCount) {
                        window.ShopFeatures.updateCartCount(cartCount);
                    }

                    // Update cart total
                    const cartTotalElement = document.getElementById('cartTotal');
                    if (cartTotalElement && data.cart.total !== undefined) {
                        cartTotalElement.textContent = data.cart.total;
                    }
                }
            })
            .catch(error => {
                console.error('Error refreshing cart:', error);
            });
    };
</script>

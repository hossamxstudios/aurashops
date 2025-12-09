<div class="col-xl-5">
    <div class="flat-spacing flat-sidebar-checkout">
        <div class="sidebar-checkout-content">
            <h5 class="title">Shopping Cart</h5>
            <div class="list-product">
                @foreach ($cart->items as $item)
                <div class="item-product">
                    <a href="{{ route('product.show', $item->product->slug) }}" class="img-product">
                        <img src="{{ $item->product->getFirstMediaUrl('product_thumbnail') }}" alt="img-product">
                    </a>
                    <div class="content-box">
                        <div class="info">
                            <a href="{{ route('product.show', $item->product->slug) }}" class="name-product link text-title">{{ $item->product->name }}</a>
                            @if($item->product->isVariant())
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-secondary-2">{{ $item->variant?->name }}</div>
                                </div>
                            @elseif($item->product->isBundle())
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-secondary-2 fw-5">Bundle includes:</div>
                                </div>
                                @if($item->options && $item->options->count() > 0)
                                    @foreach($item->options as $option)
                                        <div class="text-caption-1 text-secondary ps-3">
                                            <i class="icon-check" style="font-size: 10px;"></i>
                                            {{ $option->childProduct?->name }}
                                            @if($option->childVariant)
                                                <span class="fw-5">({{ $option->childVariant->name }})</span>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            @else
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-secondary-2">Simple Product</div>
                                </div>
                            @endif
                        </div>
                        <div class="total-price text-button"><span class="count">{{ $item->qty }}</span>X<span class="price">{{ $item->price }}</span></div>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- Shipping Options --}}
            <div id="shipping-options-container" style="display: none; margin-top: 1.5rem; padding: 1rem; background: #f9f9f9; border-radius: 8px;">
                <h6 class="mb-3">Select Shipping Method</h6>
                <div id="shipping-options-list"></div>
            </div>

            <div class="sec-total-price">
                <div class="top">
                    <div class="item d-flex align-items-center justify-content-between text-button">
                        <span>Subtotal</span>
                        <span id="cart-subtotal">{{ number_format($cart->items?->sum('sub_total'), 2) }} EGP</span>
                    </div>
                    <div class="item d-flex align-items-center justify-content-between text-button">
                        <span>Shipping</span>
                        <span id="shipping-cost">Select city first</span>
                    </div>
                    <div class="item d-flex align-items-center justify-content-between text-button">
                        <span>Discounts</span>
                        <span>-{{ number_format($cart->discount, 2) }} EGP</span>
                    </div>
                </div>
                <div class="bottom">
                    <h5 class="d-flex justify-content-between">
                        <span>Total</span>
                        <span class="total-price-checkout" id="final-total">{{ number_format($cart->items?->sum('sub_total'), 2) }} EGP</span>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

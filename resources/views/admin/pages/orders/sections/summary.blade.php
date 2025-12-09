<div class="card mb-3">
    <div class="card-header bg-light">
        <h6 class="card-title mb-0">
            <i class="ti ti-calculator me-2"></i>
            Order Summary
        </h6>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Subtotal</span>
            <strong>{{ number_format($order->subtotal_amount, 2) }} EGP</strong>
        </div>

        @if($order->discount_amount > 0)
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Discount</span>
                <strong class="text-danger">-{{ number_format($order->discount_amount, 2) }} EGP</strong>
            </div>
            @if($order->coupon_code)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Coupon</span>
                    <span class="badge bg-success">{{ $order->coupon_code }}</span>
                </div>
            @endif
        @endif

        @if($order->tax_amount > 0)
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Tax ({{ $order->tax_rate }}%)</span>
                <strong>{{ number_format($order->tax_amount, 2) }} EGP</strong>
            </div>
        @endif

        @if($order->shipping_fee > 0)
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Shipping Fee</span>
                <strong>{{ number_format($order->shipping_fee, 2) }} EGP</strong>
            </div>
        @endif

        @if($order->points_used > 0)
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">
                    Points Used
                    <i class="ti ti-coin text-warning"></i>
                </span>
                <strong class="text-warning">-{{ number_format($order->points_to_cash, 2) }} EGP</strong>
            </div>
            <small class="text-muted d-block mb-2">{{ $order->points_used }} points</small>
        @endif

        @if($order->is_cod)
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">COD Fee</span>
                <strong>{{ number_format($order->cod_fee, 2) }} EGP</strong>
            </div>
        @endif

        <hr>

        <div class="d-flex justify-content-between">
            <strong class="fs-5">Total</strong>
            <strong class="fs-5 text-primary">{{ number_format($order->total_amount, 2) }} EGP</strong>
        </div>
    </div>
</div>

<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Order Confirmation</title>
    <meta name="title" content="Order Confirmation - Aura">
    <meta name="description" content="Order Confirmation - Aura Beauty Care">
    <meta name="keywords" content="cosmetics, skin care, hair care, body care, beauty">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    @include('website.main.meta')
</head>
<body class="preload-wrapper">
    <div id="wrapper">
        @include('website.main.navbar')

        <section class="mt-5 flat-spacing">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                {{-- Success Message --}}
                <div class="text-center alert alert-success" style="padding: 2rem; border-radius: 10px;">
                    <i class="icon-check-circle" style="font-size: 48px; color: #28a745;"></i>
                    <h3 class="mt-3 mb-2">Order Placed Successfully!</h3>
                    <p class="mb-0">Thank you for your order. Your order number is <strong>#{{ $order->id }}</strong></p>
                    @if($order->is_cod)
                        <p class="mt-2 text-success"><strong>✓ Cash on Delivery</strong> - You will pay when you receive your order</p>
                    @elseif($order->is_paid)
                        <p class="mt-2 text-success"><strong>✓ Payment Confirmed</strong> - Your payment has been processed successfully</p>
                    @else
                        <div class="mt-3 alert alert-warning">
                            <strong>⚠️ Payment Pending</strong><br>
                            Your order has been placed but payment is pending. Please contact our support team to complete the payment process to ensure your order is processed.
                            <br><small>Support: support@example.com | +20 XXX XXX XXXX</small>
                        </div>
                    @endif
                </div>

                {{-- Order Invoice --}}
                <div class="mt-4 card" style="border: 1px solid #ddd;">
                    <div class="card-header bg-light" style="padding: 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Order Invoice</h4>
                            <button onclick="window.print()" class="tf-btn btn-sm">
                                <i class="icon-printer"></i> Print Invoice
                            </button>
                        </div>
                    </div>

                    <div class="card-body" style="padding: 2rem;">
                        {{-- Order Details --}}
                        <div class="mb-4 row">
                            <div class="col-md-6">
                                <h6>Order Information</h6>
                                <p class="mb-1"><strong>Order ID:</strong> #{{ $order->id }}</p>
                                <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                                <p class="mb-1"><strong>Status:</strong>
                                    <span class="badge bg-{{ $order->orderStatus->id == 1 ? 'warning' : 'success' }}">
                                        {{ $order->orderStatus->name ?? 'Pending' }}
                                    </span>
                                </p>
                                <p class="mb-1"><strong>Payment Method:</strong>
                                    @if($order->is_cod)
                                        Cash on Delivery
                                    @else
                                        Credit Card
                                    @endif
                                </p>
                            </div>

                            <div class="col-md-6">
                                <h6>Delivery Address</h6>
                                @if($order->address)
                                    <p class="mb-1">{{ $order->address->label }}</p>
                                    <p class="mb-1">{{ $order->address->street }}, {{ $order->address->building }}</p>
                                    <p class="mb-1">Floor {{ $order->address->floor }}, Apt {{ $order->address->apartment }}</p>
                                    <p class="mb-1">{{ $order->address->district->districtName }}, {{ $order->address->zone->zoneName }}</p>
                                    <p class="mb-1">{{ $order->address->city->cityName }}</p>
                                    <p class="mb-1"><strong>Phone:</strong> {{ $order->address->phone }}</p>
                                @endif
                            </div>
                        </div>

                        <hr>

                        {{-- Order Items --}}
                        <h6 class="mb-3">Order Items</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <strong>{{ $item->product->name }}</strong>
                                                    @if($item->variant)
                                                        <br><small class="text-muted">{{ $item->variant->name }}</small>
                                                    @endif
                                                    @if($item->options && $item->options->count() > 0)
                                                        <br><small class="text-muted">Bundle Items:</small>
                                                        @foreach($item->options as $option)
                                                            <br><small class="text-muted">• {{ $option->childProduct->name }}
                                                            @if($option->childVariant)
                                                                ({{ $option->childVariant->name }})
                                                            @endif
                                                            </small>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-end">{{ number_format($item->price, 2) }} EGP</td>
                                        <td class="text-end">{{ number_format($item->subtotal, 2) }} EGP</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        {{-- Order Summary --}}
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Subtotal:</strong></td>
                                        <td class="text-end">{{ number_format($order->subtotal_amount, 2) }} EGP</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Shipping:</strong></td>
                                        <td class="text-end">{{ number_format($order->shipping_fee, 2) }} EGP</td>
                                    </tr>
                                    @if($order->discount_amount > 0)
                                    <tr>
                                        <td><strong>Discount:</strong></td>
                                        <td class="text-end text-danger">-{{ number_format($order->discount_amount, 2) }} EGP</td>
                                    </tr>
                                    @endif
                                    @if($order->cod_fee > 0)
                                    <tr>
                                        <td><strong>COD Fee:</strong></td>
                                        <td class="text-end">{{ number_format($order->cod_fee, 2) }} EGP</td>
                                    </tr>
                                    @endif
                                    <tr class="border-top">
                                        <td><h5 class="mb-0">Total:</h5></td>
                                        <td class="text-end"><h5 class="mb-0 text-primary">{{ number_format($order->total_amount, 2) }} EGP</h5></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        {{-- Shipping Info --}}
                        @if($order->shipment)
                        <hr>
                        <h6 class="mb-3">Shipping Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Shipper:</strong> {{ $order->shipment->shipper->carrier_name ?? 'Standard Shipping' }}</p>
                                <p class="mb-1"><strong>Status:</strong>
                                    <span class="badge bg-{{ $order->shipment->status == 'delivered' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->shipment->status) }}
                                    </span>
                                </p>
                                @if($order->shipment->tracking_number)
                                    <p class="mb-1"><strong>Tracking Number:</strong> {{ $order->shipment->tracking_number }}</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-4 mb-5 text-center">
                    <a href="{{ route('home') }}" class="w-auto tf-btn btn-fill radius-4">
                        <span class="text">Continue Shopping</span>
                    </a>
                </div>
                    </div>
                </div>
            </div>
        </section>

        @include('website.main.footer')
    </div>

    @include('website.main.scripts')

    <style>
        @media print {
            .tf-btn, .breadcrumb, .tf-page-title, .navbar, .footer { display: none !important; }
            .card { border: 1px solid #000 !important; }
        }
    </style>
</body>
</html>

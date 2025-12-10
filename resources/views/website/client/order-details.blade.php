<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Order #{{ $order->id }}</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="Order Details - Aura Beauty Care">
    <meta name="keywords" content="cosmetics, skin care, hair care, body care, beauty">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    @include('website.main.meta')
</head>
<body class="preload-wrapper">
    <div id="wrapper">
        @include('website.main.navbar')

        <!-- page-title -->
        <div class="page-title" style="background-image: url({{ asset('website/images/section/page-title.jpg') }});">
            <div class="pt-5 container-full">
                <div class="pt-5 row">
                    <div class="col-12">
                        <h3 class="text-center heading">Order #ORD-{{ $order->id }}</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li>
                                <a class="link" href="{{ route('home') }}">Homepage</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                <a class="link" href="{{ route('client.dashboard') }}">Dashboard</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                <a class="link" href="{{ route('client.orders') }}">Orders</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                Order Details
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->

        <div class="btn-sidebar-account">
            <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount"><i class="icon icon-squares-four"></i></button>
        </div>

        <!-- order details -->
        <section class="flat-spacing">
            <div class="container">
                <div class="my-account-wrap">
                    @include('website.client.partials.sidebar')

                    <div class="my-account-content">
                        <div class="account-order-details">
                            <div class="wd-form-order">
                                <!-- Order Head -->
                                <div class="order-head">
                                    @php
                                        $firstItem = $order->items->first();
                                        $productImage = $firstItem && $firstItem->product
                                            ? $firstItem->product->getFirstMediaUrl('product_thumbnail')
                                            : asset('website/images/default-product.jpg');
                                    @endphp
                                    <figure class="img-product">
                                        <img src="{{ $productImage }}" alt="product">
                                    </figure>
                                    <div class="content">
                                        @php
                                            $statusName = $order->orderStatus?->name ?? 'Pending';
                                            $badgeClass = 'badge';

                                            if($order->is_done) {
                                                $statusName = 'Delivered';
                                            } elseif($order->is_canceled) {
                                                $statusName = 'Cancelled';
                                            }
                                        @endphp
                                        <div class="badge">{{ $statusName }}</div>
                                        <h6 class="mt-8 fw-5">Order #ORD-{{ $order->id }}</h6>
                                    </div>
                                </div>

                                <!-- Order Info Grid -->
                                <div class="tf-grid-layout md-col-2 gap-15">
                                    <div class="item">
                                        <div class="text-2 text_black-2">Items</div>
                                        <div class="text-2 mt_4 fw-6">{{ $order->items->count() }} Product(s)</div>
                                    </div>
                                    <div class="item">
                                        <div class="text-2 text_black-2">Payment Method</div>
                                        <div class="text-2 mt_4 fw-6">
                                            {{ $order->paymentMethod?->name ?? 'N/A' }}
                                            @if($order->is_cod)
                                                <span class="badge bg-dark ms-2">COD</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="text-2 text_black-2">Order Date</div>
                                        <div class="text-2 mt_4 fw-6">{{ $order->created_at->format('d F Y, H:i:s') }}</div>
                                    </div>
                                    <div class="item">
                                        <div class="text-2 text_black-2">Delivery Address</div>
                                        <div class="text-2 mt_4 fw-6">
                                            @if($order->address)
                                                {{ $order->address->district->zone->city->cityName ?? '' }},
                                                {{ $order->address->district->districtName ?? '' }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabs Widget -->
                                <div class="widget-tabs style-3 widget-order-tab">
                                    <ul class="widget-menu-tab">
                                        <li class="item-title active">
                                            <span class="inner">Order History</span>
                                        </li>
                                        <li class="item-title">
                                            <span class="inner">Item Details</span>
                                        </li>
                                        <li class="item-title">
                                            <span class="inner">Shipping</span>
                                        </li>
                                        <li class="item-title">
                                            <span class="inner">Receiver</span>
                                        </li>
                                    </ul>

                                    <div class="widget-content-tab">
                                        <!-- Tab 1: Order History -->
                                        <div class="widget-content-inner active">
                                            <div class="widget-timeline">
                                                <ul class="timeline">
                                                    @if($order->is_done)
                                                        <li>
                                                            <div class="timeline-badge success"></div>
                                                            <div class="timeline-box">
                                                                <a class="timeline-panel" href="javascript:void(0);">
                                                                    <div class="text-2 fw-6">Order Delivered</div>
                                                                    <span>{{ $order->updated_at->format('d/m/Y g:ia') }}</span>
                                                                </a>
                                                                <p><strong>Status:</strong> Order completed successfully</p>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    @if($order->is_canceled)
                                                        <li>
                                                            <div class="timeline-badge"></div>
                                                            <div class="timeline-box">
                                                                <a class="timeline-panel" href="javascript:void(0);">
                                                                    <div class="text-2 fw-6">Order Cancelled</div>
                                                                    <span>{{ $order->updated_at->format('d/m/Y g:ia') }}</span>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <div class="timeline-badge {{ $order->is_done ? 'success' : '' }}"></div>
                                                            <div class="timeline-box">
                                                                <a class="timeline-panel" href="javascript:void(0);">
                                                                    <div class="text-2 fw-6">{{ $order->orderStatus?->name ?? 'Processing' }}</div>
                                                                    <span>{{ $order->updated_at->format('d/m/Y g:ia') }}</span>
                                                                </a>
                                                                @if($order->shipping_fee)
                                                                    <p><strong>Shipping Fee:</strong> {{ number_format($order->shipping_fee, 2) }} EGP</p>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <div class="timeline-badge {{ $order->is_canceled ? '' : 'success' }}"></div>
                                                        <div class="timeline-box">
                                                            <a class="timeline-panel" href="javascript:void(0);">
                                                                <div class="text-2 fw-6">Order Placed</div>
                                                                <span>{{ $order->created_at->format('d/m/Y g:ia') }}</span>
                                                            </a>
                                                            <p><strong>Order Number:</strong> #ORD-{{ $order->id }}</p>
                                                            @if($order->source)
                                                                <p><strong>Source:</strong> {{ $order->source }}</p>
                                                            @endif
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Tab 2: Item Details -->
                                        <div class="widget-content-inner">
                                            @foreach($order->items as $item)
                                                <div class="order-head {{ !$loop->first ? 'mt-4 pt-4 border-top' : '' }}">
                                                    <figure class="img-product">
                                                        @if($item->product)
                                                            <img src="{{ $item->product->getFirstMediaUrl('product_thumbnail') ?: asset('website/images/default-product.jpg') }}"
                                                                 alt="{{ $item->product->name }}">
                                                        @else
                                                            <img src="{{ asset('website/images/default-product.jpg') }}" alt="Product">
                                                        @endif
                                                    </figure>
                                                    <div class="content">
                                                        <div class="text-2 fw-6">{{ $item->product?->name ?? 'Product Not Available' }}</div>
                                                        <div class="mt_4"><span class="fw-6">Price:</span> {{ number_format($item->price, 2) }} EGP</div>
                                                        <div class="mt_4"><span class="fw-6">Quantity:</span> {{ $item->qty }}</div>
                                                        @if($item->variant)
                                                            <div class="mt_4"><span class="fw-6">Variant:</span> {{ $item->variant->name }}</div>
                                                        @endif
                                                        @if($item->is_returned)
                                                            <span class="mt-2 badge bg-warning">Returned</span>
                                                        @endif
                                                        @if($item->is_refunded)
                                                            <span class="mt-2 badge bg-info">Refunded</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach

                                            <ul class="mt-4">
                                                <li class="d-flex justify-content-between text-2">
                                                    <span>Subtotal</span>
                                                    <span class="fw-6">{{ number_format($order->subtotal_amount, 2) }} EGP</span>
                                                </li>
                                                @if($order->discount_amount > 0)
                                                    <li class="d-flex justify-content-between text-2 mt_4 pb_8 line-bt">
                                                        <span>Total Discounts</span>
                                                        <span class="fw-6">-{{ number_format($order->discount_amount, 2) }} EGP</span>
                                                    </li>
                                                @endif
                                                @if($order->shipping_fee > 0)
                                                    <li class="d-flex justify-content-between text-2 mt_4">
                                                        <span>Shipping Fee</span>
                                                        <span class="fw-6">{{ number_format($order->shipping_fee, 2) }} EGP</span>
                                                    </li>
                                                @endif
                                                @if($order->cod_fee > 0)
                                                    <li class="d-flex justify-content-between text-2 mt_4">
                                                        <span>COD Fee</span>
                                                        <span class="fw-6">{{ number_format($order->cod_fee, 2) }} EGP</span>
                                                    </li>
                                                @endif
                                                <li class="pt-3 d-flex justify-content-between text-2 mt_8 border-top">
                                                    <span class="fw-bold">Order Total</span>
                                                    <span class="mb-0 fw-6 h5">{{ number_format($order->total_amount, 2) }} EGP</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Tab 3: Shipping Info -->
                                        <div class="widget-content-inner">
                                            <p class="mb-3">Track your order delivery status and shipping information.</p>

                                            @if($order->shipping_fee)
                                                <p><strong>Shipping Fee:</strong> {{ number_format($order->shipping_fee, 2) }} EGP</p>
                                            @endif

                                            @if($order->orderStatus)
                                                <p><strong>Current Status:</strong> {{ $order->orderStatus->name }}</p>
                                            @endif

                                            @if($order->is_done)
                                                <p class="text-success"><strong>✓ Delivered on:</strong> {{ $order->updated_at->format('d F Y, h:i A') }}</p>
                                            @elseif($order->is_canceled)
                                                <p class="text-danger"><strong>✗ Order Cancelled</strong></p>
                                            @else
                                                <p><strong>Expected Delivery:</strong> Within 3-5 business days</p>
                                            @endif

                                            @if($order->client_notes)
                                                <div class="mt-4">
                                                    <p class="fw-bold">Customer Notes:</p>
                                                    <p class="text-muted">{{ $order->client_notes }}</p>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Tab 4: Receiver -->
                                        <div class="widget-content-inner">
                                            <p class="text-2 {{ $order->is_paid ? 'text-success' : 'text-warning' }} mb-3">
                                                {{ $order->is_paid ? '✓ Payment Confirmed' : '⚠ Payment Pending' }}
                                            </p>

                                            @if($order->address)
                                                <div class="mb-4">
                                                    <h6 class="mb-3 fw-bold">Delivery Address</h6>
                                                    <p class="mb-1"><strong>{{ $order->address->label ?? 'Delivery Address' }}</strong></p>
                                                    <p class="mb-1">{{ $order->address->street }}, Building {{ $order->address->building }}</p>
                                                    <p class="mb-1">Floor {{ $order->address->floor }}, Apartment {{ $order->address->apartment }}</p>
                                                    <p class="mb-1">
                                                        {{ $order->address->district->districtName ?? '' }},
                                                        {{ $order->address->district->zone->zoneName ?? '' }}
                                                    </p>
                                                    <p class="mb-1">
                                                        {{ $order->address->district->zone->city->cityName ?? '' }}
                                                        @if($order->address->zip_code)
                                                            - {{ $order->address->zip_code }}
                                                        @endif
                                                    </p>
                                                    @if($order->address->phone)
                                                        <p class="mt-3"><strong>Phone:</strong> {{ $order->address->phone }}</p>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="mt-4">
                                                <h6 class="mb-2 fw-bold">Order Summary</h6>
                                                <p class="mb-1"><strong>Order Number:</strong> #ORD-{{ $order->id }}</p>
                                                <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('d/m/Y, h:ia') }}</p>
                                                <p class="mb-1"><strong>Total:</strong> {{ number_format($order->total_amount, 2) }} EGP</p>
                                                <p class="mb-1"><strong>Payment Method:</strong> {{ $order->paymentMethod?->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /order details -->

        <div class="offcanvas offcanvas-start canvas-sidebar" id="mbAccount">
            <div class="canvas-wrapper">
                <header class="canvas-header">
                    <span class="text-btn-uppercase">SIDEBAR ACCOUNT</span>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
                </header>
                <div class="canvas-body sidebar-mobile-append"></div>
            </div>
        </div>

        @include('website.main.footer')
    </div>
    @include('website.pages.home.cartModal')

    @include('website.main.scripts')
</body>
</html>

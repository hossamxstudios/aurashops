<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - My Orders</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="My Orders - Aura Beauty Care">
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
                        <h3 class="text-center heading">My Orders</h3>
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
                                Orders
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

        <!-- orders -->
        <section class="flat-spacing">
            <div class="container">
                <div class="my-account-wrap">
                    @include('website.client.partials.sidebar')

                    <div class="my-account-content">
                        <div class="account-orders">
                            <div class="mb-5 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 title">Your Orders</h5>
                                <div class="gap-2 d-flex align-items-center">
                                    <span class="fw-semibold">{{ $orders->total() }} {{ $orders->total() == 1 ? 'Order' : 'Orders' }}</span>
                                </div>
                            </div>

                            @if($orders->count() > 0)
                                <div class="orders-list">
                                    @foreach($orders as $order)
                                        <div class="mb-4 card order-card">
                                            <div class="p-4 card-body">
                                                {{-- Order Header --}}
                                                <div class="flex-wrap pb-4 mb-4 order-header border-bottom d-flex justify-content-between align-items-start">
                                                    <div class="order-info">
                                                        <h6 class="mb-2 fw-bold">#ORD-{{ $order->id }}</h6>
                                                        <div class="gap-2 mb-1 d-flex align-items-center">
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                            <span class="text-secondary">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
                                                        </div>
                                                        <div class="gap-2 d-flex align-items-center">
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M21 16V8C21 6.89543 20.1046 6 19 6H5C3.89543 6 3 6.89543 3 8V16C3 17.1046 3.89543 18 5 18H19C20.1046 18 21 17.1046 21 16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                            <span class="text-secondary">{{ $order->items_count }} {{ $order->items_count == 1 ? 'Item' : 'Items' }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 order-status mt-md-0">
                                                        @php
                                                            $statusName = $order->orderStatus?->name ?? 'Pending';
                                                            $badgeClass = 'bg-secondary';

                                                            if($order->is_done) {
                                                                $badgeClass = 'bg-success';
                                                            } elseif($order->is_canceled) {
                                                                $badgeClass = 'bg-danger';
                                                            } elseif(stripos($statusName, 'shipped') !== false || stripos($statusName, 'transit') !== false) {
                                                                $badgeClass = 'bg-info';
                                                            } elseif(stripos($statusName, 'processing') !== false) {
                                                                $badgeClass = 'bg-warning';
                                                            }
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }} px-3 py-2">
                                                            {{ $order->is_canceled ? 'Cancelled' : ($order->is_done ? 'Delivered' : $statusName) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                {{-- Order Items Preview --}}
                                                <div class="pb-4 mb-4 order-items border-bottom">
                                                    <div class="row g-3">
                                                        @foreach($order->items->take(4) as $item)
                                                            <div class="col-3 col-md-2">
                                                                <div class="position-relative item-preview">
                                                                    @if($item->product)
                                                                        <img src="{{ $item->product->getFirstMediaUrl('product_thumbnail') ?: asset('website/images/default-product.jpg') }}"
                                                                             alt="{{ $item->product->name }}"
                                                                             class="img-fluid"
                                                                             style="aspect-ratio: 1; object-fit: cover; border-radius: 8px;">
                                                                    @else
                                                                        <div class="d-flex align-items-center justify-content-center bg-light" style="aspect-ratio: 1; border-radius: 8px;">
                                                                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <rect x="3" y="3" width="18" height="18" rx="2" stroke="#ccc" stroke-width="2"/>
                                                                                <line x1="3" y1="21" x2="21" y2="3" stroke="#ccc" stroke-width="2"/>
                                                                            </svg>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @if($order->items_count > 4)
                                                            <div class="col-3 col-md-2">
                                                                <div class="d-flex align-items-center justify-content-center bg-light" style="aspect-ratio: 1; border-radius: 8px;">
                                                                    <span class="fw-bold fs-5">+{{ $order->items_count - 4 }}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Order Footer --}}
                                                <div class="flex-wrap order-footer d-flex justify-content-between align-items-center">
                                                    <div class="order-total">
                                                        <div class="mb-2">
                                                            <span class="text-secondary">Total Amount</span>
                                                            <h5 class="mb-2 fw-bold">{{ number_format($order->total_amount, 2) }} EGP</h5>
                                                        </div>
                                                        <div class="gap-2 d-flex">
                                                            @if($order->is_paid)
                                                                <span class="px-2 py-1 badge bg-success">✓ Paid</span>
                                                            @else
                                                                <span class="px-2 py-1 badge bg-warning">Unpaid</span>
                                                            @endif
                                                            @if($order->is_cod)
                                                                <span class="px-2 py-1 badge bg-dark">COD</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 order-actions mt-md-0">
                                                        <div class="flex-wrap gap-2 d-flex">
                                                            <a href="{{ route('client.orders.show', $order->id) }}" class="tf-btn btn-outline">
                                                                <span class="text">View Details</span>
                                                            </a>
                                                            @if(!$order->is_canceled && !$order->is_done)
                                                                <a href="#" class="tf-btn btn-fill">
                                                                    <span class="text">Track Order</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Delivery Address Info --}}
                                                @if($order->address)
                                                    <div class="pt-4 mt-4 border-top">
                                                        <div class="gap-2 d-flex align-items-start">
                                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mt-1">
                                                                <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="currentColor" stroke-width="2"/>
                                                                <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/>
                                                            </svg>
                                                            <div>
                                                                <span class="fw-semibold">Delivery to:</span>
                                                                <span class="text-secondary">
                                                                    {{ $order->address->district->zone->city->cityName ?? '' }},
                                                                    {{ $order->address->district->zone->zoneName ?? '' }},
                                                                    {{ $order->address->district->districtName ?? '' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Pagination --}}
                                <div class="mt-5 pagination-wrapper">
                                    {{ $orders->links() }}
                                </div>
                            @else
                                <div class="py-5 text-center empty-orders">
                                    <div class="mb-4">
                                        <svg width="120" height="120" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto">
                                            <path d="M16.5078 10.8734V6.36686C16.5078 5.17166 16.033 4.02541 15.1879 3.18028C14.3428 2.33514 13.1965 1.86035 12.0013 1.86035C10.8061 1.86035 9.65985 2.33514 8.81472 3.18028C7.96958 4.02541 7.49479 5.17166 7.49479 6.36686V10.8734M4.11491 8.62012H19.8877L21.0143 22.1396H2.98828L4.11491 8.62012Z" stroke="#e5e5e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <h5 class="mb-3">No Orders Yet</h5>
                                    <p class="mb-4 text-secondary">You haven't placed any orders yet.<br>Start shopping to see your orders here!</p>
                                    <a href="{{ route('home') }}" class="tf-btn btn-fill animate-hover-btn">
                                        <span class="text">Start Shopping Now</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /orders -->
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

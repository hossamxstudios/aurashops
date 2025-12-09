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
                            <h5 class="mb-4 title">Your Orders</h5>

                            @if($orders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>#{{ $order->id }}</td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td>${{ number_format($order->total, 2) }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{ $orders->links() }}
                            @else
                                <div class="py-5 text-center">
                                    <svg width="100" height="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-3">
                                        <path d="M16.5078 10.8734V6.36686C16.5078 5.17166 16.033 4.02541 15.1879 3.18028C14.3428 2.33514 13.1965 1.86035 12.0013 1.86035C10.8061 1.86035 9.65985 2.33514 8.81472 3.18028C7.96958 4.02541 7.49479 5.17166 7.49479 6.36686V10.8734M4.11491 8.62012H19.8877L21.0143 22.1396H2.98828L4.11491 8.62012Z" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <h6>No Orders Yet</h6>
                                    <p class="text-secondary">Start shopping to see your orders here!</p>
                                    <a href="{{ route('home') }}" class="mt-3 tf-btn btn-fill">
                                        <span class="text text-button">Start Shopping</span>
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

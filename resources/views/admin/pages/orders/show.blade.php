<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Order #{{ $order->id }}</title>
    <style>
        .order-timeline {
            position: relative;
            padding-left: 30px;
        }
        .order-timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -24px;
            top: 4px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #0d6efd;
        }
        .timeline-item:last-child {
            padding-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="m-0 breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                                        <li class="breadcrumb-item active">Order #{{ $order->id }}</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">
                                    <i class="ti ti-receipt me-2"></i>
                                    Order #{{ $order->id }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ti ti-check me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="ti ti-alert-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-8">
                            <!-- Order Items -->
                            @include('admin.pages.orders.sections.items')
                            <!-- Order History -->
                            @include('admin.pages.orders.sections.history')
                            <!-- Payments -->
                            @include('admin.pages.orders.sections.payments')
                            <!-- Shipping Info -->
                            @include('admin.pages.orders.sections.shipping')
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-4">
                            <!-- Order Info -->
                            @include('admin.pages.orders.sections.info')

                            <!-- Order Summary -->
                            @include('admin.pages.orders.sections.summary')

                            <!-- Client Info -->
                            @include('admin.pages.orders.sections.client')

                            <!-- Address Info -->
                            @include('admin.pages.orders.sections.address')

                            <!-- Admin Notes -->
                            @include('admin.pages.orders.sections.notes')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')

    <!-- Modals -->
    @include('admin.pages.orders.modals.update-status')
    @include('admin.pages.orders.modals.add-payment')
</body>
</html>

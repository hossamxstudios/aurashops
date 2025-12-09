<!DOCTYPE html>
@include('admin.main.html')

<head>
    <title> Aura - Dashboard</title>
    @include('admin.main.meta')
</head>

<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="container-fluid">

                {{-- Welcome Section --}}
                <div class="py-4 mb-2 row justify-content-center">
                    <div class="text-center col-xxl-5 col-xl-7">
                        <span class="px-3 py-2 mb-3 shadow-sm badge bg-dark-subtle text-dark fw-semibold fs-xs">
                            <i data-lucide="store" class="fs-sm me-1"></i> E-Commerce Analytics Dashboard
                        </span>
                        <h3 class="mb-2 fw-bold">
                            Welcome Back! 👋
                        </h3>
                        <p class="mb-0 fs-sm text-muted">
                            Real-time insights and analytics for your store performance
                        </p>
                    </div>
                </div>

                {{-- Key Metrics Cards --}}
                <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1">
                    {{-- Today's Sales Widget --}}
                    <div class="col">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <div class="mb-3 d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="text-uppercase">Today's Sales</h5>
                                    </div>
                                    <div>
                                        <i data-lucide="trending-up" class="text-muted fs-24 svg-sw-10"></i>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <canvas id="salesChart" height="60"></canvas>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="text-muted">Today</span>
                                        <div class="fw-semibold">{{ number_format($todaySales, 2) }} EGP</div>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-muted">Yesterday</span>
                                        <div class="fw-semibold">
                                            {{ number_format($yesterdaySales, 2) }} EGP
                                            @if($salesGrowth > 0)
                                                <i class="ti ti-arrow-up text-dark"></i>
                                            @elseif($salesGrowth < 0)
                                                <i class="ti ti-arrow-down text-danger"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center card-footer text-muted">
                                Revenue
                                @if($salesGrowth > 0)
                                    <strong class="text-dark">increased by {{ abs($salesGrowth) }}%</strong>
                                @elseif($salesGrowth < 0)
                                    <strong class="text-danger">decreased by {{ abs($salesGrowth) }}%</strong>
                                @else
                                    <strong>unchanged</strong>
                                @endif
                                today
                            </div>
                        </div>
                    </div>

                    {{-- Total Orders Widget --}}
                    <div class="col">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-3 text-uppercase">Total Orders</h5>
                                        <h3 class="mb-0 fw-normal">{{ $todayOrders }}</h3>
                                        <p class="mb-2 text-muted">In the last 24 hours</p>
                                    </div>
                                    <div>
                                        <i data-lucide="shopping-bag" class="text-muted fs-24 svg-sw-10"></i>
                                    </div>
                                </div>

                                @php
                                    $completionRate = $todayOrders > 0 ? ($completedOrders / $todayOrders) * 100 : 0;
                                @endphp

                                <div class="mb-3 progress progress-lg">
                                    <div class="progress-bar bg-dark" style="width: {{ $completionRate }}%;" role="progressbar"></div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="text-muted">Completed</span>
                                        <h5 class="mb-0 text-dark">{{ $completedOrders }}</h5>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-muted">Pending</span>
                                        <h5 class="mb-0 text-secondary">{{ $pendingOrders }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center card-footer text-muted">
                                {{ round($completionRate, 1) }}% completion rate
                            </div>
                        </div>
                    </div>

                    {{-- Active Customers Widget --}}
                    <div class="col">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <div class="mb-3 d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="text-uppercase">Active Customers</h5>
                                    </div>
                                    <div>
                                        <i data-lucide="users" class="text-muted fs-24 svg-sw-10"></i>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-center">
                                    <canvas id="customersChart" height="180" width="180" style="height: 180px; width: 180px!important;"></canvas>
                                </div>
                            </div>
                            <div class="text-center card-footer text-muted">
                                Total customers: <strong>{{ number_format($totalCustomers) }}</strong> |
                                Returning: <strong>{{ $returningRate }}%</strong>
                            </div>
                        </div>
                    </div>

                    {{-- Low Stock Alerts Widget --}}
                    <div class="col">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <div class="mb-3 d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="text-uppercase">Stock Status</h5>
                                    </div>
                                    <div>
                                        <i data-lucide="package" class="text-muted fs-24 svg-sw-10"></i>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <canvas id="stockChart" height="60"></canvas>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="text-muted">Low Stock</span>
                                        <div class="fw-semibold text-secondary">{{ $lowStockCount }} products</div>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-muted">Out of Stock</span>
                                        <div class="fw-semibold text-danger">{{ $outOfStockCount }} items</div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center card-footer text-muted">
                                <a href="{{ route('admin.stocks.index') }}" class="text-decoration-underline">View Stock Management</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Business Health Metrics Row --}}
                <div class="mb-3 row">
                    {{-- Monthly Growth --}}
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="mb-3 card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div class="rounded avatar-title bg-dark-subtle text-dark">
                                                <i data-lucide="trending-up" class="fs-22"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 text-muted fs-xs">Monthly Growth</p>
                                        <h4 class="mb-0">
                                            <span class="{{ $monthlyGrowthRate >= 0 ? 'text-dark' : 'text-danger' }}">
                                                {{ $monthlyGrowthRate > 0 ? '+' : '' }}{{ $monthlyGrowthRate }}%
                                            </span>
                                        </h4>
                                        <p class="mb-0 text-muted fs-xxs">
                                            {{ number_format(abs($thisMonthRevenue - $lastMonthRevenue), 0) }} EGP vs last month
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Customer Lifetime Value --}}
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="mb-3 card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div class="rounded avatar-title bg-dark-subtle text-dark">
                                                <i data-lucide="user-check" class="fs-22"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 text-muted fs-xs">Avg. Customer Value</p>
                                        <h4 class="mb-0">{{ number_format($avgCustomerLifetimeValue, 0) }} EGP</h4>
                                        <p class="mb-0 text-muted fs-xxs">
                                            Repeat rate: {{ $repeatPurchaseRate }}%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Average Basket Size --}}
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="mb-3 card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div class="rounded avatar-title bg-secondary-subtle text-secondary">
                                                <i data-lucide="shopping-cart" class="fs-22"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 text-muted fs-xs">Avg. Basket Size</p>
                                        <h4 class="mb-0">{{ round($avgBasketSize, 1) }} items</h4>
                                        <p class="mb-0 text-muted fs-xxs">
                                            Per order this month
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Inventory Turnover --}}
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="mb-3 card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div class="rounded avatar-title bg-secondary-subtle text-secondary">
                                                <i data-lucide="repeat" class="fs-22"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 text-muted fs-xs">Inventory Turnover</p>
                                        <h4 class="mb-0">{{ $inventoryTurnover }}x</h4>
                                        <p class="mb-0 text-muted fs-xxs">
                                            Return rate: {{ $returnRate }}%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <hr class="my-4">

                {{-- Sales Overview Chart --}}
                <div class="row">
                    <div class="col-12">
                        <div class="shadow-sm card">
                            <div class="bg-transparent border-0 card-header">
                                <h4 class="mb-0 card-title">
                                    <i data-lucide="bar-chart-3" class="me-2"></i>Sales Overview
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    {{-- Total Revenue --}}
                                    <div class="col-xl-3 col-md-6">
                                        <div class="text-center">
                                            <p class="mb-4"><i data-lucide="dollar-sign"></i> Total Revenue</p>
                                            <h2 class="mb-0 fw-bold">{{ number_format($monthlyRevenue, 0) }} EGP</h2>
                                            <p class="text-muted">Total revenue in last 30 days</p>
                                            <p class="mt-4 mb-0"><i data-lucide="calendar"></i> {{ now()->format('F Y') }}</p>
                                        </div>
                                    </div>

                                    {{-- Average Order Value --}}
                                    <div class="col-xl-3 col-md-6 order-xl-last">
                                        <div class="text-center">
                                            <p class="mb-4"><i data-lucide="shopping-cart"></i> Avg. Order Value</p>
                                            <h2 class="mb-0 fw-bold">{{ number_format($avgOrderValue, 0) }} EGP</h2>
                                            <p class="text-muted">Per order this month</p>
                                            <p class="mt-4 mb-0">
                                                <i data-lucide="package"></i> {{ $totalProductsInStock }} products in stock
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Revenue Chart --}}
                                    <div class="col-xl-6">
                                        <div class="w-100" style="height: 240px;">
                                            <canvas id="revenueChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="d-flex align-items-center text-muted justify-content-between">
                                    <div>
                                        Last update: {{ now()->format('d.m.Y H:i') }}
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.orders.index') }}" class="text-decoration-underline">View All Orders</a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                {{-- Sales by Day of Week Chart --}}
                <div class="row">
                    <div class="col-12">
                        <div class="shadow-sm card">
                            <div class="bg-transparent border-0 card-header">
                                <h4 class="mb-1 card-title">
                                    <i data-lucide="calendar" class="me-2"></i>Sales by Day of Week
                                </h4>
                                <p class="mb-0 text-muted fs-sm">Revenue and orders breakdown by weekday (Last 30 days)</p>
                            </div>
                            <div class="card-body">
                                <canvas id="salesByDayChart" height="280"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <hr class="my-4">

                {{-- Section Header --}}
                <div class="mb-3 row">
                    <div class="col-12">
                        <h4 class="mb-1 fw-semibold">
                            <i data-lucide="database" class="me-2"></i>Detailed Reports & Tables
                        </h4>
                        <p class="mb-0 text-muted fs-sm">Orders, products, customers and performance data</p>
                    </div>
                </div>

                {{-- Recent Orders & Top Products --}}
                <div class="row">
                    {{-- Recent Orders --}}
                    <div class="col-xxl-6">
                        <div class="shadow-sm card">
                            <div class="border-dashed card-header justify-content-between align-items-center">
                                <h4 class="mb-0 card-title"><i data-lucide="shopping-bag" class="me-2 fs-18"></i>Recent Orders</h4>
                                <div class="gap-2 d-flex">
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light">
                                        <i class="ti ti-eye me-1"></i> View All
                                    </a>
                                    <a href="{{ route('admin.pos.index') }}" class="btn btn-sm btn-primary">
                                        <i class="ti ti-plus me-1"></i> New Order
                                    </a>
                                </div>
                            </div>

                            <div class="p-0 card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-centered table-custom table-sm table-nowrap table-hover">
                                        <tbody>
                                            @forelse($recentOrders as $order)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm rounded-circle bg-dark-subtle text-dark d-flex align-items-center justify-content-center me-2">
                                                            <i data-lucide="shopping-bag" class="fs-lg"></i>
                                                        </div>
                                                        <div>
                                                            <span class="text-muted fs-xs">Order ID</span>
                                                            <h5 class="mb-0 fs-base">
                                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-body">#ORD-{{ $order->id }}</a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-xs">Customer</span>
                                                    <h5 class="mb-0 fs-base fw-normal">
                                                        {{ $order->client ? $order->client->first_name . ' ' . $order->client->last_name : 'Guest' }}
                                                    </h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-xs">Date</span>
                                                    <h5 class="mb-0 fs-base fw-normal">{{ $order->created_at->format('Y-m-d') }}</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-xs">Amount</span>
                                                    <h5 class="mb-0 fs-base fw-normal">{{ number_format($order->total_amount, 0) }} EGP</h5>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-xs">Status</span>
                                                    <h5 class="mb-0 fs-base fw-normal">
                                                        @if($order->is_done)
                                                            <span class="badge bg-dark-subtle text-dark">Completed</span>
                                                        @elseif($order->is_canceled)
                                                            <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                                                        @else
                                                            <span class="badge bg-secondary-subtle text-secondary">
                                                                {{ $order->orderStatus?->name ?? 'Pending' }}
                                                            </span>
                                                        @endif
                                                    </h5>
                                                </td>
                                                <td style="width: 30px;">
                                                    <div class="dropdown">
                                                        <a href="#" class="p-0 dropdown-toggle text-muted drop-arrow-none card-drop" data-bs-toggle="dropdown">
                                                            <i class="ti ti-dots-vertical fs-lg"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="dropdown-item">View Details</a>
                                                            <a href="#" class="dropdown-item">Update Status</a>
                                                            <a href="#" class="dropdown-item">Print Invoice</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="py-4 text-center">
                                                    <p class="mb-0 text-muted">No orders found</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="border-0 card-footer">
                                <div class="text-center">
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                                        View All Orders <i class="ti ti-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Statistics & Top Products --}}
                    <div class="col-xxl-6">
                        {{-- Top Selling Products --}}
                        <div class="shadow-sm card">
                            <div class="border-dashed card-header">
                                <h4 class="mb-0 card-title"><i data-lucide="trending-up" class="me-2 fs-18"></i>Top Selling Products</h4>
                            </div>

                            <div class="p-0 card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm table-centered table-custom table-nowrap">
                                        <thead class="bg-light-subtle thead-sm">
                                            <tr class="text-uppercase fs-xxs">
                                                <th>Product</th>
                                                <th>Category</th>
                                                <th>Sold</th>
                                                <th>Revenue</th>
                                                <th>Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($topSellingProducts as $product)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded avatar-sm me-2 bg-light d-flex align-items-center justify-content-center">
                                                            <i data-lucide="box" class="text-muted"></i>
                                                        </div>
                                                        <span>{{ Str::limit($product->name, 25) }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $product->category_name }}</td>
                                                <td><span class="badge bg-dark-subtle text-dark">{{ $product->total_sold }} units</span></td>
                                                <td>{{ number_format($product->total_revenue, 0) }} EGP</td>
                                                <td>
                                                    @if($product->stock_status == 'in_stock')
                                                        <span class="badge bg-dark-subtle text-dark">In Stock</span>
                                                    @elseif($product->stock_status == 'low_stock')
                                                        <span class="badge bg-secondary-subtle text-secondary">Low Stock</span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger">Out of Stock</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="py-4 text-center">
                                                    <p class="mb-0 text-muted">No products sold yet</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer border-top-0 text-end">
                                <a href="{{ route('admin.products.index') }}" class="text-decoration-underline">View All Products</a>
                            </div>
                        </div>

                        {{-- Order Statistics --}}
                        <div class="card">
                            <div class="border-dashed card-header">
                                <h4 class="mb-0 card-title">Order Statistics</h4>
                            </div>

                            <div class="p-0 card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm table-centered table-nowrap table-custom">
                                        <thead class="bg-light-subtle thead-sm">
                                            <tr class="text-uppercase fs-xxs">
                                                <th>Status</th>
                                                <th>Count</th>
                                                <th>Percentage</th>
                                                <th>Total Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalOrdersForStats = $ordersByStatus->sum('count');
                                            @endphp

                                            @forelse($ordersByStatus as $statusGroup)
                                                @php
                                                    $percentage = $totalOrdersForStats > 0 ? ($statusGroup->count / $totalOrdersForStats) * 100 : 0;
                                                    $statusName = $statusGroup->orderStatus?->name ?? 'Unknown';

                                                    // Determine badge color based on status
                                                    if(stripos($statusName, 'complete') !== false || stripos($statusName, 'delivered') !== false) {
                                                        $badgeClass = 'bg-dark-subtle text-dark';
                                                        $progressColor = 'bg-dark';
                                                    } elseif(stripos($statusName, 'cancel') !== false || stripos($statusName, 'reject') !== false) {
                                                        $badgeClass = 'bg-danger-subtle text-danger';
                                                        $progressColor = 'bg-danger';
                                                    } elseif(stripos($statusName, 'pending') !== false || stripos($statusName, 'wait') !== false) {
                                                        $badgeClass = 'bg-secondary-subtle text-secondary';
                                                        $progressColor = 'bg-secondary';
                                                    } else {
                                                        $badgeClass = 'bg-secondary-subtle text-secondary';
                                                        $progressColor = 'bg-secondary';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td><span class="badge {{ $badgeClass }}">{{ $statusName }}</span></td>
                                                    <td>{{ $statusGroup->count }}</td>
                                                    <td>
                                                        <div class="progress progress-sm">
                                                            <div class="progress-bar {{ $progressColor }}" style="width: {{ round($percentage, 1) }}%"></div>
                                                        </div>
                                                    </td>
                                                    <td>{{ number_format($statusGroup->total_value, 0) }} EGP</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="py-4 text-center">
                                                        <p class="mb-0 text-muted">No order data available</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer border-top-0 text-end">
                                <span class="text-muted">Updated {{ now()->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <hr class="my-4">

                {{-- Section Header --}}
                <div class="mb-3 row">
                    <div class="col-12">
                        <h4 class="mb-1 fw-semibold">
                            <i data-lucide="pie-chart" class="me-2"></i>Revenue Analytics
                        </h4>
                        <p class="mb-0 text-muted fs-sm">Breakdown by categories and brands</p>
                    </div>
                </div>

                {{-- Revenue Analytics Row --}}
                <div class="row">
                    {{-- Revenue by Category --}}
                    <div class="col-xl-6">
                        <div class="shadow-sm card">
                            <div class="border-dashed card-header">
                                <h4 class="mb-0 card-title">Revenue by Category</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="categoryRevenueChart" height="300"></canvas>
                            </div>
                            <div class="card-footer border-top-0">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm">
                                        <tbody>
                                            @forelse($revenueByCategory as $category)
                                            <tr>
                                                <td>{{ $category->name }}</td>
                                                <td class="text-end">{{ number_format($category->revenue, 0) }} EGP</td>
                                                <td class="text-end text-muted">{{ $category->total_sold }} sold</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="3" class="text-center text-muted">No data</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Revenue by Brand --}}
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="border-dashed card-header">
                                <h4 class="mb-0 card-title">Revenue by Brand</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="brandRevenueChart" height="300"></canvas>
                            </div>
                            <div class="card-footer border-top-0">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm">
                                        <tbody>
                                            @forelse($revenueByBrand as $brand)
                                            <tr>
                                                <td>{{ $brand->name }}</td>
                                                <td class="text-end">{{ number_format($brand->revenue, 0) }} EGP</td>
                                                <td class="text-end text-muted">{{ $brand->total_sold }} sold</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="3" class="text-center text-muted">No data</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Top Customers & Low Performing Products --}}
                <div class="row">
                    {{-- Top Customers --}}
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="border-dashed card-header">
                                <h4 class="mb-0 card-title">🏆 Top Customers</h4>
                            </div>
                            <div class="p-0 card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm table-centered table-nowrap">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th>Customer</th>
                                                <th>Orders</th>
                                                <th>Lifetime Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($topCustomers as $customer)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="text-white avatar-xs rounded-circle bg-dark d-flex align-items-center justify-content-center me-2">
                                                            {{ strtoupper(substr($customer->first_name, 0, 1)) }}
                                                        </div>
                                                        <span>{{ $customer->first_name }} {{ $customer->last_name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $customer->total_orders }} orders</td>
                                                <td class="fw-semibold">{{ number_format($customer->lifetime_value, 0) }} EGP</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="3" class="py-3 text-center text-muted">No customer data</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Low Performing Products --}}
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="border-dashed card-header">
                                <h4 class="mb-0 card-title">⚠️ Low Performing Products</h4>
                            </div>
                            <div class="p-0 card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm table-centered table-nowrap">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th>Product</th>
                                                <th>Stock</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($lowPerformingProducts as $product)
                                            <tr>
                                                <td>{{ Str::limit($product->name, 30) }}</td>
                                                <td><span class="badge bg-secondary-subtle text-secondary">Low Performance</span></td>
                                                <td>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-soft-dark">
                                                        Promote
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="3" class="py-3 text-center text-muted">All products performing well!</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer border-top-0 text-muted fs-xs">
                                Products with less than 3 sales in 30 days
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sales Insights --}}
                <div class="row">

                    {{-- Geographic Distribution --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="shadow-sm card">
                                <div class="bg-transparent border-0 card-header">
                                    <h4 class="mb-1 card-title">
                                        <i data-lucide="map-pin" class="me-2"></i>Top Cities by Revenue
                                    </h4>
                                    <p class="mb-0 text-muted fs-sm">Geographic distribution of sales</p>
                                </div>
                                <div class="p-0 card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-centered">
                                            <thead class="bg-light-subtle">
                                                <tr>
                                                    <th>City</th>
                                                    <th>Orders</th>
                                                    <th>Revenue</th>
                                                    <th>Avg. Order</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($salesByCity as $city)
                                                <tr>
                                                    <td class="fw-semibold">{{ $city->name }}</td>
                                                    <td>{{ $city->total_orders }}</td>
                                                    <td>{{ number_format($city->total_revenue, 0) }} EGP</td>
                                                    <td>{{ number_format($city->total_revenue / $city->total_orders, 0) }} EGP</td>
                                                </tr>
                                                @empty
                                                <tr><td colspan="4" class="py-3 text-center text-muted">No city data</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Peak Hours & Coupon Performance --}}
                <div class="row">
                    {{-- Peak Sales Hours --}}
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="border-dashed card-header">
                                <h4 class="mb-0 card-title">⏰ Peak Sales Hours</h4>
                            </div>
                            <div class="p-0 card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-centered">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th>Time</th>
                                                <th>Orders</th>
                                                <th>Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($peakSalesHours as $hour)
                                            <tr>
                                                <td class="fw-semibold">{{ $hour->hour }}:00 - {{ $hour->hour + 1 }}:00</td>
                                                <td>{{ $hour->orders }} orders</td>
                                                <td>{{ number_format($hour->revenue, 0) }} EGP</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="3" class="py-3 text-center text-muted">No data</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer border-top-0 text-muted fs-xs">
                                Last 7 days data
                            </div>
                        </div>
                    </div>

                    {{-- Coupon Performance --}}
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="border-dashed card-header">
                                <h4 class="mb-0 card-title">🎟️ Coupon Performance</h4>
                            </div>
                            <div class="card-body">
                                @if($couponStats && $couponStats->usage_count > 0)
                                <div class="text-center row">
                                    <div class="col-4">
                                        <div class="mb-2">
                                            <h3 class="mb-0">{{ $couponStats->usage_count }}</h3>
                                            <p class="mb-0 text-muted">Uses</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-2">
                                            <h3 class="mb-0">{{ number_format($couponStats->total_discount, 0) }}</h3>
                                            <p class="mb-0 text-muted">Total Discount (EGP)</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-2">
                                            <h3 class="mb-0">{{ number_format($couponStats->total_revenue, 0) }}</h3>
                                            <p class="mb-0 text-muted">Revenue (EGP)</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span class="text-muted">Avg. Discount per Order:</span>
                                        <span class="fw-semibold">{{ number_format($couponStats->total_discount / $couponStats->usage_count, 0) }} EGP</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Discount Rate:</span>
                                        <span class="fw-semibold">{{ round(($couponStats->total_discount / ($couponStats->total_revenue + $couponStats->total_discount)) * 100, 1) }}%</span>
                                    </div>
                                </div>
                                @else
                                <div class="py-4 text-center">
                                    <i data-lucide="tag" class="mb-3 fs-48 text-muted"></i>
                                    <p class="mb-0 text-muted">No coupon usage in last 30 days</p>
                                </div>
                                @endif
                            </div>
                            <div class="card-footer border-top-0">
                                <a href="{{ route('admin.coupons.index') }}" class="text-decoration-underline">Manage Coupons</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @include('admin.main.footer')
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')

    <script>
        // Pass PHP data to JavaScript
        const chartData = @json($chartData);

        document.addEventListener('DOMContentLoaded', function() {
            // Sales Chart (Last 7 Days)
            const salesCtx = document.getElementById('salesChart');
            if (salesCtx && chartData.sales) {
                new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: chartData.sales.labels.length > 0 ? chartData.sales.labels : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        datasets: [{
                            data: chartData.sales.data.length > 0 ? chartData.sales.data : [0, 0, 0, 0, 0, 0, 0],
                            borderColor: 'rgb(99, 102, 241)',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            tension: 0.4,
                            fill: true,
                            borderWidth: 2,
                            pointRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { display: false },
                            y: { display: false }
                        }
                    }
                });
            }

            // Stock Chart (Low Stock Trend)
            const stockCtx = document.getElementById('stockChart');
            if (stockCtx && chartData.stock) {
                new Chart(stockCtx, {
                    type: 'bar',
                    data: {
                        labels: chartData.stock.labels.length > 0 ? chartData.stock.labels : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                        datasets: [{
                            data: chartData.stock.data.length > 0 ? chartData.stock.data : [0, 0, 0, 0, 0, 0],
                            backgroundColor: 'rgba(239, 68, 68, 0.8)',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { display: false },
                            y: { display: false }
                        }
                    }
                });
            }

            // Customers Doughnut Chart
            const customersCtx = document.getElementById('customersChart');
            if (customersCtx && chartData.customers) {
                new Chart(customersCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['New', 'Returning', 'Inactive'],
                        datasets: [{
                            data: [
                                chartData.customers.new || 0,
                                chartData.customers.returning || 0,
                                chartData.customers.inactive || 0
                            ],
                            backgroundColor: [
                                'rgb(30, 30, 30)',      // New - أسود غامق
                                'rgb(107, 114, 128)',   // Returning - رمادي
                                'rgb(239, 68, 68)'      // Inactive - أحمر (خسارة)
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        return label + ': ' + value + ' customers';
                                    }
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            }

            // Revenue Chart (Main Chart - Last 4 Weeks)
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx && chartData.revenue) {
                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: chartData.revenue.labels.length > 0 ? chartData.revenue.labels : ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        datasets: [{
                            label: 'Revenue',
                            data: chartData.revenue.data.length > 0 ? chartData.revenue.data : [0, 0, 0, 0],
                            borderColor: 'rgb(30, 30, 30)',
                            backgroundColor: 'rgba(30, 30, 30, 0.1)',
                            tension: 0.4,
                            fill: true,
                            borderWidth: 3,
                            pointRadius: 5,
                            pointBackgroundColor: 'rgb(30, 30, 30)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Revenue: ' + context.parsed.y.toLocaleString() + ' EGP';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        if (value >= 1000) {
                                            return (value / 1000) + 'K';
                                        }
                                        return value;
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Category Revenue Chart
            const categoryCtx = document.getElementById('categoryRevenueChart');
            if (categoryCtx && chartData.revenueByCategory) {
                new Chart(categoryCtx, {
                    type: 'bar',
                    data: {
                        labels: chartData.revenueByCategory.labels,
                        datasets: [{
                            label: 'Revenue',
                            data: chartData.revenueByCategory.data,
                            backgroundColor: 'rgba(30, 30, 30, 0.8)',
                            borderColor: 'rgb(30, 30, 30)',
                            borderWidth: 1,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Revenue: ' + context.parsed.y.toLocaleString() + ' EGP';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        if (value >= 1000) {
                                            return (value / 1000) + 'K';
                                        }
                                        return value;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Brand Revenue Chart
            const brandCtx = document.getElementById('brandRevenueChart');
            if (brandCtx && chartData.revenueByBrand) {
                new Chart(brandCtx, {
                    type: 'bar',
                    data: {
                        labels: chartData.revenueByBrand.labels,
                        datasets: [{
                            label: 'Revenue',
                            data: chartData.revenueByBrand.data,
                            backgroundColor: 'rgba(30, 30, 30, 0.8)',
                            borderColor: 'rgb(30, 30, 30)',
                            borderWidth: 1,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Revenue: ' + context.parsed.y.toLocaleString() + ' EGP';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        if (value >= 1000) {
                                            return (value / 1000) + 'K';
                                        }
                                        return value;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Sales by Day of Week Chart
            const salesByDayCtx = document.getElementById('salesByDayChart');
            if (salesByDayCtx && chartData.salesByDay) {
                new Chart(salesByDayCtx, {
                    type: 'bar',
                    data: {
                        labels: chartData.salesByDay.labels,
                        datasets: [{
                            label: 'Revenue',
                            data: chartData.salesByDay.revenue,
                            backgroundColor: 'rgba(30, 30, 30, 0.8)',
                            borderColor: 'rgb(30, 30, 30)',
                            borderWidth: 1,
                            borderRadius: 6,
                            yAxisID: 'y'
                        }, {
                            label: 'Orders',
                            data: chartData.salesByDay.orders,
                            backgroundColor: 'rgba(107, 114, 128, 0.5)',
                            borderColor: 'rgb(107, 114, 128)',
                            borderWidth: 1,
                            borderRadius: 6,
                            yAxisID: 'y1'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            if (context.datasetIndex === 0) {
                                                label += context.parsed.y.toLocaleString() + ' EGP';
                                            } else {
                                                label += context.parsed.y + ' orders';
                                            }
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        if (value >= 1000) {
                                            return (value / 1000) + 'K';
                                        }
                                        return value;
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Revenue (EGP)'
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                beginAtZero: true,
                                grid: {
                                    drawOnChartArea: false
                                },
                                title: {
                                    display: true,
                                    text: 'Orders'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>

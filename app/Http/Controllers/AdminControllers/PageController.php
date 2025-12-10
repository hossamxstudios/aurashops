<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Client;
use App\Models\Stock;
use App\Models\Category;
use App\Models\Brand;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\LoyaltyAccount;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PageController extends Controller {

    public function dashboard(Request $request) {
        // ==================== SALES ANALYTICS ====================
        // Today's Sales
        $todaySales = Order::whereDate('created_at', today())->sum('total_amount');
        // Yesterday's Sales
        $yesterdaySales = Order::whereDate('created_at', today()->subDay())->sum('total_amount');
        // Sales Growth Percentage
        $salesGrowth = $yesterdaySales > 0 ? round((($todaySales - $yesterdaySales) / $yesterdaySales) * 100, 1) : 0;
        // Last 7 Days Sales (for chart)
        $last7DaysSales = Order::where('created_at', '>=', today()->subDays(6))->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )->groupBy('date')->orderBy('date')->get();
        // Monthly Revenue (last 30 days)
        $monthlyRevenue = Order::where('created_at', '>=', today()->subDays(30))->sum('total_amount');
        // Last 4 Weeks Revenue (for main chart)
        $last4WeeksRevenue = Order::where('created_at', '>=', today()->subDays(28))->select(
            DB::raw('WEEK(created_at) as week'),
            DB::raw('SUM(total_amount) as total')
        )->groupBy('week')->orderBy('week')->get();
        // Average Order Value
        $avgOrderValue = Order::whereDate('created_at', '>=', today()->subDays(30))->avg('total_amount');
        // ==================== ORDER ANALYTICS ====================
        // Today's Orders
        $todayOrders = Order::whereDate('created_at', today())->count();
        // Orders by Status
        $ordersByStatus = Order::select('order_status_id', DB::raw('count(*) as count'), DB::raw('SUM(total_amount) as total_value'))->with('orderStatus')->groupBy('order_status_id')->get();
        // Completed Orders Count
        $completedOrders = Order::where('is_done', true)->whereDate('created_at', today())->count();
        // Pending Orders Count
        $pendingOrders = Order::where('is_done', false)->where('is_canceled', false)->whereDate('created_at', today())->count();
        // Recent Orders (last 10)
        $recentOrders = Order::with(['client', 'orderStatus'])->latest()->take(10)->get();
        // ==================== PRODUCT ANALYTICS ====================
        // Top Selling Products (by quantity)
        $topSellingProducts = Product::select('products.*')->join('order_items', 'products.id', '=', 'order_items.product_id')->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.qty) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )->groupBy('products.id', 'products.name')->orderBy('total_sold', 'desc')->take(5)->get();

        // Add category and stock info to top products
        foreach($topSellingProducts as $product) {
            $product->load('categories');
            $product->category_name = $product->categories->first()->name ?? 'N/A';
            $product->stock_status = $this->getStockStatus($product->id);
        }

        // ==================== CUSTOMER ANALYTICS ====================
        // Total Customers
        $totalCustomers = Client::count();
        // New Customers Today
        $newCustomersToday = Client::whereDate('created_at', today())->count();
        // Active Customers (made purchase in last 30 days)
        $activeCustomers = Client::whereHas('orders', function($q) {
            $q->where('created_at', '>=', today()->subDays(30));
        })->count();
        // Returning Customers Rate
        $returningCustomers = Client::has('orders', '>', 1)->count();
        $returningRate = $totalCustomers > 0 ? round(($returningCustomers / $totalCustomers) * 100, 1) : 0;
        // Customer Segments for Chart
        $newCustomers = Client::whereDate('created_at', '>=', today()->subDays(30))->count();
        $inactiveCustomers = Client::whereDoesntHave('orders', function($q) {
            $q->where('created_at', '>=', today()->subDays(90));
        })->count();
        // ==================== INVENTORY ANALYTICS ====================
        // Low Stock Products (qty <= reorder_qty and qty > 0)
        $lowStockCount = Stock::whereColumn('qty', '<=', 'reorder_qty')->where('qty', '>', 0)->count();
        // Out of Stock Products
        $outOfStockCount = Stock::where('qty', 0)->count();
        // Total Products in Stock
        $totalProductsInStock = Product::where('is_active', true)->count();
        // Stock by Day (last 6 days for chart)
        $stockByDay = Stock::where('updated_at', '>=', today()->subDays(6))->select(
            DB::raw('DATE(updated_at) as date'),
            DB::raw('COUNT(DISTINCT CASE WHEN qty <= reorder_qty THEN id END) as low_stock')
        )->groupBy('date')->orderBy('date')->get();
        // Total Stock Value
        $totalStockValue = Stock::join('products', 'stocks.product_id', '=', 'products.id')->select(DB::raw('SUM(stocks.qty * products.price) as total_value'))->value('total_value') ?? 0;
        // ==================== PAYMENT ANALYTICS ====================
        // Revenue by Payment Method
        $revenueByPaymentMethod = Order::select('payment_method_id', DB::raw('SUM(total_amount) as total'))->with('paymentMethod')->groupBy('payment_method_id')->get();
        // COD vs Online Ratio
        $codOrders = Order::where('is_cod', true)->count();
        $totalOrdersCount = Order::count();
        $codPercentage = $totalOrdersCount > 0 ? round(($codOrders / $totalOrdersCount) * 100, 1) : 0;
        // ==================== ADDITIONAL METRICS ====================
        // Total Discount Given (last 30 days)
        $totalDiscount = Order::where('created_at', '>=', today()->subDays(30))->sum('discount_amount');
        // Total Tax Collected
        $totalTax = Order::where('created_at', '>=', today()->subDays(30))->sum('tax_amount');
        // Loyalty Points Statistics
        $totalLoyaltyPoints = LoyaltyAccount::sum('points');
        $activeLoyaltyMembers = LoyaltyAccount::where('points', '>', 0)->count();

        // Sales by Hour Today (for intraday chart)
        $salesByHour = Order::whereDate('created_at', today())->select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('SUM(total_amount) as total')
            )->groupBy('hour')->orderBy('hour')->get();

        // ==================== ADVANCED ANALYTICS ====================
        // Top 10 Customers by Lifetime Value
        $topCustomers = Client::withSum('orders as lifetime_value', 'total_amount')->withCount('orders as total_orders')->having('lifetime_value', '>', 0)->orderBy('lifetime_value', 'desc')->take(10)->get();
        // Revenue by Category (Top 5)
        $revenueByCategory = DB::table('categories')
            ->join('category_product', 'categories.id', '=', 'category_product.category_id')
            ->join('order_items', 'category_product.product_id', '=', 'order_items.product_id')
            ->select(
                'categories.name',
                DB::raw('SUM(order_items.subtotal) as revenue'),
                DB::raw('SUM(order_items.qty) as total_sold')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('revenue', 'desc')
            ->take(5)
            ->get();

        // Revenue by Brand (Top 5)
        $revenueByBrand = DB::table('brands')
            ->join('products', 'brands.id', '=', 'products.brand_id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->select(
                'brands.name',
                DB::raw('SUM(order_items.subtotal) as revenue'),
                DB::raw('SUM(order_items.qty) as total_sold')
            )
            ->groupBy('brands.id', 'brands.name')
            ->orderBy('revenue', 'desc')
            ->take(5)
            ->get();

        // Sales by City (Top 5)
        $salesByCity = DB::table('cities')
            ->join('zones', 'cities.id', '=', 'zones.city_id')
            ->join('districts', 'zones.id', '=', 'districts.zone_id')
            ->join('addresses', 'districts.id', '=', 'addresses.district_id')
            ->join('orders', 'addresses.id', '=', 'orders.address_id')
            ->select(
                'cities.cityName as name',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(orders.total_amount) as total_revenue')
            )
            ->groupBy('cities.id', 'cities.cityName')
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        // Sales by Day of Week (Last 30 days)
        $salesByDayOfWeek = Order::where('created_at', '>=', today()->subDays(30))
            ->select(
                DB::raw('DAYNAME(created_at) as day'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('day')
            ->orderByRaw('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")')
            ->get();

        // Peak Sales Hours (Last 7 days)
        $peakSalesHours = Order::where('created_at', '>=', today()->subDays(7))
            ->select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('hour')
            ->orderBy('revenue', 'desc')
            ->take(5)
            ->get();

        // Average Basket Size (items per order)
        $avgBasketSize = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereDate('orders.created_at', '>=', today()->subDays(30))
            ->select(DB::raw('AVG(order_items.qty) as avg_items'))
            ->value('avg_items') ?? 0;

        // Low Performing Products (in stock but low/no sales in 30 days)
        $lowPerformingProducts = Product::query()
            ->select([
                'products.*',
                DB::raw('COALESCE(SUM(order_items.qty), 0) as total_sold')
            ])
            ->leftJoin('order_items', function($join) {
                $join->on('products.id', '=', 'order_items.product_id')
                    ->where('order_items.created_at', '>=', today()->subDays(30));
            })
            ->join('stocks', 'products.id', '=', 'stocks.product_id')
            ->where('stocks.qty', '>', 0)
            ->where('products.is_active', true)
            ->groupBy([
                'products.id',
                'products.brand_id',
                'products.gender_id',
                'products.sku',
                'products.barcode',
                'products.type',
                'products.name',
                'products.slug',
                'products.details',
                'products.rating',
                'products.base_price',
                'products.price',
                'products.sale_price',
                'products.views_count',
                'products.orders_count',
                'products.meta_title',
                'products.meta_desc',
                'products.meta_keywords',
                'products.is_active',
                'products.is_featured',
                'products.is_stockable',
                'products.created_at',
                'products.updated_at',
                'products.deleted_at'
            ])
            ->having('total_sold', '<', 3)
            ->orderBy('total_sold', 'ASC')
            ->take(5)
            ->get();

        // Coupon Usage Statistics
        $couponStats = Order::whereNotNull('coupon_code')->where('created_at', '>=', today()->subDays(30))->select(
                DB::raw('COUNT(*) as usage_count'),
                DB::raw('SUM(discount_amount) as total_discount'),
                DB::raw('SUM(total_amount) as total_revenue')
            )->first();

        // Monthly Growth Rate (compared to previous month)
        $thisMonthRevenue = Order::whereMonth('created_at', today()->month)->whereYear('created_at', today()->year)->sum('total_amount');
        $lastMonthRevenue = Order::whereMonth('created_at', today()->subMonth()->month)->whereYear('created_at', today()->subMonth()->year)->sum('total_amount');
        $monthlyGrowthRate = $lastMonthRevenue > 0 ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) : 0;
        // Average Customer Lifetime Value
        $avgCustomerLifetimeValue = Client::withSum('orders as lifetime_value', 'total_amount')->having('lifetime_value', '>', 0)->get()->avg('lifetime_value') ?? 0;
        // Repeat Purchase Rate (customers with more than 1 order)
        $repeatPurchaseRate = $totalCustomers > 0 ? round(($returningCustomers / $totalCustomers) * 100, 1) : 0;
        // Return Rate (returned items / total items sold)
        $totalItemsSold = OrderItem::where('created_at', '>=', today()->subDays(30))->sum('qty');
        $returnedItems = OrderItem::where('is_returned', true)->where('created_at', '>=', today()->subDays(30))->sum('qty');
        $returnRate = $totalItemsSold > 0 ? round(($returnedItems / $totalItemsSold) * 100, 2) : 0;
        // Revenue Per Customer
        $revenuePerCustomer = $totalCustomers > 0 ? round($monthlyRevenue / $totalCustomers, 2) : 0;
        // Inventory Turnover Rate (simplified)
        $inventoryTurnover = $totalStockValue > 0 ? round($monthlyRevenue / $totalStockValue, 2) : 0;

        // ==================== PREPARE CHART DATA ====================

        // Format data for JavaScript charts
        $chartData = [
            'sales' => [
                'labels' => $last7DaysSales->pluck('date')->map(fn($d) => Carbon::parse($d)->format('D'))->toArray(),
                'data' => $last7DaysSales->pluck('total')->toArray(),
            ],
            'revenue' => [
                'labels' => $last4WeeksRevenue->pluck('week')->map(fn($w) => "Week $w")->toArray(),
                'data' => $last4WeeksRevenue->pluck('total')->toArray(),
            ],
            'stock' => [
                'labels' => $stockByDay->pluck('date')->map(fn($d) => Carbon::parse($d)->format('D'))->toArray(),
                'data' => $stockByDay->pluck('low_stock')->toArray(),
            ],
            'customers' => [
                'new' => $newCustomers,
                'returning' => $returningCustomers,
                'inactive' => $inactiveCustomers,
            ],
            'salesByHour' => [
                'labels' => $salesByHour->pluck('hour')->map(fn($h) => $h . ':00')->toArray(),
                'data' => $salesByHour->pluck('total')->toArray(),
            ],
            'salesByDay' => [
                'labels' => $salesByDayOfWeek->pluck('day')->toArray(),
                'orders' => $salesByDayOfWeek->pluck('orders')->toArray(),
                'revenue' => $salesByDayOfWeek->pluck('revenue')->toArray(),
            ],
            'revenueByCategory' => [
                'labels' => $revenueByCategory->pluck('name')->toArray(),
                'data' => $revenueByCategory->pluck('revenue')->toArray(),
            ],
            'revenueByBrand' => [
                'labels' => $revenueByBrand->pluck('name')->toArray(),
                'data' => $revenueByBrand->pluck('revenue')->toArray(),
            ],
        ];

        // ==================== RETURN DATA TO VIEW ====================

        return view('admin.pages.dashboard.dashbaord', compact(
            // Sales
            'todaySales',
            'yesterdaySales',
            'salesGrowth',
            'monthlyRevenue',
            'avgOrderValue',
            'thisMonthRevenue',
            'lastMonthRevenue',
            'monthlyGrowthRate',

            // Orders
            'todayOrders',
            'completedOrders',
            'pendingOrders',
            'recentOrders',
            'ordersByStatus',

            // Products
            'topSellingProducts',
            'lowPerformingProducts',

            // Customers
            'totalCustomers',
            'newCustomersToday',
            'activeCustomers',
            'returningRate',
            'topCustomers',
            'avgCustomerLifetimeValue',
            'repeatPurchaseRate',
            'revenuePerCustomer',

            // Inventory
            'lowStockCount',
            'outOfStockCount',
            'totalProductsInStock',
            'totalStockValue',
            'inventoryTurnover',

            // Payment
            'revenueByPaymentMethod',
            'codPercentage',

            // Additional
            'totalDiscount',
            'totalTax',
            'totalLoyaltyPoints',
            'activeLoyaltyMembers',
            'avgBasketSize',
            'returnRate',

            // Advanced Analytics
            'revenueByCategory',
            'revenueByBrand',
            'salesByCity',
            'salesByDayOfWeek',
            'peakSalesHours',
            'couponStats',

            // Chart Data
            'chartData'
        ));
    }

    /**
     * Get stock status for a product
     */
    private function getStockStatus($productId)
    {
        $stock = Stock::where('product_id', $productId)->first();

        if (!$stock || $stock->qty == 0) {
            return 'out_of_stock';
        }

        if ($stock->qty <= $stock->reorder_qty) {
            return 'low_stock';
        }

        return 'in_stock';
    }
}

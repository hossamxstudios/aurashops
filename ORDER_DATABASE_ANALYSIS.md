# 📊 Order Database Complete Analysis

## 🎯 Overview
This document provides a comprehensive analysis of all database tables related to orders in the AuraShops system.

---

## 📋 Database Tables Structure

### 1️⃣ **order_statuses** Table
**Purpose:** Stores all possible order status types (Pending, Processing, Shipped, Delivered, etc.)

| Column | Type | Nullable | Description |
|--------|------|----------|-------------|
| `id` | bigint | NO | Primary Key |
| `name` | varchar | NO | Status name (e.g., "Pending", "Shipped") |
| `deleted_at` | timestamp | YES | Soft delete |
| `created_at` | timestamp | YES | Creation date |
| `updated_at` | timestamp | YES | Last update date |

**Relationships:**
- Has many `orders`
- Has many `order_histories`

---

### 2️⃣ **orders** Table (Main Order Table)
**Purpose:** Stores all order information including customer, payment, shipping, and totals.

| Column | Type | Nullable | Key | Description |
|--------|------|----------|-----|-------------|
| `id` | bigint | NO | PK | Primary Key |
| `pos_session_id` | bigint | YES | FK | Link to POS session (if ordered via POS) |
| `client_id` | bigint | YES | FK | Customer who placed the order |
| `address_id` | bigint | YES | FK | Shipping address |
| `shipping_rate_id` | bigint | YES | FK | Shipping rate applied |
| `pickup_location_id` | bigint | YES | FK | Pickup location (if pickup order) |
| `payment_method_id` | bigint | YES | FK | Payment method used |
| `order_status_id` | bigint | YES | FK | Current order status |
| `source` | varchar | YES | - | Order source (web, mobile, POS) |
| `is_cod` | boolean | NO | - | Cash on Delivery flag |
| `cod_amount` | decimal(10,2) | YES | - | COD amount |
| `cod_fee` | decimal(10,2) | YES | - | COD fee charged |
| `cod_type` | varchar | YES | - | COD type |
| `subtotal_amount` | decimal(10,2) | NO | - | Subtotal before discounts/fees |
| `discount_amount` | decimal(10,2) | YES | - | Total discount applied |
| `shipping_fee` | decimal(10,2) | YES | - | Shipping cost |
| `tax_rate` | decimal(10,2) | YES | - | Tax rate applied |
| `tax_amount` | decimal(10,2) | YES | - | Total tax amount |
| `points_used` | decimal(10,2) | YES | - | Loyalty points used |
| `points_rate` | decimal(10,2) | YES | - | Points to cash conversion rate |
| `points_to_cash` | decimal(10,2) | YES | - | Points value in cash |
| `total_amount` | decimal(10,2) | NO | - | **Final total amount** |
| `coupon_code` | varchar | YES | - | Coupon code applied |
| `admin_notes` | text | YES | - | Internal admin notes |
| `client_notes` | text | YES | - | Customer order notes |
| `ip_address` | varchar | YES | - | Customer IP address |
| `user_agent` | varchar | YES | - | Browser user agent |
| `device_info` | varchar | YES | - | Device information |
| `is_done` | boolean | NO | - | Order completed flag |
| `is_paid` | boolean | NO | - | Payment completed flag |
| `has_returned_items` | boolean | NO | - | Has returned items flag |
| `is_canceled` | boolean | NO | - | Order cancelled flag |
| `deleted_at` | timestamp | YES | - | Soft delete |
| `created_at` | timestamp | YES | - | Order creation date |
| `updated_at` | timestamp | YES | - | Last update date |

**Relationships (Correct Names from Order Model):**
- `client()` - Belongs to `Client`
- `address()` - Belongs to `Address`
- `shippingRate()` - Belongs to `ShippingRate`
- `pickupLocation()` - Belongs to `PickupLocation`
- `paymentMethod()` - Belongs to `PaymentMethod`
- `orderStatus()` - Belongs to `OrderStatus`
- `posSession()` - Belongs to `PosSession`
- `items()` - Has many `OrderItem` ✅
- `payments()` - Has many `OrderPayment` ✅
- `returnOrders()` - Has many `ReturnOrder`
- `shipment()` - Has one `Shipment`
- `shipments()` - Has many `Shipment`

---

### 3️⃣ **order_items** Table
**Purpose:** Stores individual products/items within each order.

| Column | Type | Nullable | Key | Description |
|--------|------|----------|-----|-------------|
| `id` | bigint | NO | PK | Primary Key |
| `order_id` | bigint | YES | FK | Parent order |
| `product_id` | bigint | YES | FK | Product ordered |
| `variant_id` | bigint | YES | FK | Product variant (if applicable) |
| `qty` | integer | NO | - | Quantity ordered |
| `price` | decimal(10,2) | NO | - | Unit price at time of order |
| `subtotal` | decimal(10,2) | NO | - | Item subtotal (qty × price) |
| `is_returned` | boolean | NO | - | Item returned flag |
| `is_refunded` | boolean | NO | - | Item refunded flag |
| `deleted_at` | timestamp | YES | - | Soft delete |
| `created_at` | timestamp | YES | - | Creation date |
| `updated_at` | timestamp | YES | - | Last update date |

**Relationships (Correct Names from OrderItem Model):**
- `order()` - Belongs to `Order`
- `product()` - Belongs to `Product`
- `variant()` - Belongs to `Variant`
- `options()` - Has many `OrderItemOption` ✅ (NOT orderItemOptions!)
- `returnItems()` - Has many `ReturnItem`

---

### 4️⃣ **order_item_options** Table
**Purpose:** Stores additional options/configurations for order items (bundles, customizations).

| Column | Type | Nullable | Key | Description |
|--------|------|----------|-----|-------------|
| `id` | bigint | NO | PK | Primary Key |
| `order_item_id` | bigint | NO | FK | Parent order item |
| `bundle_item_id` | bigint | YES | FK | Bundle item (if part of bundle) |
| `child_product_id` | bigint | YES | FK | Child product in bundle |
| `child_variant_id` | bigint | YES | FK | Child variant in bundle |
| `type` | varchar | NO | - | Option type (default: 'simple') |
| `qty` | integer | NO | - | Quantity (default: 1) |
| `created_at` | timestamp | YES | - | Creation date |
| `updated_at` | timestamp | YES | - | Last update date |

**Relationships:**
- Belongs to `order_item`
- Belongs to `bundle_item`
- Belongs to `product` (child_product)
- Belongs to `variant` (child_variant)

---

### 5️⃣ **order_histories** Table
**Purpose:** Tracks order status changes over time (audit trail).

| Column | Type | Nullable | Key | Description |
|--------|------|----------|-----|-------------|
| `id` | bigint | NO | PK | Primary Key |
| `order_id` | bigint | NO | FK | Order being tracked |
| `status_id` | bigint | NO | FK | New status applied |
| `name` | varchar | NO | - | Status name snapshot |
| `deleted_at` | timestamp | YES | - | Soft delete |
| `created_at` | timestamp | YES | - | Status change timestamp |
| `updated_at` | timestamp | YES | - | Last update date |

**Relationships:**
- Belongs to `order`
- Belongs to `order_status` (status)

**Use Case:** Creates a timeline of order status changes.

---

### 6️⃣ **return_orders** Table
**Purpose:** Manages product return requests and refunds.

| Column | Type | Nullable | Key | Description |
|--------|------|----------|-----|-------------|
| `id` | bigint | NO | PK | Primary Key |
| `client_id` | bigint | NO | FK | Customer requesting return |
| `order_id` | bigint | NO | FK | Original order |
| `address_id` | bigint | NO | FK | Return pickup address |
| `dropoff_location_id` | bigint | NO | FK | Return dropoff location |
| `status` | varchar | NO | - | Return status (default: 'pending') |
| `total_refund_amount` | float | NO | - | Total refund amount |
| `return_fee` | float | NO | - | Return processing fee |
| `shipping_fee` | float | NO | - | Return shipping cost |
| `details` | text | YES | - | Return details/reason |
| `is_refunded` | boolean | NO | - | Refund processed flag |
| `is_all_approved` | boolean | YES | - | All items approved flag |
| `admin_notes` | text | YES | - | Admin notes about return |
| `client_notes` | text | YES | - | Customer notes/reason |
| `deleted_at` | timestamp | YES | - | Soft delete |
| `created_at` | timestamp | YES | - | Return request date |
| `updated_at` | timestamp | YES | - | Last update date |

**Relationships:**
- Belongs to `client`
- Belongs to `order`
- Belongs to `address`
- Belongs to `pickup_location` (dropoff)

---

### 7️⃣ **order_payments** Table
**Purpose:** Tracks payment transactions for orders (supports multiple payments per order).

| Column | Type | Nullable | Key | Description |
|--------|------|----------|-----|-------------|
| `id` | bigint | NO | PK | Primary Key |
| `order_id` | bigint | NO | FK | Order being paid |
| `payment_method_id` | bigint | NO | FK | Payment method used |
| `shipment_id` | bigint | YES | FK | Related shipment |
| `bank_account_id` | bigint | YES | FK | Bank account (for transfers) |
| `transaction_id` | varchar | YES | - | External transaction ID |
| `payment_status` | varchar | NO | - | Payment status (default: 'pending') |
| `gateway_name` | varchar | YES | - | Payment gateway name |
| `gateway_response` | text | YES | - | Full gateway response |
| `amount` | decimal(10,2) | NO | - | Payment amount expected |
| `paid` | decimal(10,2) | NO | - | Amount actually paid |
| `rest` | decimal(10,2) | NO | - | Remaining amount |
| `collection_fee` | decimal(10,2) | NO | - | Collection/processing fee |
| `net_amount` | decimal(10,2) | NO | - | Net amount received |
| `remittance_status` | varchar | NO | - | Remittance status (default: 'pending') |
| `remittance_reference` | text | YES | - | Remittance reference number |
| `remittance_date` | varchar | NO | - | Remittance date |
| `is_done` | boolean | NO | - | Payment completed flag |
| `deleted_at` | timestamp | YES | - | Soft delete |
| `created_at` | timestamp | YES | - | Payment date |
| `updated_at` | timestamp | YES | - | Last update date |

**Relationships:**
- Belongs to `order`
- Belongs to `payment_method`
- Belongs to `shipment`
- Belongs to `bank_account`

---

## 🔗 Entity Relationship Diagram (Simplified)

```
┌─────────────────┐
│  order_statuses │
└────────┬────────┘
         │ 1
         │
         │ N
┌────────▼────────┐
│     orders      │◄─────┐
└────────┬────────┘      │
         │ 1             │ N
         │               │
         │ N     ┌───────┴─────────┐
┌────────▼────────┐     │ return_orders │
│   order_items   │     └───────────────┘
└────────┬────────┘
         │ 1             ┌─────────────────┐
         │               │ order_histories │
         │ N             └─────────────────┘
┌────────▼────────────┐
│ order_item_options  │  ┌──────────────────┐
└─────────────────────┘  │ order_payments   │
                         └──────────────────┘
```

---

## 📊 Key Metrics Available from Orders

### 1. **Order Summary Metrics**
```php
// Total Orders
$totalOrders = Order::count();

// Total Revenue
$totalRevenue = Order::where('is_done', true)->sum('total_amount');

// Average Order Value
$avgOrderValue = Order::avg('total_amount');

// Orders by Status
$ordersByStatus = Order::with('orderStatus')
    ->selectRaw('order_status_id, COUNT(*) as count')
    ->groupBy('order_status_id')
    ->get();
```

### 2. **Payment Metrics**
```php
// Paid vs Unpaid Orders
$paidOrders = Order::where('is_paid', true)->count();
$unpaidOrders = Order::where('is_paid', false)->count();

// COD vs Online Payment
$codOrders = Order::where('is_cod', true)->count();
$onlineOrders = Order::where('is_cod', false)->count();
```

### 3. **Product Performance**
```php
// Top Selling Products (from OrderItem model)
$topProducts = OrderItem::with('product')
    ->selectRaw('product_id, SUM(qty) as total_qty, SUM(subtotal) as total_revenue')
    ->groupBy('product_id')
    ->orderBy('total_qty', 'desc')
    ->take(10)
    ->get();

// OR get items from specific order
$orderItems = $order->items;  // ✅ Correct: items relationship
foreach($orderItems as $item) {
    echo $item->product->name;
    echo $item->qty;
    echo $item->price;
}
```

### 4. **Customer Insights**
```php
// Customer Lifetime Value
$customerLTV = Order::where('client_id', $clientId)
    ->where('is_done', true)
    ->sum('total_amount');

// Repeat Customers
$repeatCustomers = Order::selectRaw('client_id, COUNT(*) as order_count')
    ->groupBy('client_id')
    ->having('order_count', '>', 1)
    ->count();
```

### 5. **Return/Refund Metrics**
```php
// Return Rate
$totalItems = OrderItem::count();
$returnedItems = OrderItem::where('is_returned', true)->count();
$returnRate = ($returnedItems / $totalItems) * 100;

// Total Refunded Amount
$totalRefunded = ReturnOrder::where('is_refunded', true)
    ->sum('total_refund_amount');
```

---

## 🎯 Recommendations for Orders Page

### **Essential Features to Display:**

1. **Order Card/List Item Should Show:**
   - Order ID (`#ORD-{id}`)
   - Order Date (`created_at`)
   - Order Status with colored badge (`order_status.name`)
   - Total Amount (`total_amount`)
   - Payment Status (`is_paid`)
   - Delivery Address preview
   - Number of items (`order_items.count()`)

2. **Order Details Page Should Include:**
   - **Order Info:** ID, Date, Status, Source
   - **Customer Info:** Name, Phone, Email
   - **Shipping Info:** Address, Shipping method, Tracking
   - **Payment Info:** Method, Status, Transaction ID
   - **Items List:** Product name, variant, qty, price, subtotal
   - **Price Breakdown:**
     - Subtotal
     - Discount (if any)
     - Shipping Fee
     - Tax
     - Points Used (if any)
     - **Total**
   - **Order Timeline:** Status history from `order_histories`
   - **Actions:** Track, Cancel, Return, Reorder

3. **Filters & Search:**
   - Filter by Status
   - Filter by Date Range
   - Filter by Payment Status
   - Search by Order ID

4. **Order Actions:**
   - View Details
   - Track Order
   - Cancel Order (if pending)
   - Request Return (if eligible)
   - Reorder
   - Download Invoice

---

## 💡 Important Columns Explained

### **Order Pricing Calculation:**
```
Subtotal = Sum of (order_items.price × order_items.qty)
- Discount Amount
+ Shipping Fee
+ Tax Amount
- Points to Cash
= Total Amount
```

### **COD (Cash on Delivery):**
- `is_cod`: Flag indicating COD order
- `cod_amount`: Amount to be collected
- `cod_fee`: Extra fee for COD service
- `cod_type`: Type of COD

### **Order Status Flags:**
- `is_done`: Order completed and delivered
- `is_paid`: Payment received
- `has_returned_items`: Has items returned
- `is_canceled`: Order was cancelled

### **Audit Trail:**
- `ip_address`, `user_agent`, `device_info`: For fraud detection
- `admin_notes`: Internal notes
- `client_notes`: Customer special instructions

---

## 🔍 Sample Queries for Orders Page

### **Get User Orders with Details:**
```php
$orders = Order::with([
    'orderStatus',
    'items.product',          // ✅ Correct: items not orderItems
    'items.variant',
    'address.district.zone.city',
    'paymentMethod'
])
->where('client_id', auth()->id())
->withCount('items')           // ✅ Count items
->orderBy('created_at', 'desc')
->paginate(10);
```

### **Get Single Order with Full Details:**
```php
$order = Order::with([
    'orderStatus',
    'items.product.media',     // ✅ Correct: items not orderItems
    'items.variant',
    'items.options',           // ✅ Correct: options not orderItemOptions
    'address.district.zone.city',
    'paymentMethod',
    'shippingRate',
    'payments',                // ✅ Correct: payments not orderPayments
    'client'
])
->findOrFail($orderId);
```

### **Get All Items in Order:**
```php
$items = $order->items;        // ✅ Correct relationship name
// OR
$items = $order->items()->with('product', 'variant')->get();
```

### **Access Order Item Options (for Bundles):**
```php
foreach($order->items as $item) {
    // Get options for this item (bundles, customizations)
    $options = $item->options;  // ✅ Correct: options NOT orderItemOptions
    
    foreach($options as $option) {
        echo $option->child_product_id;
        echo $option->qty;
    }
}
```

---

## 📚 Quick Reference: All Relationships

### **Order Model Relationships:**
```php
$order->items             // OrderItem[] - ✅ items not orderItems
$order->payments          // OrderPayment[] - ✅ payments not orderPayments  
$order->client            // Client
$order->orderStatus       // OrderStatus
$order->paymentMethod     // PaymentMethod
$order->address           // Address
$order->shippingRate      // ShippingRate
$order->pickupLocation    // PickupLocation
$order->posSession        // PosSession
$order->returnOrders      // ReturnOrder[]
$order->shipment          // Shipment (single)
$order->shipments         // Shipment[] (multiple)
```

### **OrderItem Model Relationships:**
```php
$orderItem->order         // Order
$orderItem->product       // Product
$orderItem->variant       // Variant
$orderItem->options       // OrderItemOption[] - ✅ options not orderItemOptions
$orderItem->returnItems   // ReturnItem[]
```

---

## ✅ Data Validation Rules

When displaying order data, ensure:
- All money values formatted: `number_format($value, 2)` EGP
- Dates formatted nicely: `$order->created_at->format('M d, Y h:i A')`
- Status badges colored appropriately
- Null checks for optional relationships
- Default values for missing data

---

## 🚀 Next Steps

1. ✅ Review this analysis
2. Create Order model relationships
3. Create OrderController with proper queries
4. Design Orders page UI/UX
5. Implement order details page
6. Add order tracking functionality
7. Implement return/cancel order features
8. Add order filters and search

---

**Generated:** December 10, 2025
**Project:** AuraShops E-Commerce Platform

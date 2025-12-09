# 📋 Database Column Reference - VERIFIED

This document maps all the columns used in PageController to their actual database columns from migrations.

---

## ✅ VERIFIED Column Mappings

### 1. **orders** table
```php
// Used columns - ALL CORRECT ✅
- id
- client_id
- address_id
- shipping_rate_id
- pickup_location_id
- payment_method_id
- order_status_id
- source
- is_cod
- cod_amount
- cod_fee
- cod_type
- subtotal_amount      // ✅ Used in queries
- discount_amount      // ✅ Used in queries
- shipping_fee         // ✅ Used in queries
- tax_rate
- tax_amount          // ✅ Used in queries
- points_used
- points_rate
- points_to_cash
- total_amount        // ✅ Used in queries (MOST IMPORTANT)
- coupon_code
- admin_notes
- client_notes
- ip_address
- user_agent
- device_info
- is_done             // ✅ Used in queries
- is_paid
- has_returned_items
- is_canceled         // ✅ Used in queries
- pos_session_id
- deleted_at
- created_at          // ✅ Used in queries
- updated_at
```

### 2. **order_items** table
```php
// Used columns - ALL CORRECT ✅
- id
- order_id
- product_id          // ✅ Used in joins
- variant_id
- qty                 // ✅ Used in SUM aggregations
- price
- subtotal            // ✅ Used in SUM aggregations
- is_returned
- is_refunded
- deleted_at
- created_at
- updated_at
```

### 3. **products** table
```php
// Used columns - ALL CORRECT ✅
- id                  // ✅ Used in joins
- brand_id
- gender_id
- sku
- barcode
- type
- name                // ✅ Used in display
- slug
- details
- rating
- base_price
- price               // ✅ Used in calculations
- sale_price
- views_count
- orders_count
- meta_title
- meta_desc
- meta_keywords
- is_active           // ✅ Used in where clauses
- is_featured
- is_stockable
- deleted_at
- created_at
- updated_at
```

### 4. **clients** table
```php
// Used columns - ALL CORRECT ✅
- id
- referred_by_id
- skin_tone_id
- skin_type_id
- first_name          // ✅ Used in display
- last_name           // ✅ Used in display
- phone
- email
- password
- gender
- birthdate
- code
- is_blocked
- deleted_at
- created_at          // ✅ Used in where clauses
- updated_at
```

### 5. **stocks** table
```php
// Used columns - ALL CORRECT ✅
- id
- warehouse_id        // ✅ Used in grouping
- product_id          // ✅ Used in joins
- variant_id
- qty                 // ✅ Used in where clauses and calculations
- reorder_qty         // ✅ Used in comparisons
- is_active
- deleted_at
- created_at
- updated_at          // ✅ Used in where clauses
```

### 6. **loyalty_accounts** table ⚠️ FIXED
```php
// ACTUAL columns from migration:
- id
- client_id
- all_points          // Total earned points ever
- points              // ✅ CURRENT available points (FIXED!)
- used_points         // Total points spent
- deleted_at
- created_at
- updated_at

// ❌ WRONG: total_points (doesn't exist!)
// ✅ CORRECT: points
```

### 7. **order_statuses** table
```php
// Used columns - ALL CORRECT ✅
- id
- name                // ✅ Used in display
- color
- description
- is_default
- is_active
- deleted_at
- created_at
- updated_at
```

### 8. **payment_methods** table
```php
// Used columns - ALL CORRECT ✅
- id
- name                // ✅ Used in display
- description
- is_active
- deleted_at
- created_at
- updated_at
```

### 9. **categories** table
```php
// Used columns - ALL CORRECT ✅
- id
- parent_id
- name                // ✅ Used in display
- slug
- description
- image
- is_active
- deleted_at
- created_at
- updated_at
```

---

## 🔧 Fixed Issues

### Issue 1: LoyaltyAccount - total_points ❌
**Error:**
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'total_points' in 'field list'
```

**Wrong Code:**
```php
$totalLoyaltyPoints = LoyaltyAccount::sum('total_points');
$activeLoyaltyMembers = LoyaltyAccount::where('total_points', '>', 0)->count();
```

**Fixed Code:**
```php
$totalLoyaltyPoints = LoyaltyAccount::sum('points');
$activeLoyaltyMembers = LoyaltyAccount::where('points', '>', 0)->count();
```

**Migration Reference:**
```php
// database/migrations/2025_11_03_235756_create_loyalty_accounts_table.php
Schema::create('loyalty_accounts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
    $table->float('all_points')->default(0);    // Total earned
    $table->float('points')->default(0);        // ✅ Current available
    $table->float('used_points')->default(0);   // Total spent
    $table->softDeletes();
    $table->timestamps();
});
```

---

## ✅ All Column Names Verified

All other column names in PageController match exactly with the database migrations:

- ✅ `orders.total_amount`
- ✅ `orders.discount_amount`
- ✅ `orders.tax_amount`
- ✅ `orders.is_done`
- ✅ `orders.is_canceled`
- ✅ `order_items.qty`
- ✅ `order_items.subtotal`
- ✅ `products.name`
- ✅ `products.price`
- ✅ `products.is_active`
- ✅ `stocks.qty`
- ✅ `stocks.reorder_qty`
- ✅ `clients.first_name`
- ✅ `clients.last_name`
- ✅ `loyalty_accounts.points` (FIXED!)

---

## 🎯 Summary

**Total Issues Found:** 1  
**Issues Fixed:** 1  
**Status:** ✅ ALL RESOLVED

The dashboard should now work perfectly with your actual database structure!

---

## 📝 Notes

### Loyalty System Column Structure:
- **all_points**: Lifetime total points earned (never decreases)
- **points**: Current available balance (increases on earn, decreases on use)
- **used_points**: Lifetime total points spent (only increases)

### Formula:
```
all_points = points + used_points
```

When customer earns 100 points:
- all_points += 100
- points += 100

When customer spends 30 points:
- points -= 30
- used_points += 30
- all_points stays the same

---

**Dashboard is ready to use! 🚀**

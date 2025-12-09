# ✅ الأعمدة الصحيحة في قاعدة البيانات

## 🚨 تنبيه مهم: أسماء الأعمدة الفعلية

---

## 📍 جداول المواقع (Location Tables)

### 1. cities (المدن)
```php
- id
- cityId              // معرف المدينة الخارجي
- cityName            // ✅ اسم المدينة (ليس name!)
- cityOtherName       // الاسم البديل
- cityCode            // كود المدينة
- deleted_at
- created_at
- updated_at
```

### 2. zones (المناطق)
```php
- id
- city_id             // مفتاح أجنبي للمدينة
- zoneId              // معرف المنطقة الخارجي
- zoneName            // ✅ اسم المنطقة (ليس name!)
- zoneOtherName       // الاسم البديل
- pickupAvailability  // توفر الاستلام
- dropOffAvailability // توفر التسليم
- is_active
- deleted_at
- created_at
- updated_at
```

### 3. districts (الأحياء)
```php
- id
- zone_id             // مفتاح أجنبي للمنطقة
- districtId          // معرف الحي الخارجي
- districtName        // ✅ اسم الحي (ليس name!)
- districtOtherName   // الاسم البديل
- pickupAvailability  // توفر الاستلام
- dropOffAvailability // توفر التسليم
- is_active
- deleted_at
- created_at
- updated_at
```

---

## 📦 جداول المنتجات (Product Tables)

### 1. categories (التصنيفات)
```php
- id
- gender_id
- parent_id
- name                // ✅ اسم التصنيف (صحيح!)
- slug
- deleted_at
- created_at
- updated_at
```

### 2. brands (الماركات)
```php
- id
- name                // ✅ اسم الماركة (صحيح!)
- slug
- details
- website
- deleted_at
- created_at
- updated_at
```

### 3. products (المنتجات)
```php
- id
- brand_id
- gender_id
- sku
- barcode
- type
- name                // ✅ اسم المنتج (صحيح!)
- slug
- details
- rating
- base_price
- price
- sale_price
- views_count
- orders_count
- meta_title
- meta_desc
- meta_keywords
- is_active
- is_featured
- is_stockable
- deleted_at
- created_at
- updated_at
```

---

## 👥 جداول العملاء (Customer Tables)

### clients (العملاء)
```php
- id
- referred_by_id
- skin_tone_id
- skin_type_id
- first_name          // ✅ الاسم الأول
- last_name           // ✅ اسم العائلة
- phone
- email
- password
- gender
- birthdate
- code
- is_blocked
- deleted_at
- created_at
- updated_at
```

---

## 📋 جداول الطلبات (Order Tables)

### 1. orders (الطلبات)
```php
- id
- pos_session_id
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
- subtotal_amount     // ✅ المجموع الفرعي
- discount_amount     // ✅ قيمة الخصم
- shipping_fee        // ✅ رسوم الشحن
- tax_rate
- tax_amount          // ✅ قيمة الضريبة
- points_used
- points_rate
- points_to_cash
- total_amount        // ✅ المجموع الكلي
- coupon_code
- admin_notes
- client_notes
- ip_address
- user_agent
- device_info
- is_done             // ✅ تم إتمام الطلب
- is_paid
- has_returned_items
- is_canceled         // ✅ تم إلغاء الطلب
- deleted_at
- created_at
- updated_at
```

### 2. order_items (عناصر الطلب)
```php
- id
- order_id
- product_id
- variant_id
- qty                 // ✅ الكمية
- price
- subtotal            // ✅ المجموع الفرعي
- is_returned
- is_refunded
- deleted_at
- created_at
- updated_at
```

---

## 📊 جداول المخزون (Inventory Tables)

### stocks (المخزون)
```php
- id
- warehouse_id
- product_id
- variant_id
- qty                 // ✅ الكمية المتوفرة
- reorder_qty         // ✅ كمية إعادة الطلب
- is_active
- deleted_at
- created_at
- updated_at
```

---

## 💳 جداول الولاء (Loyalty Tables)

### loyalty_accounts (حسابات الولاء)
```php
- id
- client_id
- all_points          // إجمالي النقاط المكتسبة (لا تنقص أبداً)
- points              // ✅ النقاط المتاحة حالياً (تزيد وتنقص)
- used_points         // إجمالي النقاط المستخدمة (تزيد فقط)
- deleted_at
- created_at
- updated_at
```

---

## ⚠️ الأخطاء الشائعة

### ❌ خطأ شائع في المدن:
```php
// ❌ خطأ
$salesByCity = DB::table('cities')
    ->select('cities.name')  // عمود غير موجود!
```

### ✅ الصحيح:
```php
// ✅ صحيح
$salesByCity = DB::table('cities')
    ->select('cities.cityName as name')  // استخدام اسم العمود الصحيح
```

---

### ❌ خطأ شائع في الولاء:
```php
// ❌ خطأ
LoyaltyAccount::sum('total_points')  // عمود غير موجود!
```

### ✅ الصحيح:
```php
// ✅ صحيح
LoyaltyAccount::sum('points')  // العمود الصحيح
```

---

## 🔍 كيفية التحقق من الأعمدة

### 1. عبر Migration Files:
```bash
# ابحث عن ملف الـ migration
find database/migrations -name "*cities*"

# اقرأ الملف لرؤية الأعمدة
```

### 2. عبر قاعدة البيانات:
```sql
-- عرض أعمدة جدول المدن
DESCRIBE cities;

-- أو
SHOW COLUMNS FROM cities;
```

### 3. عبر Laravel Tinker:
```bash
php artisan tinker

# عرض أعمدة الجدول
DB::select('DESCRIBE cities');
```

---

## 📝 ملاحظات مهمة

1. **المدن، المناطق، والأحياء** تستخدم تسمية خاصة:
   - `cityName` بدلاً من `name`
   - `zoneName` بدلاً من `name`
   - `districtName` بدلاً من `name`

2. **التصنيفات والماركات** تستخدم `name` عادي

3. **حسابات الولاء** تستخدم:
   - `points` للنقاط المتاحة
   - `all_points` لإجمالي النقاط المكتسبة
   - `used_points` للنقاط المستخدمة

4. **دائماً استخدم alias** عند الحاجة لتوحيد الأسماء:
   ```php
   ->select('cities.cityName as name')
   ```

---

## ✅ خلاصة التصحيحات

| الجدول | الخطأ | الصحيح |
|-------|------|--------|
| cities | `cities.name` | `cities.cityName` |
| zones | `zones.name` | `zones.zoneName` |
| districts | `districts.name` | `districts.districtName` |
| loyalty_accounts | `total_points` | `points` |
| categories | `name` ✓ | `name` ✓ |
| brands | `name` ✓ | `name` ✓ |
| products | `name` ✓ | `name` ✓ |

---

**تم التصحيح! الآن جميع الأعمدة صحيحة.** ✅

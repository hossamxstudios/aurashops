# Complete Product Module Documentation

## Overview
This is a comprehensive e-commerce product management system with support for **Simple** and **Variant** products.

---

## Database Architecture

### Tables & Relationships

#### 1. **products**
Main product table
```
- id
- brand_id (FK to brands)
- gender_id (FK to genders)
- sku
- type (simple|variant)
- name
- slug
- details
- rating
- base_price (for variant products)
- price (for simple products)
- sale_price
- views_count
- orders_count
- meta_title, meta_desc, meta_keywords
- is_active, is_featured, is_stockable
- soft_deletes
- timestamps
```

#### 2. **attributes**
Product attributes (Color, Size, Material, etc.)
```
- id
- name
- is_active
- soft_deletes
- timestamps
```

#### 3. **values**
Attribute values (Red, Blue, Small, Large, etc.)
```
- id
- attribute_id (FK to attributes)
- name
- is_active
- soft_deletes
- timestamps
```

#### 4. **attribute_product** (Pivot)
Links products to their attributes
```
- id
- attribute_id (FK to attributes, CASCADE)
- product_id (FK to products, CASCADE)
- timestamps
```

#### 5. **variants**
Product variants with specific attribute value combinations
```
- id
- product_id (FK to products, CASCADE)
- name (generated from values, e.g., "Red / Large")
- sku
- price
- sale_price
- meta_title, meta_desc, meta_keywords
- is_active
- soft_deletes
- timestamps
```

#### 6. **value_variant** (Pivot)
Links variants to their specific attribute values
```
- id
- variant_id (FK to variants, CASCADE)
- value_id (FK to values, CASCADE)
- timestamps
```

#### 7. **category_product** (Pivot - assumed)
Links products to categories
```
- id
- category_id
- product_id
- timestamps
```

---

## Product Types

### Simple Product
- **Type**: `simple`
- **Pricing**: Direct `price` and `sale_price` fields
- **No attributes or variants**
- **Use case**: Single, standalone products

**Example**: "Moisturizing Cream 50ml"

### Variant Product
- **Type**: `variant`
- **Pricing**: `base_price` (default for variants)
- **Has attributes** (linked via `attribute_product`)
- **Has multiple variants** (in `variants` table)
- **Each variant** has specific values (linked via `value_variant`)

**Example**: "T-Shirt" with:
- Attribute: Color (Values: Red, Blue, Green)
- Attribute: Size (Values: S, M, L, XL)
- **Generates**: Red/S, Red/M, Red/L, Red/XL, Blue/S, Blue/M... (12 variants)

---

## Model Relationships

### Product Model
```php
// Belongs To
- brand() -> Brand
- gender() -> Gender

// Many To Many
- categories() -> Category (via category_product)
- attributes() -> Attribute (via attribute_product)

// Has Many
- variants() -> Variant

// Helper Methods
- isSimple() -> bool
- isVariant() -> bool
- getDisplayPrice() -> float
```

### Variant Model
```php
// Belongs To
- product() -> Product

// Many To Many
- values() -> Value (via value_variant)

// Helper Methods
- getDisplayPrice() -> float
- getVariantName() -> string (e.g., "Red / Large")
```

### Attribute Model
```php
// Has Many
- values() -> Value

// Many To Many
- products() -> Product (via attribute_product)
```

### Value Model
```php
// Belongs To
- attribute() -> Attribute

// Many To Many
- variants() -> Variant (via value_variant)
```

---

## Controller Methods

### ProductController

#### **index(Request $request)**
- Lists all products with pagination
- **Filters**: search, type, brand_id, gender_id
- **Returns**: products, brands, genders

#### **create()**
- Shows product creation form
- **Returns**: brands, genders, categories, attributes (with values)

#### **store(Request $request)**
- Creates new product (simple or variant)
- **Validation**:
  - Simple: requires `price`
  - Variant: requires `base_price`
- **Handles**:
  - Thumbnail upload (single)
  - Multiple images upload
  - Category assignment
  - Attribute assignment (variant only)
- **Transaction**: Uses DB transactions for data integrity

#### **edit($id)**
- Shows product edit form
- **Loads**: product with variants, attributes, categories
- **Returns**: product, brands, genders, categories, attributes

#### **update(Request $request, $id)**
- Updates existing product
- **Same validation** as store
- **Handles**: image updates, category sync, attribute sync

#### **destroy($id)**
- Soft deletes product
- **Cascade**: Variants are also deleted (database cascade)

#### **generateVariants(Request $request, $id)**
- Generates all variant combinations
- **Only for**: variant products
- **Input**: Array of attributes with selected values
- **Process**:
  1. Deletes existing variants
  2. Generates all combinations (cartesian product)
  3. Creates variant for each combination
  4. Links values to variants
- **Example**:
  ```json
  {
    "attributes": [
      {"attribute_id": 1, "values": [1, 2, 3]}, // Color: Red, Blue, Green
      {"attribute_id": 2, "values": [4, 5]}     // Size: S, M
    ]
  }
  // Generates: 3 × 2 = 6 variants
  ```

---

## Workflow Examples

### Creating a Simple Product
1. Go to products/create
2. Select type: "Simple"
3. Fill: name, SKU, details, price, sale_price
4. Select: brand, gender, categories
5. Upload: thumbnail, images
6. Save → Product created

### Creating a Variant Product
1. Go to products/create
2. Select type: "Variant"
3. Fill: name, SKU, details, base_price
4. Select: brand, gender, categories, attributes
5. Upload: thumbnail, images
6. Save → Product created (no variants yet)
7. Go to product edit page
8. Select specific values for each attribute
9. Click "Generate Variants"
10. All combinations created automatically

### Editing Variants
After generation, each variant can be individually edited:
- Update SKU
- Update price / sale_price
- Upload variant-specific images
- Toggle active status
- Update meta information

---

## Image Collections

### Product
- `product_thumbnail` - Single thumbnail image
- `product_images` - Multiple product images (gallery)

### Variant
- `variant_images` - Variant-specific images

---

## Key Features

### ✅ Implemented
1. **Dual Product Types** - Simple & Variant
2. **Automatic Variant Generation** - Cartesian product of attribute values
3. **Image Management** - Spatie Media Library integration
4. **Category Assignment** - Multi-category support
5. **Brand & Gender** - Product classification
6. **SEO Fields** - Meta title, description, keywords
7. **Status Flags** - Active, Featured, Stockable
8. **Soft Deletes** - Data preservation
9. **Transaction Safety** - DB transactions for data integrity
10. **Price Management** - Regular and sale pricing

### 🔄 To Implement (Views)
1. Product index page with filters
2. Product create form (with type switcher)
3. Product edit form (with variant management)
4. Variant generation interface
5. Image upload previews
6. Category/Attribute selection UI

---

## Database Migrations Order
```bash
1. brands
2. genders
3. categories
4. attributes
5. values
6. products
7. attribute_product
8. variants
9. value_variant
10. category_product
```

---

## Routes
```php
// Products
GET    /admin/products                          -> index
GET    /admin/products/create                   -> create
POST   /admin/products/store                    -> store
GET    /admin/products/{id}/edit                -> edit
PUT    /admin/products/{id}                     -> update
DELETE /admin/products/{id}                     -> destroy
POST   /admin/products/{id}/generate-variants   -> generateVariants
```

---

## Usage Tips

### For Simple Products
- Set `type = 'simple'`
- Use `price` and `sale_price`
- No need for attributes or variants

### For Variant Products
- Set `type = 'variant'`
- Use `base_price` as default
- Select required attributes when creating
- Use "Generate Variants" after creation
- Edit individual variant pricing as needed

### Attribute Management
- Create attributes first (e.g., Color, Size)
- Add values to each attribute
- Select attributes when creating variant products
- System generates all combinations

---

## Next Steps
1. Create product index view with card layout
2. Create product form (create/edit) with type switcher
3. Build variant generation UI
4. Add image upload previews
5. Implement variant editing interface
6. Add product search and filters
7. Create product detail view

---

## Notes
- All prices stored as float
- SKUs can be auto-generated or manual
- Variants inherit product's categories
- Deleting product cascades to variants
- Media files managed by Spatie Media Library
- Relationships use eager loading for performance

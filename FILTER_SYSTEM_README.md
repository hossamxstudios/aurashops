# Laravel-Based Filter System Documentation

## Overview
This is a server-side (Laravel) filter system for the "Shop All" page that filters products by:
1. **Categories** (including subcategories)
2. **Brands**

## How It Works

### 1. **Filter Form** (`resources/views/website/pages/shopAll/filter.blade.php`)
- Uses GET method to submit filters to the same route
- Automatically submits when checkboxes change (via JavaScript)
- Maintains selected state across page loads using `request('categories', [])` and `request('brands', [])`
- Shows product counts for each filter option

### 2. **Controller Logic** (`app/Http/Controllers/WebsiteControllers/PageController.php`)
The `shopAll()` method:
```php
// Filter by categories
if ($request->has('categories') && !empty($request->categories)) {
    $query->whereHas('categories', function($q) use ($request) {
        $q->whereIn('categories.id', $request->categories);
    });
}

// Filter by brands
if ($request->has('brands') && !empty($request->brands)) {
    $query->whereIn('brand_id', $request->brands);
}
```

### 3. **Active Filters Display** (`resources/views/website/pages/shopAll/products.blade.php`)
- Shows selected filters as badges at the top
- Each badge has a close button to remove that specific filter
- "Clear All" button to reset all filters

### 4. **Pagination Preservation**
- Uses `->appends($request->query())` to maintain filters across pages
- Custom pagination view maintains theme styling

## Features

✅ **Category Hierarchy**: Displays parent categories with indented subcategories
✅ **Product Counts**: Shows number of products in each category/brand
✅ **Auto-Submit**: Automatically applies filters when checkboxes change
✅ **Manual Apply**: Also has "Apply Filters" button for manual submission
✅ **Reset Functionality**: "Reset Filters" link to clear all selections
✅ **Active Filter Display**: Visual badges showing current filters
✅ **Individual Filter Removal**: Click X on any badge to remove that filter
✅ **Pagination Friendly**: Filters persist across pagination
✅ **State Persistence**: Selected checkboxes remain checked after page reload

## URL Parameters

When filters are applied, the URL will look like:
```
/shop/all?categories[]=1&categories[]=3&brands[]=2
```

This makes it:
- **Bookmarkable**: Users can save filtered URLs
- **Shareable**: Users can share specific filter combinations
- **SEO Friendly**: Search engines can index filtered pages

## Database Queries

The system uses efficient Laravel queries:
- `whereHas()` for category relationships (many-to-many)
- `whereIn()` for brand filtering (direct foreign key)
- Eager loading with `with()` to prevent N+1 queries

## Customization

### Adding More Filters
To add more filters (like price, size, etc.), follow this pattern:

1. Add form field in `filter.blade.php`
2. Add filter logic in `PageController@shopAll()`
3. Add active filter display in `products.blade.php`

### Example: Adding Price Filter
```php
// In Controller
if ($request->has('min_price') && $request->has('max_price')) {
    $query->whereBetween('price', [$request->min_price, $request->max_price]);
}
```

## Testing Checklist

- [ ] Filter by single category
- [ ] Filter by multiple categories
- [ ] Filter by parent and subcategory together
- [ ] Filter by single brand
- [ ] Filter by multiple brands
- [ ] Combine category + brand filters
- [ ] Remove individual filters via badges
- [ ] Clear all filters at once
- [ ] Navigate through paginated results
- [ ] Verify counts update correctly

## Performance Notes

- Queries are optimized with eager loading
- Product counts are calculated on-the-fly (consider caching for large datasets)
- Pagination limits results to 20 per page
- Consider adding indexes on `brand_id` and category pivot table for better performance

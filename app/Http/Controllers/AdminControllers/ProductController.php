<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Gender;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Variant;
use App\Models\Tag;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {

    public function index(Request $request){
        $query = Product::with(['brand', 'gender', 'categories', 'variants', 'bundleItems']);
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%')
                  ->orWhere('details', 'like', '%' . $search . '%');
            });
        }
        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        // Filter by brand
        if ($request->has('brand_id') && $request->brand_id != '') {
            $query->where('brand_id', $request->brand_id);
        }
        // Filter by gender
        if ($request->has('gender_id') && $request->gender_id != '') {
            $query->where('gender_id', $request->gender_id);
        }
        $products = $query->orderBy('id', 'desc')->paginate(12);
        $brands = Brand::all();
        $genders = Gender::all();
        return view('admin.pages.products.index', compact('products', 'brands', 'genders'));
    }

    public function show($id){
        $product = Product::with([
            'brand','gender','categories.parent','categories.gender',
            'attributes.values',
            'variants.values','tags',
            'bundleItems.child.variants',
            'bundleItems.options.variant',
            'reviews.client','questions'
        ])->findOrFail($id);
        return view('admin.pages.products.show', compact('product'));
    }

    public function create(){
        $brands  = Brand::all();
        $genders = Gender::all();
        // Get only main categories with their children and gender
        $categories = Category::with(['children', 'gender'])->whereNull('parent_id')->orderBy('name', 'asc')->get();
        $attributes = Attribute::with('values')->where('is_active', 1)->get();
        $tags       = Tag::orderBy('name', 'asc')->get();
        $products   = Product::with('variants')->where('type', '!=', 'bundle')->orderBy('name', 'asc')->get();
        return view('admin.pages.products.create', compact('brands', 'genders', 'categories', 'attributes', 'tags', 'products'));
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'name'               => 'required|string|max:255',
            'type'               => 'required|in:simple,variant,bundle',
            'brand_id'           => 'required|exists:brands,id',
            'gender_id'          => 'required|exists:genders,id',
            'sku'                => 'nullable|string|max:255',
            'barcode'            => 'nullable|string|max:255|unique:products,barcode',
            'details'            => 'required|string',
            'base_price'         => 'required|numeric|min:0',
            'price'              => 'required_if:type,simple,bundle|nullable|numeric|min:0',
            'sale_price'         => 'nullable|numeric|min:0',
            'variant_price'      => 'required_if:type,variant|nullable|numeric|min:0',
            'variant_sale_price' => 'nullable|numeric|min:0',
            'is_active'          => 'nullable|boolean',
            'is_featured'        => 'nullable|boolean',
            'categories'         => 'required|array|min:1',
            'categories.*'       => 'exists:categories,id',
            'thumbnail'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'images.*'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'bundle_items'       => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            // Determine price based on product type
            $price = ($request->type === 'variant') ? $request->variant_price : $request->price;
            $sale_price = ($request->type === 'variant') ? $request->variant_sale_price : $request->sale_price;

            $product = Product::create([
                'brand_id'      => $request->brand_id,
                'gender_id'     => $request->gender_id,
                'sku'           => $request->sku,
                'barcode'       => $request->barcode,
                'base_price'    => $request->base_price,
                'price'         => $price,
                'sale_price'    => $sale_price ?: 0,
                'type'          => $request->type,
                'name'          => $request->name,
                'slug'          => Str::slug($request->name),
                'details'       => $request->details,
                'meta_title'    => $request->meta_title,
                'meta_desc'     => $request->meta_desc,
                'meta_keywords' => $request->meta_keywords,
                'is_active'     => $request->has('is_active') ? 1 : 0,
                'is_featured'   => $request->has('is_featured') ? 1 : 0,
            ]);
            // Handle thumbnail
            if ($request->hasFile('thumbnail')) {
                $product->addMediaFromRequest('thumbnail')->toMediaCollection('product_thumbnail');
            }
            // Handle images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $product->addMedia($image)->toMediaCollection('product_images');
                }
            }
            // Attach categories
            if ($request->has('categories') && is_array($request->categories)) {
                $product->categories()->sync($request->categories);
            }
            // Attach tags
            if ($request->has('tags') && is_array($request->tags)) {
                $product->tags()->sync($request->tags);
            }

            // For bundle products, handle bundle items
            if ($request->type === 'bundle' && $request->has('bundle_items') && is_array($request->bundle_items)) {
                foreach ($request->bundle_items as $itemData) {
                    if (isset($itemData['product_id']) && isset($itemData['qty'])) {
                        $bundleItem = $product->bundleItems()->create([
                            'child_id' => $itemData['product_id'],
                            'type'     => $itemData['type'] ?? 'simple',
                            'qty'      => $itemData['qty'] ?? 1,
                        ]);

                        // If type is variant and variants are selected
                        if (isset($itemData['type']) && $itemData['type'] === 'variant' && isset($itemData['variants']) && is_array($itemData['variants'])) {
                            foreach ($itemData['variants'] as $variantId) {
                                $bundleItem->options()->create([
                                    'variant_id' => $variantId,
                                ]);
                            }
                        }
                    }
                }
            }

            // For variant products, handle attributes and values
            if ($request->type === 'variant' && $request->has('attribute_values') && is_array($request->attribute_values)) {
                // Get only attributes that have selected values
                $attributeIds = array_keys($request->attribute_values);
                $product->attributes()->sync($attributeIds);

                // Auto-generate variants if values are selected
                $this->autoGenerateVariants($product, $request->attribute_values);
            }

            // Create stock automatically
            $this->createDefaultStock($product);

            DB::commit();
            // If variant product, redirect to set prices page
            if ($request->type === 'variant' && $product->variants->count() > 0) {
                return redirect()->route('admin.products.set-variant-prices', $product->id)->with('success', 'Product created successfully! Now set individual variant prices.');
            }
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error creating product: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id){
        $product = Product::with(['brand', 'gender', 'categories', 'attributes', 'variants.values', 'tags', 'bundleItems.child', 'bundleItems.options.variant'])->findOrFail($id);
        $brands = Brand::all();
        $genders = Gender::all();
        // Get only main categories with their children and gender
        $categories = Category::with(['children', 'gender'])->whereNull('parent_id')->orderBy('name', 'asc')->get();
        $attributes = Attribute::with('values')->where('is_active', 1)->get();
        $tags = \App\Models\Tag::orderBy('name', 'asc')->get();
        $products = Product::with('variants')->where('type', '!=', 'bundle')->where('id', '!=', $id)->orderBy('name', 'asc')->get();
        return view('admin.pages.products.edit', compact('product', 'brands', 'genders', 'categories', 'attributes', 'tags', 'products'));
    }

    public function update(Request $request, $id){
        $product = Product::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'name'         => 'required|string|max:255',
            'type'         => 'required|in:simple,variant,bundle',
            'brand_id'     => 'required|exists:brands,id',
            'gender_id'    => 'required|exists:genders,id',
            'sku'          => 'nullable|string|max:255',
            'barcode'      => 'nullable|string|max:255|unique:products,barcode,' . $id,
            'details'      => 'required|string',
            'price'        => 'nullable|numeric|min:0',
            'sale_price'   => 'nullable|numeric|min:0',
            'base_price'   => 'nullable|numeric|min:0',
            'is_active'    => 'nullable|boolean',
            'is_featured'  => 'nullable|boolean',
            'categories'   => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'images.*'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'bundle_items' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $updateData = [
                'brand_id' => $request->brand_id,
                'gender_id' => $request->gender_id,
                'sku' => $request->sku,
                'barcode' => $request->barcode,
                'type' => $request->type,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'details' => $request->details,
                'price' => $request->price,
                'sale_price' => $request->sale_price ?: 0,
                'base_price' => $request->base_price ?: 0,
                'meta_title' => $request->meta_title,
                'meta_desc' => $request->meta_desc,
                'meta_keywords' => $request->meta_keywords,
                'is_active' => $request->has('is_active') ? 1 : 0,
                'is_featured' => $request->has('is_featured') ? 1 : 0,
            ];
            $product->update($updateData);
            // Handle thumbnail
            if ($request->hasFile('thumbnail')) {
                $product->clearMediaCollection('product_thumbnail');
                $product->addMediaFromRequest('thumbnail')->toMediaCollection('product_thumbnail');
            }

            // Handle images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $product->addMedia($image)->toMediaCollection('product_images');
                }
            }
            // Attach categories (only if explicitly provided in the request)
            if ($request->has('categories')) {
                if (is_array($request->categories)) {
                    $product->categories()->sync($request->categories);
                } else {
                    $product->categories()->sync([]);
                }
            }

            // Attach tags (only if explicitly provided in the request)
            if ($request->has('tags')) {
                if (is_array($request->tags)) {
                    $product->tags()->sync($request->tags);
                } else {
                    $product->tags()->sync([]);
                }
            }

            // For bundle products, handle bundle items (only if bundle_items is in the request)
            if ($request->type === 'bundle' && $request->has('bundle_items')) {
                // Delete existing bundle items
                $product->bundleItems()->delete();

                if (is_array($request->bundle_items)) {
                    foreach ($request->bundle_items as $itemData) {
                        if (isset($itemData['product_id']) && isset($itemData['qty'])) {
                            $bundleItem = $product->bundleItems()->create([
                                'child_id' => $itemData['product_id'],
                                'type'     => $itemData['type'] ?? 'simple',
                                'qty'      => $itemData['qty'] ?? 1,
                            ]);

                            // If type is variant and variants are selected
                            if (isset($itemData['type']) && $itemData['type'] === 'variant' && isset($itemData['variants']) && is_array($itemData['variants'])) {
                                foreach ($itemData['variants'] as $variantId) {
                                    $bundleItem->options()->create([
                                        'variant_id' => $variantId,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            // For variant products, attach attributes
            if ($request->type === 'variant') {
                if ($request->has('attributes') && is_array($request->attributes)) {
                    $product->attributes()->sync($request->attributes);
                } else {
                    $product->attributes()->sync([]);
                }
            } else {
                // For simple products, remove all attributes
                $product->attributes()->sync([]);
            }
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully');
    }

    public function searchProducts(Request $request){
        // If requesting variants for a specific product
        if ($request->has('product_id')) {
            $product = Product::with('variants')->find($request->product_id);
            if ($product && $product->type === 'variant') {
                $formattedVariants = $product->variants->map(function($variant) {
                    return [
                        'id' => $variant->id,
                        'name' => $variant->name,
                        'sku' => $variant->sku,
                        'price' => $variant->price,
                        'sale_price' => $variant->sale_price,
                    ];
                });

                return response()->json([
                    'variants' => $formattedVariants
                ]);
            }
            return response()->json(['variants' => []]);
        }

        $query = Product::with(['variants']);

        // Exclude bundle products
        if ($request->has('exclude_bundle')) {
            $query->where('type', '!=', 'bundle');
        }

        // Search by name or SKU
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        // Paginate results
        $perPage = 12;
        $products = $query->orderBy('name', 'asc')->paginate($perPage);

        // Format response
        $formattedProducts = $products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'type' => $product->type,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'thumbnail' => $product->getMedia('product_thumbnail')->first() ? $product->getMedia('product_thumbnail')->first()->getUrl() : null,
                'variant_count' => $product->variants->count(),
            ];
        });

        return response()->json([
            'products' => $formattedProducts,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'total_pages' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ]);
    }

    public function setVariantPrices($id){
        $product = Product::with(['variants.values'])->findOrFail($id);
        // Check if product is variant type
        if ($product->type !== 'variant') {
            return redirect()->route('admin.products.index')->with('error', 'This product is not a variant product');
        }
        // Check if variants exist
        if ($product->variants->count() === 0) {
            return redirect()->route('admin.products.edit', $id)->with('error', 'No variants found. Please generate variants first.');
        }
        return view('admin.pages.products.set-variant-prices', compact('product'));
    }

    public function updateVariantPrices(Request $request, $id){
        $product = Product::findOrFail($id);
        try {
            DB::beginTransaction();
            if ($request->has('variants') && is_array($request->variants)) {
                foreach ($request->variants as $variantId => $data) {
                    $variant = Variant::find($variantId);
                    if ($variant && $variant->product_id == $product->id) {
                        $variant->update([
                            'sku' => $data['sku'] ?? $variant->sku,
                            'price' => $data['price'] ?? 0,
                            'sale_price' => $data['sale_price'] ?: 0,
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Variant prices updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error updating variant prices: ' . $e->getMessage())->withInput();
        }
    }

    // Generate variants based on selected attributes and values
    public function generateVariants(Request $request, $id){
        $product = Product::findOrFail($id);

        if ($product->type !== 'variant') {
            return redirect()->back()->with('error', 'Only variant products can have variants');
        }
        $validator = validator()->make($request->all(), [
            'attributes' => 'required|array',
            'attributes.*.attribute_id' => 'required|exists:attributes,id',
            'attributes.*.values' => 'required|array',
            'attributes.*.values.*' => 'required|exists:values,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            // Delete existing variants
            $product->variants()->delete();
            // Generate combinations
            $combinations = $this->generateCombinations($request->attributes);
            foreach ($combinations as $combination) {
                $variantName = implode(' / ', array_column($combination, 'name'));
                $variant = $product->variants()->create([
                    'name'          => $variantName,
                    'sku'           => $product->sku . '-' . Str::random(6),
                    'price'         => $product->price ?? 0,
                    'sale_price'    => $product->sale_price ?? 0,
                    'is_active'     => 1,
                    'meta_title'    => $product->meta_title,
                    'meta_desc'     => $product->meta_desc,
                    'meta_keywords' => $product->meta_keywords,
                ]);

                $valueIds = array_column($combination, 'id');
                $variant->values()->sync($valueIds);
            }
            DB::commit();
            // Redirect to set prices page
            return redirect()->route('admin.products.set-variant-prices', $product->id)
                ->with('success', 'Variants generated successfully! Now set individual variant prices.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error generating variants: ' . $e->getMessage());
        }
    }

    private function generateCombinations($attributes, $index = 0, $current = []){
        if ($index >= count($attributes)) {
            return [$current];
        }
        $results = [];
        $attribute = $attributes[$index];
        foreach ($attribute['values'] as $value) {
            $newCurrent = $current;
            $newCurrent[] = ['id' => $value, 'name' => \App\Models\Value::find($value)->name];
            $results = array_merge($results, $this->generateCombinations($attributes, $index + 1, $newCurrent));
        }
        return $results;
    }

    // Auto-generate variants from attribute values (used during product creation)
    private function autoGenerateVariants($product, $attributeValues){
        // Delete existing variants if any
        $product->variants()->delete();
        // Convert attribute_values format to match generateVariants format
        $attributesData = [];
        foreach ($attributeValues as $attributeId => $values) {
            if (!empty($values)) {
                $attributesData[] = [
                    'attribute_id' => $attributeId,
                    'values'       => $values
                ];
            }
        }
        if (empty($attributesData)) {
            return;
        }
        // Generate combinations
        $combinations = $this->generateCombinations($attributesData);
        foreach ($combinations as $combination) {
            $variantName = implode(' / ', array_column($combination, 'name'));
            $variant = $product->variants()->create([
                'name'          => $variantName,
                'sku'           => $product->sku . '-' . Str::random(6),
                'price'         => $product->price ?? 0,
                'sale_price'    => $product->sale_price ?? 0,
                'is_active'     => 1,
                'meta_title'    => $product->meta_title,
                'meta_desc'     => $product->meta_desc,
                'meta_keywords' => $product->meta_keywords,
            ]);
            $valueIds = array_column($combination, 'id');
            $variant->values()->sync($valueIds);
        }
    }

    public function saveBarcode(Request $request, $id)
    {
        $request->validate([
            'barcode' => 'required|string|unique:products,barcode',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'barcode' => $request->barcode
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barcode saved successfully',
            'barcode' => $product->barcode
        ]);
    }

    /**
     * Create default stock for a product
     */
    private function createDefaultStock($product){
        // Get default warehouse (first active warehouse)
        $warehouse = Warehouse::where('is_active', 1)->first();
        // If no warehouse exists, skip stock creation
        if (!$warehouse) {
            return;
        }
        // For simple and bundle products, create one stock entry
        if ($product->type === 'simple' || $product->type === 'bundle') {
            Stock::create([
                'warehouse_id' => $warehouse->id,
                'product_id'   => $product->id,
                'variant_id'   => null,
                'qty'          => 0,
                'reorder_qty'  => 0,
                'is_active'    => 1,
            ]);
        }
        // For variant products, create stock for each variant
        if ($product->type === 'variant') {
            $product->load('variants');
            foreach ($product->variants as $variant) {
                Stock::create([
                    'warehouse_id' => $warehouse->id,
                    'product_id'   => $product->id,
                    'variant_id'   => $variant->id,
                    'qty'          => 0,
                    'reorder_qty'  => 0,
                    'is_active'    => 1,
                ]);
            }
        }
    }
}

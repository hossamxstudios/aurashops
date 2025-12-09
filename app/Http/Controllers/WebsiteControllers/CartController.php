<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemOption;
use App\Models\BundleItem;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\PaymentMethod;
use App\Models\City;
use App\Models\ShippingRate;

class CartController extends Controller {
    /**
     * Get cart for current user/session
     */
    private function getOrCreateCart(){
        if (Auth::guard('client')->check()) {
            $cart = Cart::firstOrCreate([
                'client_id' => Auth::guard('client')->id()
            ]);
        } else {
            $sessionId = session()->get('cart_session_id');
            if (!$sessionId) {
                $sessionId = Str::uuid()->toString();
                session()->put('cart_session_id', $sessionId);
            }
            $cart = Cart::firstOrCreate([
                'session_id' => $sessionId
            ]);
        }
        return $cart;
    }

    /**
     * Get cart items
     */
    public function index(){
        $cart = $this->getOrCreateCart();
        $items = CartItem::where('cart_id', $cart->id)->with(['product', 'variant'])->get()
            ->map(function($item) {
                $product = $item->product;
                $variant = $item->variant;
                $price = $variant ?
                    ($variant->sale_price > 0 ? $variant->sale_price : $variant->price) :
                    ($product->sale_price > 0 ? $product->sale_price : $product->price);
                return view('website.pages.cart.index', compact('item'));
            });
        $total = $items->sum('sub_total');
        return response()->json([
            'success' => true,
            'cart' => [
                'items' => $items,
                'count' => $items->sum('qty'),
                'total' => $total
            ]
        ]);
    }

    /**
     * Add item to cart
     */
    public function store(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:variants,id',
            'qty' => 'nullable|integer|min:1',
            'bundle_items' => 'nullable|array',
            'bundle_items.*.bundle_item_id' => 'required_with:bundle_items|exists:bundle_items,id',
            'bundle_items.*.variant_id' => 'nullable|exists:variants,id',
        ]);
        $product = Product::with('bundleItems.child')->where('id', $request->product_id)->where('is_active', 1)->first();
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not available'
            ], 404);
        }
        // Handle Bundle Products
        if ($product->type === 'bundle') {
            return $this->addBundleToCart($request, $product);
        }
        // Handle Simple & Variant Products
        $variant = null;
        if ($request->variant_id) {
            $variant = Variant::where('id', $request->variant_id)->where('product_id', $product->id)->where('is_active', 1)->first();
            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Variant not available'
                ], 404);
            }
        }
        $cart = $this->getOrCreateCart();
        $price = $variant ?
            ($variant->sale_price > 0 ? $variant->sale_price : $variant->price) :
            ($product->sale_price > 0 ? $product->sale_price : $product->price);
        $qty = $request->qty ?? 1;
        $subTotal = $price * $qty;
        // Check if item already exists
        $existingItem = CartItem::where('cart_id', $cart->id)->where('product_id', $product->id)->where('variant_id', $variant ? $variant->id : null)->where('type', '!=', 'bundle')->first();
        if ($existingItem) {
            $existingItem->qty += $qty;
            $existingItem->sub_total = $existingItem->price * $existingItem->qty;
            $existingItem->save();
            $cartItem = $existingItem;
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'variant_id' => $variant ? $variant->id : null,
                'type' => $product->type,
                'qty' => $qty,
                'price' => $price,
                'sub_total' => $subTotal
            ]);
        }
        $cartSummary = $this->getCartSummary($cart);
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart' => $cartSummary
        ]);
    }
    /**
     * Add bundle product to cart
     */
    private function addBundleToCart(Request $request, Product $product){
        $cart = $this->getOrCreateCart();
        $bundleItems = $request->bundle_items ?? [];
        DB::beginTransaction();
        try {
            // Calculate total price for the bundle
            $totalPrice = 0;
            foreach ($product->bundleItems as $bundleItem) {
                $child = $bundleItem->child;
                if (!$child) continue;
                // Check if this bundle item needs variant selection
                if ($child->type === 'variant') {
                    // Find all selected variants for this bundle item (qty could be > 1)
                    $selectedVariants = collect($bundleItems)->where('bundle_item_id', $bundleItem->id);

                    if ($selectedVariants->count() !== $bundleItem->qty) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Please select all variants for ' . $child->name . ' (needs ' . $bundleItem->qty . ')'
                        ], 400);
                    }

                    // Validate and calculate price for each selected variant
                    foreach ($selectedVariants as $selectedItem) {
                        if (!isset($selectedItem['variant_id'])) {
                            DB::rollBack();
                            return response()->json([
                                'success' => false,
                                'message' => 'Please select variant for ' . $child->name
                            ], 400);
                        }

                        $variant = Variant::where('id', $selectedItem['variant_id'])
                            ->where('product_id', $child->id)
                            ->where('is_active', 1)
                            ->first();

                        if (!$variant) {
                            DB::rollBack();
                            return response()->json([
                                'success' => false,
                                'message' => 'Variant not available for ' . $child->name
                            ], 404);
                        }

                        $totalPrice += ($variant->sale_price > 0 ? $variant->sale_price : $variant->price);
                    }
                } else {
                    $itemPrice = ($child->sale_price > 0 ? $child->sale_price : $child->price) * $bundleItem->qty;
                    $totalPrice += $itemPrice;
                }
            }

            $qty = $request->qty ?? 1;
            $subTotal = $totalPrice * $qty;

            // Create cart item for the bundle
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'variant_id' => null,
                'type' => 'bundle',
                'qty' => $qty,
                'price' => $totalPrice,
                'sub_total' => $subTotal
            ]);

            // Create cart item options for each bundle item
            foreach ($bundleItems as $selectedItem) {
                $bundleItemId = $selectedItem['bundle_item_id'];
                $variantId = isset($selectedItem['variant_id']) ? $selectedItem['variant_id'] : null;

                // Find the bundle item to get its data
                $bundleItem = $product->bundleItems->firstWhere('id', $bundleItemId);
                if (!$bundleItem) continue;

                $child = $bundleItem->child;
                if (!$child) continue;

                CartItemOption::create([
                    'cart_item_id' => $cartItem->id,
                    'bundle_item_id' => $bundleItem->id,
                    'child_product_id' => $child->id,
                    'child_variant_id' => $variantId,
                    'type' => $child->type,
                    'qty' => 1 // Each selection is for 1 item
                ]);
            }

            DB::commit();

            $cartSummary = $this->getCartSummary($cart);

            return response()->json([
                'success' => true,
                'message' => 'Bundle added to cart',
                'cart' => $cartSummary
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to add bundle to cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id){
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $cart = $this->getOrCreateCart();

        $cartItem = CartItem::where('id', $id)
            ->where('cart_id', $cart->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->qty = $request->qty;
        $cartItem->sub_total = $cartItem->price * $cartItem->qty;
        $cartItem->save();

        // Reload to get fresh data
        $cartItem->refresh();

        // Calculate cart totals
        $allItems = CartItem::where('cart_id', $cart->id)->get();
        $subtotal = $allItems->sum('sub_total');

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'item' => [
                'id' => $cartItem->id,
                'qty' => $cartItem->qty,
                'price' => $cartItem->price,
                'sub_total' => $cartItem->sub_total,
            ],
            'cart' => [
                'subtotal' => $subtotal,
                'total' => $subtotal, // Add shipping if needed
                'count' => $allItems->sum('qty')
            ]
        ]);
    }

    /**
     * Remove item from cart
     */
    public function destroy($id){
        $cart = $this->getOrCreateCart();

        // Find the cart item
        $cartItem = CartItem::where('id', $id)
            ->where('cart_id', $cart->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        // Delete associated options (for bundle items)
        CartItemOption::where('cart_item_id', $cartItem->id)->delete();

        // Delete the cart item
        $cartItem->delete();

        // Calculate cart totals
        $allItems = CartItem::where('cart_id', $cart->id)->get();
        $subtotal = $allItems->sum('sub_total');

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart' => [
                'subtotal' => $subtotal,
                'total' => $subtotal, // Add shipping if needed
                'count' => $allItems->sum('qty')
            ]
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clear(){
        $cart = $this->getOrCreateCart();
        CartItem::where('cart_id', $cart->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
            'cart' => [
                'items' => [],
                'count' => 0,
                'total' => 0
            ]
        ]);
    }

    /**
     * Get cart items HTML (for AJAX updates)
     */
    public function getCartHtml() {
        $cart = $this->getOrCreateCart();
        $cart->load([
            'items.product',
            'items.variant',
            'items.options.childProduct',
            'items.options.childVariant'
        ]);
        $html = view('website.partials.cart-items', compact('cart'))->render();
        $cartSummary = $this->getCartSummary($cart);
        return response()->json([
            'success' => true,
            'html' => $html,
            'cart' => $cartSummary
        ]);
    }

    /**
     * Display cart page
     */
    public function cartPage(){
        $cart = $this->getOrCreateCart();

        $cart->load([
            'items.product',
            'items.variant',
            'items.options.childProduct',
            'items.options.childVariant'
        ]);

        return view('website.pages.cart.index', compact('cart'));
    }

    /**
     * Display checkout page
     */
    public function checkout(){
        $cart = $this->getOrCreateCart();
        $cart->load([
            'items.product','items.variant',
            'items.options.childProduct',
            'items.options.childVariant'
        ]);
        if ($cart->items->count() === 0) {
            return redirect()->route('cart.page')->with('error', 'Your cart is empty');
        }
        $client          = Auth::guard('client')->user();
        $addresses       = $client ? $client->addresses()->with(['city', 'zone', 'district'])->get() : collect();
        $cities          = City::orderBy('cityName')->get();
        $payment_methods = PaymentMethod::where('is_active', 1)->get();

        return view('website.pages.checkout.index', compact('cart', 'addresses', 'cities', 'payment_methods'));
    }

    /**
     * Get shipping rates by city ID
     */
    public function getShippingRate($cityId){
        // Get all shipping rates for this city
        $shippingRates = ShippingRate::where('city_id', $cityId)->with('shipper')->get()
            ->map(function($rate) {
                return [
                    'id' => $rate->id,
                    'shipper_name' => $rate->shipper?->carrier_name ?? 'Standard Shipping',
                    'rate' => (float) $rate->rate,
                    'cod_fee' => (float) $rate->cod_fee,
                    'cod_type' => $rate->cod_type,
                    'is_free_shipping' => (bool) $rate->is_free_shipping,
                    'free_shipping_threshold' => (float) $rate->free_shipping_threshold,
                ];
            });
        // If no rates found, return default
        if ($shippingRates->isEmpty()) {
            return response()->json([
                'rates' => [[
                    'id' => null,
                    'shipper_name' => 'Standard Shipping',
                    'rate' => 100.00,
                    'cod_fee' => 0,
                    'cod_type' => 'fixed',
                    'is_free_shipping' => false,
                    'free_shipping_threshold' => 0,
                ]]
            ]);
        }
        return response()->json([
            'rates' => $shippingRates
        ]);
    }

    /**
     * Get cart summary
     */
    private function getCartSummary($cart){
        $items = CartItem::where('cart_id', $cart->id)->with(['product', 'variant'])->get()
            ->map(function($item) {
                $product = $item->product;
                $variant = $item->variant;

                return [
                    'id' => $item->id,
                    'product_id' => $product->id,
                    'variant_id' => $variant ? $variant->id : null,
                    'name' => $product->name,
                    'variant_name' => $variant ? $variant->name : null,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'sub_total' => $item->sub_total,
                    'image' => $variant ?
                        $variant->getFirstMediaUrl('variant_images') ?: $product->getFirstMediaUrl('product_thumbnail') :
                        $product->getFirstMediaUrl('product_thumbnail')
                ];
            });

        return [
            'items' => $items,
            'count' => $items->sum('qty'),
            'total' => $items->sum('sub_total')
        ];
    }


}

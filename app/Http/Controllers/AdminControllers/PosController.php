<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemOption;
use App\Models\OrderPayment;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\PosSession;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PosController extends Controller {

    /**
     * Display POS interface
     */
    public function index(){
        $activeSession = PosSession::where('user_id', Auth::id())->where('status', 'open')->first();
        if (!$activeSession) {
            return view('admin.pages.pos.session.open');
        }
        $paymentMethods = PaymentMethod::where('is_active', 1)->get();
        return view('admin.pages.pos.index', compact('activeSession', 'paymentMethods'));
    }

    /**
     * Open new POS session
     */
    public function openSession(Request $request){
        $validator = validator()->make($request->all(), [
            'opening_cash' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Check if user has open session
        $existingSession = PosSession::where('user_id', Auth::id())->where('status', 'open')->first();
        if ($existingSession) {
            return redirect()->back()->with('error', 'You already have an open session. Please close it first.');
        }
        PosSession::create([
            'user_id' => Auth::id(),
            'opened_at' => now(),
            'opening_cash' => $request->opening_cash,
            'status' => 'open',
        ]);
        return redirect()->route('admin.pos.index')->with('success', 'Session opened successfully');
    }

    /**
     * Close POS session
     */
    public function closeSession(Request $request){
        $validator = validator()->make($request->all(), [
            'actual_cash' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $session = PosSession::where('user_id', Auth::id())->where('status', 'open')->firstOrFail();
        $session->updateStats();
        $session->update([
            'closed_at' => now(),
            'actual_cash' => $request->actual_cash,
            'difference' => $request->actual_cash - $session->expected_cash,
            'notes' => $request->notes,
            'status' => 'closed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Session closed successfully',
            'session_id' => $session->id
        ]);
    }

    /**
     * Get active session
     */
    public function getActiveSession(){
        $session = PosSession::where('user_id', Auth::id())
                             ->where('status', 'open')
                             ->with('orders')
                             ->first();

        if (!$session) {
            return response()->json(['error' => 'No active session'], 404);
        }

        return response()->json($session);
    }

    /**
     * Search products (for barcode scanner and search)
     */
    public function searchProducts(Request $request){
        $query = Product::where('is_active', 1);

        // Search by barcode
        if ($request->filled('barcode')) {
            $barcodeValue = $request->barcode;

            // First, try to find product by barcode field
            $product = Product::where('is_active', 1)
                              ->where('barcode', $barcodeValue)
                              ->first();

            if ($product) {
                return response()->json([
                    'found' => true,
                    'product' => $this->formatProductForPos($product)
                ]);
            }

            // If not found, try SKU (for backward compatibility)
            $product = Product::where('is_active', 1)
                              ->where('sku', $barcodeValue)
                              ->first();

            if ($product) {
                return response()->json([
                    'found' => true,
                    'product' => $this->formatProductForPos($product)
                ]);
            }

            // Check variants by barcode
            $variant = Variant::where('is_active', 1)
                              ->where('barcode', $barcodeValue)
                              ->with('product')
                              ->first();

            if ($variant && $variant->product && $variant->product->is_active) {
                return response()->json([
                    'found' => true,
                    'product' => $this->formatProductForPos($variant->product),
                    'variant' => $this->formatVariantForPos($variant)
                ]);
            }

            // Check variants by SKU (for backward compatibility)
            $variant = Variant::where('is_active', 1)
                              ->where('sku', $barcodeValue)
                              ->with('product')
                              ->first();

            if ($variant && $variant->product && $variant->product->is_active) {
                return response()->json([
                    'found' => true,
                    'product' => $this->formatProductForPos($variant->product),
                    'variant' => $this->formatVariantForPos($variant)
                ]);
            }

            return response()->json(['found' => false, 'message' => 'Product not found']);
        }

        // Search by name
        if ($request->filled('search')) {
            $products = $query->where('name', 'like', '%' . $request->search . '%')
                             ->limit(20)
                             ->get()
                             ->map(function($product) {
                                 return $this->formatProductForPos($product);
                             });

            return response()->json($products);
        }

        // Get all products with pagination
        $products = $query->paginate(20)->through(function($product) {
            return $this->formatProductForPos($product);
        });

        return response()->json($products);
    }

    /**
     * Get product details (for variants and bundles)
     */
    public function getProductDetails($id){
        $product = Product::with([
            'variants' => function($query) {
                $query->where('is_active', 1);
            },
            'bundleItems.child',
            'bundleItems.options.variant'
        ])->findOrFail($id);

        return response()->json($this->formatProductForPos($product, true));
    }

    /**
     * Create POS order
     */
    public function createOrder(Request $request){
        $validator = validator()->make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payments' => 'required|array|min:1',
            'payments.*.method_id' => 'required|exists:payment_methods,id',
            'payments.*.amount' => 'required|numeric|min:0',
            'client_id' => 'nullable|exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get active session
        $session = PosSession::where('user_id', Auth::id())
                             ->where('status', 'open')
                             ->firstOrFail();

        // Get completed order status
        $completedStatus = OrderStatus::where('name', 'Completed')->first();

        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'pos_session_id' => $session->id,
                'client_id' => $request->client_id,
                'source' => 'POS',
                'order_status_id' => $completedStatus->id ?? null,
                'subtotal_amount' => $request->subtotal,
                'discount_amount' => $request->discount ?? 0,
                'tax_amount' => $request->tax ?? 0,
                'total_amount' => $request->total,
                'is_paid' => true,
                'is_done' => true,
            ]);

            // Create order items
            foreach($request->items as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['qty'] * $item['price']
                ]);

                // Handle bundle items
                if (isset($item['bundle_contents']) && is_array($item['bundle_contents'])) {
                    foreach($item['bundle_contents'] as $bundleContent) {
                        OrderItemOption::create([
                            'order_item_id' => $orderItem->id,
                            'bundle_item_id' => $bundleContent['bundle_item_id'],
                            'child_product_id' => $bundleContent['child_product_id'],
                            'child_variant_id' => $bundleContent['child_variant_id'] ?? null,
                            'type' => $bundleContent['type'],
                            'qty' => $bundleContent['qty']
                        ]);
                    }
                }
            }

            // Create payments
            foreach($request->payments as $payment) {
                OrderPayment::create([
                    'order_id' => $order->id,
                    'payment_method_id' => $payment['method_id'],
                    'payment_status' => 'completed',
                    'amount' => $payment['amount'],
                    'paid' => $payment['amount'],
                    'rest' => 0,
                    'transaction_id' => $payment['transaction_id'] ?? null,
                    'is_done' => true
                ]);
            }

            // Update session stats
            $session->updateStats();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'order_id' => $order->id
            ]);

        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Print receipt
     */
    public function printReceipt($orderId){
        $order = Order::with([
            'client',
            'items.product',
            'items.variant',
            'items.options.childProduct',
            'items.options.childVariant',
            'payments.paymentMethod'
        ])->findOrFail($orderId);

        return view('admin.pages.pos.receipt', compact('order'));
    }

    /**
     * Format product for POS display
     */
    private function formatProductForPos($product, $detailed = false){
        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'type' => $product->type,
            'price' => $product->sale_price > 0 ? $product->sale_price : $product->price,
            'original_price' => $product->price,
            'sale_price' => $product->sale_price,
            'image' => $product->getFirstMediaUrl('product_thumbnail'),
        ];

        if ($detailed) {
            if ($product->type === 'variant') {
                $data['variants'] = $product->variants->map(function($variant) {
                    return $this->formatVariantForPos($variant);
                });

                // Get all unique attributes and their values from variants
                $attributesData = [];
                foreach ($product->variants as $variant) {
                    foreach ($variant->values as $value) {
                        $attributeId = $value->attribute_id;
                        $attributeName = $value->attribute->name ?? 'Attribute ' . $attributeId;

                        if (!isset($attributesData[$attributeId])) {
                            $attributesData[$attributeId] = [
                                'id' => $attributeId,
                                'name' => $attributeName,
                                'values' => []
                            ];
                        }

                        // Add value if not already present
                        if (!collect($attributesData[$attributeId]['values'])->contains('id', $value->id)) {
                            $attributesData[$attributeId]['values'][] = [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        }
                    }
                }

                $data['attributes'] = array_values($attributesData);
            }

            if ($product->type === 'bundle') {
                $data['bundle_items'] = $product->bundleItems->map(function($item) {
                    $bundleItemData = [
                        'id' => $item->id,
                        'child_id' => $item->child_id,
                        'child_name' => $item->child->name ?? '',
                        'type' => $item->type,
                        'qty' => $item->qty,
                        'options' => $item->options->map(function($option) {
                            return [
                                'variant_id' => $option->variant_id,
                                'variant_name' => $option->variant->name ?? '',
                                'value_ids' => $option->variant ? $option->variant->values->pluck('id')->toArray() : []
                            ];
                        })
                    ];

                    // If type is variant, add attributes and variants info
                    if ($item->type === 'variant' && $item->child) {
                        $childProduct = $item->child;

                        // Add all variants
                        $bundleItemData['variants'] = $childProduct->variants->map(function($variant) {
                            return [
                                'id' => $variant->id,
                                'name' => $variant->name,
                                'sku' => $variant->sku,
                                'price' => $variant->sale_price > 0 ? $variant->sale_price : $variant->price,
                                'value_ids' => $variant->values->pluck('id')->toArray(),
                            ];
                        });

                        // Add attributes
                        $attributesData = [];
                        foreach ($childProduct->variants as $variant) {
                            foreach ($variant->values as $value) {
                                $attributeId = $value->attribute_id;
                                $attributeName = $value->attribute->name ?? 'Attribute ' . $attributeId;

                                if (!isset($attributesData[$attributeId])) {
                                    $attributesData[$attributeId] = [
                                        'id' => $attributeId,
                                        'name' => $attributeName,
                                        'values' => []
                                    ];
                                }

                                // Add value if not already present
                                if (!collect($attributesData[$attributeId]['values'])->contains('id', $value->id)) {
                                    $attributesData[$attributeId]['values'][] = [
                                        'id' => $value->id,
                                        'name' => $value->name
                                    ];
                                }
                            }
                        }

                        $bundleItemData['attributes'] = array_values($attributesData);
                    }

                    return $bundleItemData;
                });
            }
        }

        return $data;
    }

    /**
     * Format variant for POS display
     */
    private function formatVariantForPos($variant){
        return [
            'id' => $variant->id,
            'product_id' => $variant->product_id,
            'name' => $variant->name,
            'sku' => $variant->sku,
            'barcode' => $variant->barcode,
            'price' => $variant->sale_price > 0 ? $variant->sale_price : $variant->price,
            'original_price' => $variant->price,
            'sale_price' => $variant->sale_price,
            'value_ids' => $variant->values->pluck('id')->toArray(),
        ];
    }

    /**
     * Save cart to database
     */
    public function saveCart(Request $request)
    {
        try {
            $activeSession = PosSession::where('user_id', Auth::id())
                                       ->where('status', 'open')
                                       ->first();

            if (!$activeSession) {
                return response()->json(['error' => 'No active session'], 400);
            }

            if (!$request->has('items') || !is_array($request->items)) {
                return response()->json(['error' => 'Invalid items data'], 400);
            }

            DB::beginTransaction();

            // Delete existing cart for this session
            $existingCart = \App\Models\Cart::where('pos_session_id', $activeSession->id)->first();
            if ($existingCart) {
                $existingCart->items()->each(function ($item) {
                    $item->options()->delete();
                });
                $existingCart->items()->delete();
                $existingCart->delete();
            }

            // Create new cart
            $cart = \App\Models\Cart::create([
                'pos_session_id' => $activeSession->id,
                'client_id' => $request->client_id,
            ]);

            // Save cart items
            foreach ($request->items as $itemData) {
                if (!isset($itemData['product_id']) || !isset($itemData['qty']) || !isset($itemData['price'])) {
                    continue; // Skip invalid items
                }

                $cartItem = $cart->items()->create([
                    'product_id' => $itemData['product_id'],
                    'variant_id' => $itemData['variant_id'] ?? null,
                    'type' => $itemData['type'] ?? 'simple',
                    'qty' => $itemData['qty'],
                    'price' => $itemData['price'],
                    'sub_total' => $itemData['price'] * $itemData['qty'],
                ]);

                // Save bundle contents if exists
                if (isset($itemData['bundle_contents']) && is_array($itemData['bundle_contents'])) {
                    foreach ($itemData['bundle_contents'] as $bundleContent) {
                        if (!isset($bundleContent['child_product_id'])) {
                            continue; // Skip invalid bundle items
                        }

                        $cartItem->options()->create([
                            'bundle_item_id' => $bundleContent['bundle_item_id'] ?? null,
                            'child_product_id' => $bundleContent['child_product_id'],
                            'child_variant_id' => $bundleContent['child_variant_id'] ?? null,
                            'type' => $bundleContent['type'] ?? 'simple',
                            'qty' => $bundleContent['qty'] ?? 1,
                        ]);
                    }
                }
            }

            DB::commit();

            Log::info('Cart saved successfully', ['cart_id' => $cart->id, 'items_count' => $cart->items->count()]);

            return response()->json(['success' => true, 'cart_id' => $cart->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving cart', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get cart from database
     */
    public function getCart()
    {
        try {
            $activeSession = PosSession::where('user_id', Auth::id())
                                       ->where('status', 'open')
                                       ->first();

            if (!$activeSession) {
                Log::warning('No active POS session found');
                return response()->json(['error' => 'No active session'], 400);
            }

            Log::info('Getting cart for session', ['session_id' => $activeSession->id]);

            $cart = \App\Models\Cart::where('pos_session_id', $activeSession->id)
                                    ->with(['items.product.media', 'items.variant', 'items.options'])
                                    ->first();

            if (!$cart) {
                Log::info('No cart found for session');
                return response()->json(['cart' => null, 'items' => []]);
            }

            Log::info('Cart found', ['cart_id' => $cart->id, 'items_count' => $cart->items->count()]);

            // Format cart items for frontend
            $items = $cart->items->map(function ($item) {
                $product = $item->product;
                $variant = $item->variant;

                $cartItem = [
                    'key' => $variant ? "{$product->id}-{$variant->id}" : "{$product->id}",
                    'product_id' => $product->id,
                    'variant_id' => $variant ? $variant->id : null,
                    'name' => $variant ? "{$product->name} - {$variant->name}" : $product->name,
                    'price' => $item->price,
                    'qty' => $item->qty,
                    'type' => $item->type,
                    'image' => $product->image ?? '/images/no-image.png',
                ];

                // Add bundle contents if exists
                if ($item->options->count() > 0) {
                    $cartItem['is_bundle'] = true;
                    $cartItem['bundle_contents'] = $item->options->map(function ($option) {
                        return [
                            'bundle_item_id' => $option->bundle_item_id,
                            'child_product_id' => $option->child_product_id,
                            'child_variant_id' => $option->child_variant_id,
                            'type' => $option->type,
                            'qty' => $option->qty,
                        ];
                    })->toArray();
                }

                return $cartItem;
            })->toArray();

            return response()->json([
                'cart' => [
                    'client_id' => $cart->client_id,
                ],
                'items' => $items
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Clear cart from database
     */
    public function clearCart()
    {
        try {
            $activeSession = PosSession::where('user_id', Auth::id())
                                       ->where('status', 'open')
                                       ->first();

            if (!$activeSession) {
                return response()->json(['error' => 'No active session'], 400);
            }

            $cart = \App\Models\Cart::where('pos_session_id', $activeSession->id)->first();

            if ($cart) {
                $cart->items()->delete();
                $cart->delete();
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

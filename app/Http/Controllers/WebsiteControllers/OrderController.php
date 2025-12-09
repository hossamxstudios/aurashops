<?php

namespace App\Http\Controllers\WebsiteControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderHistory;
use App\Models\OrderPayment;
use App\Models\Client;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Address;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeClientMail;
use App\Models\Shipment;
use App\Models\ShippingRate;
use App\Models\OrderItem;
use App\Models\PickupLocation;
use App\Models\OrderItemOption;
use App\Models\PaymentMethod;

class OrderController extends Controller {

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
     * Process checkout and create order
     */
    public function processCheckout(Request $request) {
        if (!$request->input('shipping_rate_id')) {
            return back()->withInput()->with('error', 'Please select a shipping method. Make sure to select your city/address first.');
        }
        if (!$request->input('payment-method')) {
            return back()->withInput()->with('error', 'Please select a payment method.');
        }
        $paymentMethod = PaymentMethod::find($request->input('payment-method'));
        if (!$paymentMethod) {
            return back()->withInput()->with('error', 'Invalid payment method selected.');
        }
        try {
            DB::beginTransaction();
            $pendingStatus  = OrderStatus::firstOrCreate(['name' => 'Pending'],['name' => 'Pending']);
            $cart           = $this->getOrCreateCart();
            if ($cart->items->count() === 0) {
                return redirect()->route('cart.page')->with('error', 'Your cart is empty');
            }
            $client         = Auth::guard('client')->user();
            $pickupLocation = PickupLocation::where('is_active', 1)->where('is_default', 1)->first();
            if ($client) {
                $addressId = $request->input('address_id');
                if (!$addressId) {
                    return back()->withInput()->with('error', 'Please select a delivery address');
                }
            } else {
                // Guest user - create new account and address
                $request->validate([
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|email|unique:clients,email',
                    'phone' => 'required|string',
                    'city_id' => 'required|exists:cities,id',
                    'zone_id' => 'required|exists:zones,id',
                    'district_id' => 'required|exists:districts,id',
                    'street' => 'required|string',
                    'building' => 'required|string',
                    'floor' => 'required|string',
                    'apartment' => 'required|string',
                    'label' => 'required|string',
                ]);
                // Create new client account
                $password = $request->email; // Password = Email
                $newClient = Client::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($password),
                    'is_active' => true,
                ]);
                // Create address for new client
                $address = Address::create([
                    'client_id' => $newClient->id,
                    'city_id' => $request->city_id,
                    'zone_id' => $request->zone_id,
                    'district_id' => $request->district_id,
                    'street' => $request->street,
                    'building' => $request->building,
                    'floor' => $request->floor,
                    'apartment' => $request->apartment,
                    'label' => $request->label,
                    'zip_code' => $request->zip_code,
                    'full_address' => $request->full_address,
                    'phone' => $request->phone,
                    'is_default' => true,
                ]);
                $addressId = $address->id;
                $client    = $newClient; // Set client for order
                // Send welcome email with credentials
                try {
                    Mail::to($newClient->email)->send(new WelcomeClientMail($newClient, $password));
                } catch (\Exception $e) {
                    Log::warning('Failed to send welcome email: ' . $e->getMessage());
                }
            }
            $subtotal    = $cart->items->sum('sub_total');
            $shippingFee = floatval($request->input('shipping_rate', 100));
            $discount    = floatval($cart->discount ?? 0);
            $total       = $subtotal + $shippingFee - $discount;
            // Get or create "Pending" order status
            $shippingRate   = ShippingRate::with('shipper')->find($request->input('shipping_rate_id'));
            $shipperId      = $shippingRate->shipper_id;
            if ($paymentMethod->slug === 'cash') {
                $cod_type     = $shippingRate->cod_type;
                $cod_rate     = $shippingRate->cod_fee;
                if ($cod_type === 'fixed') {
                    $cod_fee = $cod_rate;
                } else {
                    $cod_fee = $total * ($cod_rate / 100);
                    if($cod_fee >= 100){
                        $cod_fee = 100;
                    }
                }
            } else {
                $cod_type = null;
                $cod_fee  = null;
            }
            $order = Order::create([
                'client_id'          => $client ? $client->id : null,
                'address_id'         => $addressId,
                'pickup_location_id' => $pickupLocation->id ?? null,
                'shipping_rate_id'   => $request->input('shipping_rate_id'),
                'payment_method_id'  => $paymentMethod->id,
                'order_status_id'    => $pendingStatus->id,
                'source'             => 'WEBSITE',
                'is_cod'             => $paymentMethod->slug === 'cash' ? 1 : 0,
                'cod_type'           => $cod_type,
                'cod_amount'         => $paymentMethod->slug === 'cash' ? $total : null,
                'cod_fee'            => $cod_fee,
                'subtotal_amount'    => $subtotal,
                'discount_amount'    => $discount,
                'shipping_fee'       => $shippingFee,
                'total_amount'       => $total,
                'ip_address'         => $request->ip(),
                'user_agent'         => $request->userAgent(),
            ]);
            // Transfer cart items to order items
            foreach ($cart->items as $cartItem) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'variant_id' => $cartItem->variant_id,
                    'qty' => $cartItem->qty,
                    'price' => $cartItem->price,
                    'subtotal' => $cartItem->sub_total,  // Fixed: database column is 'subtotal' not 'sub_total'
                ]);
                // If bundle, copy options
                if ($cartItem->options && $cartItem->options->count() > 0) {
                    foreach ($cartItem->options as $option) {
                        OrderItemOption::create([
                            'order_item_id' => $orderItem->id,
                            'child_product_id' => $option->child_product_id,
                            'child_variant_id' => $option->child_variant_id,
                        ]);
                    }
                }
            }
            // Create shipment
            $shipment = Shipment::create([
                'order_id'           => $order->id,
                'shipper_id'         => $shipperId ?? null,
                'address_id'         => $addressId,
                'pickup_location_id' => $pickupLocation->id,
                'status'             => 'pending',
                'cod_amount'         => $order->is_cod ? $total   : 0,
                'cod_fee'            => $order->is_cod ? $cod_fee : 0,
                'shipping_fee'       => $shippingFee,
            ]);
            // Create payment record
            $orderPayment = OrderPayment::create([
                'order_id'         => $order->id,
                'payment_method_id'=> $paymentMethod->id,
                'transaction_id'   => $request->input('transaction_id'),
                'payment_status'   => 'pending',
                'amount'           => $total,
                'paid'             => 0,
                'rest'             => $total,
                'is_done'          => 0,
                'collection_fee'   => $cod_fee ?? 0,
                'net_amount'       => $total - ($cod_fee ?? 0),
            ]);
            // Handle payment receipt upload - Upload to BOTH Order and OrderPayment
            if ($request->hasFile('receipt_image')) {
                try {
                    $file = $request->file('receipt_image');
                    // Upload to OrderPayment FIRST
                    $media = $orderPayment->addMedia($file)->toMediaCollection('payment_receipts');
                    // Copy the same file to Order
                    $order->addMedia($media->getPath())->preservingOriginal()->toMediaCollection('payment_receipts');
                    Log::info('Receipt uploaded to both Order and OrderPayment', [
                        'order_id' => $order->id,
                        'payment_id' => $orderPayment->id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Receipt upload failed: ' . $e->getMessage());
                }
            }
            // Clear cart
            $cart->items()->delete();
            $cart->delete();
            DB::commit();
            // Return JSON for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success'  => true,'message'  => 'Order placed successfully','redirect' => route('order.success', $order->id)]);
            }
            // Redirect based on payment method
            if (in_array($paymentMethod->slug, ['credit-card', 'debit-card'])) {
                // Redirect to payment gateway
                return redirect()->route('order.payment', $order->id);
            } else {
                // COD or other payment methods - go directly to success page
                return redirect()->route('order.success', $order->id);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')' . 'Stack Trace: ' . $e->getTraceAsString());
            $errorMessage = config('app.debug')
                ? 'Error: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')'
                : 'An error occurred while processing your order. Please try again.';
            // Return JSON for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false,'message' => $errorMessage], 500);
            }
            return back()->withInput()->with('error', $errorMessage);
        }
    }

    /**
     * Show order success page with invoice
     */
    public function orderSuccess($orderId){
        $order = Order::with([
            'items.product', 'items.variant',
            'items.options.childProduct',
            'items.options.childVariant',
            'address.city', 'address.zone', 'address.district',
            'client','shipment.shipper', 'paymentMethod'
        ])->findOrFail($orderId);
        return view('website.pages.order.success', compact('order'));
    }
    /**
     * Process payment for credit card orders
     * TODO: Integrate with actual payment gateway
     */
    public function processPayment($orderId){
        $order = Order::with(['items.product','address','client'])->findOrFail($orderId);
        // Check if already paid
        if ($order->is_paid) {
            return redirect()->route('order.success', $order->id)->with('info', 'This order has already been paid.');
        }
        return view('website.pages.order.payment', compact('order'));
    }


}

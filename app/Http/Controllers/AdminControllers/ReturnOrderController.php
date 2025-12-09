<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\ReturnOrder;
use App\Models\ReturnItem;
use App\Models\ReturnReason;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PickupLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReturnOrderController extends Controller
{
    /**
     * Display a listing of return orders
     */
    public function index(Request $request)
    {
        $query = ReturnOrder::with(['client', 'order', 'items']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('client', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            })->orWhereHas('order', function($q) use ($search) {
                $q->where('id', $search);
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by refund status
        if ($request->has('refunded') && $request->refunded != '') {
            $query->where('is_refunded', $request->refunded == 'yes' ? 1 : 0);
        }

        $returnOrders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.pages.return-orders.index', compact('returnOrders'));
    }

    /**
     * Show the form for creating a new return order
     */
    public function create() {
        $clients = Client::get();
        $reasons = ReturnReason::where('is_active', 1)->get();
        $dropoffLocations = PickupLocation::where('is_active', 1)->get();

        return view('admin.pages.return-orders.create', compact('clients', 'reasons', 'dropoffLocations'));
    }

    /**
     * Store a newly created return order
     */
    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'order_id' => 'required|exists:orders,id',
            'address_id' => 'required|exists:addresses,id',
            'dropoff_location_id' => 'required|exists:pickup_locations,id',
            'return_fee' => 'nullable|numeric|min:0',
            'shipping_fee' => 'nullable|numeric|min:0',
            'details' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.order_item_id' => 'required|exists:order_items,id',
            'items.*.reason_id' => 'required|exists:return_reasons,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.details' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Create return order
            $returnOrder = ReturnOrder::create([
                'client_id' => $request->client_id,
                'order_id' => $request->order_id,
                'address_id' => $request->address_id,
                'dropoff_location_id' => $request->dropoff_location_id,
                'status' => 'pending',
                'return_fee' => $request->return_fee ?? 0,
                'shipping_fee' => $request->shipping_fee ?? 0,
                'details' => $request->details,
                'admin_notes' => $request->admin_notes,
                'is_refunded' => false,
                'is_all_approved' => null,
            ]);

            // Add return items
            $totalRefund = 0;
            foreach ($request->items as $item) {
                $orderItem = OrderItem::findOrFail($item['order_item_id']);

                // Get price from order item
                $unitPrice = $orderItem->price ?? 0;
                $qty = $item['qty'];
                $subtotal = $unitPrice * $qty;

                if ($unitPrice == 0) {
                    throw new \Exception("Order item #{$orderItem->id} has no price. Please check the order data.");
                }

                ReturnItem::create([
                    'return_order_id' => $returnOrder->id,
                    'order_item_id' => $item['order_item_id'],
                    'reason_id' => $item['reason_id'],
                    'details' => $item['details'] ?? null,
                    'unit_price' => $unitPrice,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                    'refund_amount' => $subtotal,
                    'is_approved' => null,
                    'is_refunded' => false,
                ]);

                $totalRefund += $subtotal;
            }

            // Update total refund amount
            $returnOrder->update([
                'total_refund_amount' => $totalRefund - $returnOrder->return_fee - $returnOrder->shipping_fee
            ]);

            DB::commit();
            return redirect()->route('admin.return-orders.show', $returnOrder->id)->with('success', 'Return order created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create return order: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified return order
     */
    public function show($id)
    {
        $returnOrder = ReturnOrder::with([
            'client',
            'order',
            'address',
            'dropoffLocation',
            'items.orderItem.product',
            'items.orderItem.variant',
            'items.reason'
        ])->findOrFail($id);

        return view('admin.pages.return-orders.show', compact('returnOrder'));
    }

    /**
     * Update the specified return order
     */
    public function update(Request $request, $id)
    {
        $returnOrder = ReturnOrder::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'status' => 'required|in:pending,approved,rejected,completed',
            'return_fee' => 'nullable|numeric|min:0',
            'shipping_fee' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $returnOrder->update([
            'status' => $request->status,
            'return_fee' => $request->return_fee ?? 0,
            'shipping_fee' => $request->shipping_fee ?? 0,
            'admin_notes' => $request->admin_notes,
        ]);

        $returnOrder->calculateTotalRefund();

        return redirect()->back()->with('success', 'Return order updated successfully');
    }

    /**
     * Remove the specified return order
     */
    public function destroy($id)
    {
        $returnOrder = ReturnOrder::findOrFail($id);
        $returnOrder->delete();

        return redirect()->route('admin.return-orders.index')->with('success', 'Return order deleted successfully');
    }

    /**
     * AJAX: Get client's orders
     */
    public function getClientOrders($clientId)
    {
        try {
            $orders = Order::where('client_id', $clientId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($order) {
                    return [
                        'id' => $order->id,
                        'order_number' => '#' . $order->id,
                        'date' => $order->created_at ? $order->created_at->format('M d, Y') : 'N/A',
                        'total' => '$' . number_format($order->total ?? 0, 2),
                    ];
                });

            return response()->json(['orders' => $orders]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'orders' => []
            ], 500);
        }
    }

    /**
     * AJAX: Get order items
     */
    public function getOrderItems($orderId)
    {
        try {
            $items = OrderItem::where('order_id', $orderId)
                ->with(['product', 'variant'])
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'product_name' => $item->product->name ?? 'Unknown Product',
                        'variant_name' => $item->variant ? $item->variant->name : null,
                        'qty' => $item->qty,
                        'unit_price' => $item->price ?? 0,
                        'total' => $item->subtotal ?? 0,
                    ];
                });

            return response()->json(['items' => $items]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'items' => []
            ], 500);
        }
    }

    /**
     * AJAX: Get client addresses
     */
    public function getClientAddresses($clientId)
    {
        $client = Client::with('addresses')->find($clientId);

        if (!$client) {
            return response()->json(['addresses' => []]);
        }

        $addresses = $client->addresses->map(function($address) {
            return [
                'id' => $address->id,
                'label' => $address->label ?? 'Address',
                'full_address' => $address->street . ', ' . $address->district->name . ', ' . $address->city->name,
            ];
        });

        return response()->json(['addresses' => $addresses]);
    }

    /**
     * Approve a single item
     */
    public function approveItem($id)
    {
        $item = ReturnItem::findOrFail($id);
        $item->update(['is_approved' => true]);

        // Check if all items are approved
        $returnOrder = $item->returnOrder;
        $allApproved = $returnOrder->items()->whereNull('is_approved')->orWhere('is_approved', false)->count() == 0;

        if ($allApproved) {
            $returnOrder->update(['is_all_approved' => true, 'status' => 'approved']);
        }

        $returnOrder->calculateTotalRefund();

        return redirect()->back()->with('success', 'Item approved successfully');
    }

    /**
     * Reject a single item
     */
    public function rejectItem($id)
    {
        $item = ReturnItem::findOrFail($id);
        $item->update(['is_approved' => false]);

        $returnOrder = $item->returnOrder;
        $returnOrder->update(['is_all_approved' => false]);
        $returnOrder->calculateTotalRefund();

        return redirect()->back()->with('success', 'Item rejected');
    }

    /**
     * Mark a single item as refunded
     */
    public function refundItem($id)
    {
        $item = ReturnItem::findOrFail($id);
        $item->update(['is_refunded' => true]);

        // Check if all approved items are refunded
        $returnOrder = $item->returnOrder;
        $allRefunded = $returnOrder->items()->where('is_approved', true)->where('is_refunded', false)->count() == 0;

        if ($allRefunded) {
            $returnOrder->update(['is_refunded' => true, 'status' => 'completed']);
        }

        return redirect()->back()->with('success', 'Item marked as refunded');
    }

    /**
     * Approve all items
     */
    public function approveAll($id)
    {
        $returnOrder = ReturnOrder::findOrFail($id);
        $returnOrder->approveAllItems();
        $returnOrder->update(['status' => 'approved']);
        $returnOrder->calculateTotalRefund();

        return redirect()->back()->with('success', 'All items approved');
    }

    /**
     * Refund all approved items
     */
    public function refundAll($id)
    {
        $returnOrder = ReturnOrder::findOrFail($id);
        $returnOrder->refundAllItems();
        $returnOrder->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'All items refunded');
    }
}

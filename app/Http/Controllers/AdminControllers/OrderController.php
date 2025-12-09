<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderHistory;
use App\Models\OrderPayment;
use App\Models\Client;

class OrderController extends Controller {

    public function index(Request $request){
        $query = Order::with(['client', 'orderStatus', 'paymentMethod', 'items']);

        // Search by order ID or client name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('client', function($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('order_status_id', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment') && $request->payment !== '') {
            $query->where('is_paid', $request->payment);
        }

        // Filter by source
        if ($request->has('source') && $request->source) {
            $query->where('source', $request->source);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        $statuses = OrderStatus::all();

        return view('admin.pages.orders.index', compact('orders', 'statuses'));
    }

    public function show($id){
        $order = Order::with([
            'client',
            'address.city',
            'address.zone',
            'address.district',
            'orderStatus',
            'paymentMethod',
            'shippingRate',
            'pickupLocation',
            'shipment.shipper',
            'shipment.address.city',
            'shipment.address.zone',
            'shipment.address.district',
            'shipment.pickupLocation',
            'shipment.trackingEvents',
            'items.product',
            'items.variant',
            'items.options.bundleItem.bundle',
            'items.options.variant',
            'payments.paymentMethod',
            'posSession'
        ])->findOrFail($id);

        // Append product images
        $order->items->each(function($item) {
            if ($item->product) {
                $item->product->append('image');
            }
        });

        // Get order history
        $histories = OrderHistory::where('order_id', $id)
            ->with('status')
            ->orderBy('created_at', 'desc')
            ->get();

        $statuses = OrderStatus::all();
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();

        return view('admin.pages.orders.show', compact('order', 'histories', 'statuses', 'paymentMethods'));
    }

    public function updateStatus(Request $request, $id){
        $request->validate([
            'status_id' => 'required|exists:order_statuses,id'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->orderStatus;

        $order->order_status_id = $request->status_id;
        $order->save();

        // Add to history
        $newStatus = OrderStatus::find($request->status_id);
        OrderHistory::create([
            'order_id' => $order->id,
            'status_id' => $request->status_id,
            'name' => $newStatus->name
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function togglePaid($id){
        $order = Order::findOrFail($id);
        $order->is_paid = !$order->is_paid;
        $order->save();

        $message = $order->is_paid ? 'Order marked as paid' : 'Order marked as unpaid';
        return redirect()->back()->with('success', $message);
    }

    public function toggleDone($id){
        $order = Order::findOrFail($id);
        $order->is_done = !$order->is_done;
        $order->save();

        $message = $order->is_done ? 'Order marked as done' : 'Order marked as not done';
        return redirect()->back()->with('success', $message);
    }

    public function cancel($id){
        $order = Order::findOrFail($id);

        if ($order->is_canceled) {
            return redirect()->back()->with('error', 'Order is already canceled');
        }

        $order->is_canceled = true;
        $order->save();

        // Add to history
        OrderHistory::create([
            'order_id' => $order->id,
            'status_id' => $order->order_status_id,
            'name' => 'Order Canceled'
        ]);

        return redirect()->back()->with('success', 'Order canceled successfully');
    }

    public function addPayment(Request $request, $id){
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0',
            'transaction_id' => 'nullable|string'
        ]);

        $order = Order::findOrFail($id);

        $rest = $request->amount - $request->paid;
        $collectionFee = $request->collection_fee ?? 0;
        $netAmount = $request->paid - $collectionFee;

        OrderPayment::create([
            'order_id' => $order->id,
            'payment_method_id' => $request->payment_method_id,
            'transaction_id' => $request->transaction_id,
            'amount' => $request->amount,
            'paid' => $request->paid,
            'rest' => $rest,
            'collection_fee' => $collectionFee,
            'net_amount' => $netAmount,
            'payment_status' => $rest > 0 ? 'partial' : 'completed',
            'is_done' => $rest > 0 ? 0 : 1
        ]);

        // Update order paid status if fully paid
        if ($rest <= 0) {
            $order->is_paid = true;
            $order->save();
        }

        return redirect()->back()->with('success', 'Payment added successfully');
    }

    public function updateNotes(Request $request, $id){
        $order = Order::findOrFail($id);
        $order->admin_notes = $request->admin_notes;
        $order->save();

        return redirect()->back()->with('success', 'Notes updated successfully');
    }

    /**
     * Approve payment
     */
    public function approvePayment($paymentId)
    {
        $payment = OrderPayment::findOrFail($paymentId);
        $order = $payment->order;

        // Update payment status
        $payment->update([
            'payment_status' => 'completed',
            'paid' => $payment->amount,
            'rest' => 0,
            'is_done' => true
        ]);

        // Update order paid status if total paid equals or exceeds total amount
        $totalPaid = $order->payments()->sum('paid');
        if ($totalPaid >= $order->total_amount) {
            $order->update(['is_paid' => true]);
        }

        // Log this action
        OrderHistory::create([
            'order_id' => $order->id,
            'status_id' => $order->order_status_id,
            'name' => 'Payment #' . $payment->id . ' approved (' . number_format($payment->amount, 2) . ' EGP)',
            'note' => 'Payment #' . $payment->id . ' approved (' . number_format($payment->amount, 2) . ' EGP)'
        ]);

        return redirect()->back()->with('success', 'Payment approved successfully');
    }

    /**
     * Reject payment
     */
    public function rejectPayment($paymentId)
    {
        $payment = OrderPayment::findOrFail($paymentId);
        $order = $payment->order;

        // Update payment status
        $payment->update([
            'payment_status' => 'rejected',
            'is_done' => false
        ]);

        // Log this action
        OrderHistory::create([
            'order_id' => $order->id,
            'order_status_id' => $order->order_status_id,
            'note' => 'Payment #' . $payment->id . ' rejected (' . number_format($payment->amount, 2) . ' EGP)'
        ]);

        return redirect()->back()->with('warning', 'Payment rejected');
    }
}

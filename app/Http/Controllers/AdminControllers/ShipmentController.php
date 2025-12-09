<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Order;
use App\Models\Shipper;
use App\Models\PickupLocation;
use App\Models\Address;
use App\Models\TrackingEvent;

class ShipmentController extends Controller {

    public function index(){
        $shipments       = Shipment::with(['order', 'shipper', 'pickupLocation', 'address'])->latest()->paginate(20);
        $orders          = Order::all();
        $shippers        = Shipper::where('is_active', true)->get();
        $pickupLocations = PickupLocation::where('is_active', true)->get();
        return view('admin.pages.shipments.index', compact('shipments', 'orders', 'shippers', 'pickupLocations'));
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'shipper_id' => 'nullable|exists:shippers,id',
            'pickup_location_id' => 'nullable|exists:pickup_locations,id',
            'address_id' => 'nullable|exists:addresses,id',
            'tracking_number' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'estimated_delivery_at' => 'nullable|date',
            'cod_amount' => 'nullable|numeric',
            'shipping_fee' => 'nullable|numeric',
            'cod_fee' => 'nullable|numeric',
            'client_notes' => 'nullable|string|max:500',
            'carrier_notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Shipment::create([
            'order_id' => $request->order_id,
            'shipper_id' => $request->shipper_id,
            'pickup_location_id' => $request->pickup_location_id,
            'address_id' => $request->address_id,
            'tracking_number' => $request->tracking_number,
            'status' => $request->status,
            'estimated_delivery_at' => $request->estimated_delivery_at,
            'cod_amount' => $request->cod_amount,
            'shipping_fee' => $request->shipping_fee,
            'cod_fee' => $request->cod_fee,
            'client_notes' => $request->client_notes,
            'carrier_notes' => $request->carrier_notes,
        ]);

        return redirect()->route('admin.shipments.index')->with('success', 'Shipment created successfully');
    }

    public function edit($id)
    {
        $shipment = Shipment::findOrFail($id);
        return response()->json($shipment);
    }

    public function update(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'shipper_id' => 'nullable|exists:shippers,id',
            'pickup_location_id' => 'nullable|exists:pickup_locations,id',
            'address_id' => 'nullable|exists:addresses,id',
            'tracking_number' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'estimated_delivery_at' => 'nullable|date',
            'cod_amount' => 'nullable|numeric',
            'cod_collected' => 'nullable|numeric',
            'shipping_fee' => 'nullable|numeric',
            'cod_fee' => 'nullable|numeric',
            'failed_reason' => 'nullable|string|max:500',
            'client_notes' => 'nullable|string|max:500',
            'carrier_notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update status-related timestamps
        $updateData = [
            'order_id' => $request->order_id,
            'shipper_id' => $request->shipper_id,
            'pickup_location_id' => $request->pickup_location_id,
            'address_id' => $request->address_id,
            'tracking_number' => $request->tracking_number,
            'status' => $request->status,
            'estimated_delivery_at' => $request->estimated_delivery_at,
            'cod_amount' => $request->cod_amount,
            'cod_collected' => $request->cod_collected,
            'shipping_fee' => $request->shipping_fee,
            'cod_fee' => $request->cod_fee,
            'failed_reason' => $request->failed_reason,
            'client_notes' => $request->client_notes,
            'carrier_notes' => $request->carrier_notes,
        ];

        // Auto-update timestamps based on status changes
        if ($request->status === 'picked_up' && !$shipment->picked_up_at) {
            $updateData['picked_up_at'] = now();
        }
        if ($request->status === 'out_for_delivery' && !$shipment->out_for_delivery_at) {
            $updateData['out_for_delivery_at'] = now();
        }
        if ($request->status === 'delivered' && !$shipment->delivered_at) {
            $updateData['delivered_at'] = now();
        }
        if ($request->status === 'failed' && !$shipment->failed_at) {
            $updateData['failed_at'] = now();
        }
        if ($request->status === 'returned' && !$shipment->returned_at) {
            $updateData['returned_at'] = now();
        }
        if ($request->status === 'cancelled' && !$shipment->cancelled_at) {
            $updateData['cancelled_at'] = now();
        }

        $shipment->update($updateData);

        return redirect()->route('admin.shipments.index')->with('success', 'Shipment updated successfully');
    }

    public function destroy($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->delete();

        return redirect()->route('admin.shipments.index')->with('success', 'Shipment deleted successfully');
    }

    /**
     * Show shipment details with tracking events
     */
    public function show($id)
    {
        $shipment = Shipment::with(['order', 'shipper', 'pickupLocation', 'address', 'trackingEvents'])
            ->findOrFail($id);

        return view('admin.pages.shipments.show', compact('shipment'));
    }

    /**
     * Store a tracking event for a shipment
     */
    public function storeTrackingEvent(Request $request, $shipmentId)
    {
        $shipment = Shipment::findOrFail($shipmentId);

        $validator = validator()->make($request->all(), [
            'status' => 'nullable|string|max:255',
            'carrier_status_code' => 'nullable|string|max:255',
            'carrier_status_label' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'location_details' => 'nullable|string|max:255',
            'details' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        TrackingEvent::create([
            'shipment_id' => $shipmentId,
            'status' => $request->status,
            'carrier_status_code' => $request->carrier_status_code,
            'carrier_status_label' => $request->carrier_status_label,
            'location' => $request->location,
            'location_details' => $request->location_details,
            'details' => $request->details,
        ]);

        return redirect()->route('admin.shipments.show', $shipmentId)->with('success', 'Tracking event added successfully');
    }

    /**
     * Delete a tracking event
     */
    public function destroyTrackingEvent($shipmentId, $eventId)
    {
        $event = TrackingEvent::where('shipment_id', $shipmentId)->findOrFail($eventId);
        $event->delete();

        return redirect()->route('admin.shipments.show', $shipmentId)->with('success', 'Tracking event deleted successfully');
    }
}

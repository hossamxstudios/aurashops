<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shipper;

class ShipperController extends Controller {

    public function index() {
        $shippers = Shipper::withCount('shippingRates')->latest()->paginate(20);
        return view('admin.pages.shippers.index', compact('shippers'));
    }

    public function store(Request $request) {
        $validator = validator()->make($request->all(), [
            'carrier_name' => 'required|string|max:255',
            'api_endpoint' => 'required|url',
            'api_key' => 'required|string',
            'api_secret' => 'nullable|string',
            'api_password' => 'nullable|string',
            'delivery_time' => 'required|string|max:255',
            'delivery_days' => 'required|string|max:255',
            'cod_fee' => 'required|numeric|min:0',
            'cod_fee_type' => 'required|string|in:fixed,percentage',
            'cod_min' => 'required|numeric|min:0',
            'cod_max' => 'required|numeric|min:0',
            'is_support_cod' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Shipper::create([
            'carrier_name'   => $request->carrier_name,
            'api_endpoint'   => $request->api_endpoint,
            'api_key'        => $request->api_key,
            'api_secret'     => $request->api_secret,
            'api_password'   => $request->api_password,
            'delivery_time'  => $request->delivery_time,
            'delivery_days'  => $request->delivery_days,
            'cod_fee'        => $request->cod_fee,
            'cod_fee_type'   => $request->cod_fee_type,
            'cod_min'        => $request->cod_min,
            'cod_max'        => $request->cod_max,
            'is_support_cod' => $request->is_support_cod ?? true,
            'is_active'      => $request->is_active ?? true,
        ]);
        return redirect()->route('admin.shippers.index')->with('success', 'Shipper created successfully');
    }

    public function edit($id){
        $shipper = Shipper::findOrFail($id);
        return response()->json($shipper);
    }

    public function update(Request $request, $id){
        $shipper = Shipper::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'carrier_name' => 'required|string|max:255',
            'api_endpoint' => 'required|url',
            'api_key' => 'required|string',
            'api_secret' => 'nullable|string',
            'api_password' => 'nullable|string',
            'delivery_time' => 'required|string|max:255',
            'delivery_days' => 'required|string|max:255',
            'cod_fee' => 'required|numeric|min:0',
            'cod_fee_type' => 'required|string|in:fixed,percentage',
            'cod_min' => 'required|numeric|min:0',
            'cod_max' => 'required|numeric|min:0',
            'is_support_cod' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $shipper->update([
            'carrier_name' => $request->carrier_name,
            'api_endpoint' => $request->api_endpoint,
            'api_key' => $request->api_key,
            'api_secret' => $request->api_secret,
            'api_password' => $request->api_password,
            'delivery_time' => $request->delivery_time,
            'delivery_days' => $request->delivery_days,
            'cod_fee' => $request->cod_fee,
            'cod_fee_type' => $request->cod_fee_type,
            'cod_min' => $request->cod_min,
            'cod_max' => $request->cod_max,
            'is_support_cod' => $request->is_support_cod ?? false,
            'is_active' => $request->is_active ?? false,
        ]);
        return redirect()->route('admin.shippers.index')->with('success', 'Shipper updated successfully');
    }

    public function destroy($id){
        $shipper = Shipper::findOrFail($id);
        // Check if shipper has shipping rates
        if ($shipper->shippingRates()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete shipper with existing shipping rates');
        }
        $shipper->delete();
        return redirect()->route('admin.shippers.index')->with('success', 'Shipper deleted successfully');
    }
}

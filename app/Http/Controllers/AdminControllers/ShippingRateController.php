<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use App\Models\Shipper;
use App\Models\City;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    public function index()
    {
        $shippingRates = ShippingRate::with(['shipper', 'city'])
            ->latest()
            ->paginate(20);
        
        $shippers = Shipper::where('is_active', true)->get();
        $cities = City::orderBy('cityName')->get();
        
        return view('admin.pages.shipping_rates.index', compact('shippingRates', 'shippers', 'cities'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'shipper_id' => 'required|exists:shippers,id',
            'city_id' => 'required|exists:cities,id',
            'rate' => 'required|numeric|min:0',
            'cod_fee' => 'required|numeric|min:0',
            'cod_type' => 'required|string|in:fixed,percentage',
            'is_free_shipping' => 'nullable|boolean',
            'free_shipping_threshold' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ShippingRate::create([
            'shipper_id' => $request->shipper_id,
            'city_id' => $request->city_id,
            'rate' => $request->rate,
            'cod_fee' => $request->cod_fee,
            'cod_type' => $request->cod_type,
            'is_free_shipping' => $request->is_free_shipping ?? false,
            'free_shipping_threshold' => $request->free_shipping_threshold ?? 0,
        ]);

        return redirect()->route('admin.shipping-rates.index')->with('success', 'Shipping rate created successfully');
    }

    public function edit($id)
    {
        $shippingRate = ShippingRate::findOrFail($id);
        return response()->json($shippingRate);
    }

    public function update(Request $request, $id)
    {
        $shippingRate = ShippingRate::findOrFail($id);
        
        $validator = validator()->make($request->all(), [
            'shipper_id' => 'required|exists:shippers,id',
            'city_id' => 'required|exists:cities,id',
            'rate' => 'required|numeric|min:0',
            'cod_fee' => 'required|numeric|min:0',
            'cod_type' => 'required|string|in:fixed,percentage',
            'is_free_shipping' => 'nullable|boolean',
            'free_shipping_threshold' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $shippingRate->update([
            'shipper_id' => $request->shipper_id,
            'city_id' => $request->city_id,
            'rate' => $request->rate,
            'cod_fee' => $request->cod_fee,
            'cod_type' => $request->cod_type,
            'is_free_shipping' => $request->is_free_shipping ?? false,
            'free_shipping_threshold' => $request->free_shipping_threshold ?? 0,
        ]);

        return redirect()->route('admin.shipping-rates.index')->with('success', 'Shipping rate updated successfully');
    }

    public function destroy($id)
    {
        $shippingRate = ShippingRate::findOrFail($id);
        $shippingRate->delete();

        return redirect()->route('admin.shipping-rates.index')->with('success', 'Shipping rate deleted successfully');
    }
}

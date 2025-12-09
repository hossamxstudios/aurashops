<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Client;

class AddressController extends Controller {

    /**
     * Store a new address for a client
     */
    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'phone' => 'required|string|max:255',
            'full_address' => 'required|string',
            'label' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'building' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'district_id' => 'required|exists:districts,id',
            'zip_code' => 'nullable|string|max:20',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If this address is set as default, unset other defaults
        if ($request->is_default) {
            Address::where('client_id', $request->client_id)->update(['is_default' => false]);
        }

        $address = Address::create($request->all());

        return redirect()->back()->with('success', 'Address added successfully');
    }

    /**
     * Get address data for editing
     */
    public function edit($id){
        $address = Address::with(['city', 'zone', 'district'])->findOrFail($id);
        return response()->json($address);
    }

    /**
     * Update an existing address
     */
    public function update(Request $request, $id){
        $address = Address::findOrFail($id);
        
        $validator = validator()->make($request->all(), [
            'phone' => 'required|string|max:255',
            'full_address' => 'required|string',
            'label' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'building' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'district_id' => 'required|exists:districts,id',
            'zip_code' => 'nullable|string|max:20',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If this address is set as default, unset other defaults
        if ($request->is_default) {
            Address::where('client_id', $address->client_id)
                   ->where('id', '!=', $id)
                   ->update(['is_default' => false]);
        }

        $address->update($request->all());

        return redirect()->back()->with('success', 'Address updated successfully');
    }

    /**
     * Delete an address
     */
    public function destroy($id){
        $address = Address::findOrFail($id);
        $address->delete();

        return redirect()->back()->with('success', 'Address deleted successfully');
    }

    /**
     * Set an address as default
     */
    public function setDefault($id){
        $address = Address::findOrFail($id);
        
        // Unset all other defaults for this client
        Address::where('client_id', $address->client_id)->update(['is_default' => false]);
        
        // Set this address as default
        $address->update(['is_default' => true]);

        return redirect()->back()->with('success', 'Default address updated');
    }

    /**
     * Get zones by city ID
     */
    public function getZonesByCity($cityId){
        $zones = \App\Models\Zone::where('city_id', $cityId)
                    ->where('is_active', 1)
                    ->orderBy('zoneName')
                    ->get(['id', 'zoneName', 'zoneOtherName']);
        
        return response()->json($zones);
    }

    /**
     * Get districts by zone ID
     */
    public function getDistrictsByZone($zoneId){
        $districts = \App\Models\District::where('zone_id', $zoneId)
                        ->where('is_active', 1)
                        ->orderBy('districtName')
                        ->get(['id', 'districtName', 'districtOtherName']);
        
        return response()->json($districts);
    }
}

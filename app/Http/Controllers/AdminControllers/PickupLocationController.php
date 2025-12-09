<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PickupLocation;
use App\Models\Warehouse;
use App\Models\City;
use App\Models\Zone;
use App\Models\District;

class PickupLocationController extends Controller
{
    public function index()
    {
        $pickupLocations = PickupLocation::with(['warehouse', 'city', 'zone', 'district'])
            ->latest()
            ->paginate(20);
        
        $warehouses = Warehouse::where('is_active', true)->get();
        $cities = City::all();
        
        return view('admin.pages.pickup_locations.index', compact('pickupLocations', 'warehouses', 'cities'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'city_id' => 'nullable|exists:cities,id',
            'zone_id' => 'nullable|exists:zones,id',
            'district_id' => 'nullable|exists:districts,id',
            'type' => 'required|string|max:255',
            'full_address' => 'required|string|max:500',
            'working_hours' => 'nullable|string|max:255',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_phone' => 'nullable|string|max:255',
            'contact_person_email' => 'nullable|email|max:255',
            'zip_code' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If is_default is set, unset other defaults
        if ($request->is_default) {
            PickupLocation::where('is_default', true)->update(['is_default' => false]);
        }

        PickupLocation::create([
            'warehouse_id' => $request->warehouse_id,
            'city_id' => $request->city_id,
            'zone_id' => $request->zone_id,
            'district_id' => $request->district_id,
            'type' => $request->type,
            'full_address' => $request->full_address,
            'working_hours' => $request->working_hours,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_phone' => $request->contact_person_phone,
            'contact_person_email' => $request->contact_person_email,
            'zip_code' => $request->zip_code,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'is_active' => $request->is_active ?? true,
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->route('admin.pickup-locations.index')->with('success', 'Pickup location created successfully');
    }

    public function edit($id)
    {
        $pickupLocation = PickupLocation::findOrFail($id);
        return response()->json($pickupLocation);
    }

    public function update(Request $request, $id)
    {
        $pickupLocation = PickupLocation::findOrFail($id);
        
        $validator = validator()->make($request->all(), [
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'city_id' => 'nullable|exists:cities,id',
            'zone_id' => 'nullable|exists:zones,id',
            'district_id' => 'nullable|exists:districts,id',
            'type' => 'required|string|max:255',
            'full_address' => 'required|string|max:500',
            'working_hours' => 'nullable|string|max:255',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_phone' => 'nullable|string|max:255',
            'contact_person_email' => 'nullable|email|max:255',
            'zip_code' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If is_default is set, unset other defaults
        if ($request->is_default) {
            PickupLocation::where('is_default', true)->where('id', '!=', $id)->update(['is_default' => false]);
        }

        $pickupLocation->update([
            'warehouse_id' => $request->warehouse_id,
            'city_id' => $request->city_id,
            'zone_id' => $request->zone_id,
            'district_id' => $request->district_id,
            'type' => $request->type,
            'full_address' => $request->full_address,
            'working_hours' => $request->working_hours,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_phone' => $request->contact_person_phone,
            'contact_person_email' => $request->contact_person_email,
            'zip_code' => $request->zip_code,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'is_active' => $request->is_active ?? false,
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->route('admin.pickup-locations.index')->with('success', 'Pickup location updated successfully');
    }

    public function destroy($id)
    {
        $pickupLocation = PickupLocation::findOrFail($id);
        $pickupLocation->delete();

        return redirect()->route('admin.pickup-locations.index')->with('success', 'Pickup location deleted successfully');
    }

    /**
     * Get zones by city
     */
    public function getZonesByCity($cityId)
    {
        $zones = Zone::where('city_id', $cityId)->get();
        return response()->json($zones);
    }

    /**
     * Get districts by zone
     */
    public function getDistrictsByZone($zoneId)
    {
        $districts = District::where('zone_id', $zoneId)->get();
        return response()->json($districts);
    }
}

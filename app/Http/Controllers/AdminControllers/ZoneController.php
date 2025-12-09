<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\City;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::with('city')
                     ->withCount(['districts', 'addresses'])
                     ->orderBy('zoneName')
                     ->paginate(20);
        return view('admin.pages.zones.index', compact('zones'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'city_id' => 'required|exists:cities,id',
            'zoneId' => 'required|string|max:255',
            'zoneName' => 'required|string|max:255',
            'zoneOtherName' => 'nullable|string|max:255',
            'pickupAvailability' => 'nullable|boolean',
            'dropOffAvailability' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Zone::create([
            'city_id' => $request->city_id,
            'zoneId' => $request->zoneId,
            'zoneName' => $request->zoneName,
            'zoneOtherName' => $request->zoneOtherName,
            'pickupAvailability' => $request->pickupAvailability ?? false,
            'dropOffAvailability' => $request->dropOffAvailability ?? false,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.zones.index')->with('success', 'Zone created successfully');
    }

    public function update(Request $request, $id)
    {
        $zone = Zone::findOrFail($id);
        
        $validator = validator()->make($request->all(), [
            'city_id' => 'required|exists:cities,id',
            'zoneId' => 'required|string|max:255',
            'zoneName' => 'required|string|max:255',
            'zoneOtherName' => 'nullable|string|max:255',
            'pickupAvailability' => 'nullable|boolean',
            'dropOffAvailability' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $zone->update([
            'city_id' => $request->city_id,
            'zoneId' => $request->zoneId,
            'zoneName' => $request->zoneName,
            'zoneOtherName' => $request->zoneOtherName,
            'pickupAvailability' => $request->pickupAvailability ?? false,
            'dropOffAvailability' => $request->dropOffAvailability ?? false,
            'is_active' => $request->is_active ?? false,
        ]);

        return redirect()->route('admin.zones.index')->with('success', 'Zone updated successfully');
    }

    public function destroy($id)
    {
        $zone = Zone::findOrFail($id);
        
        // Check if zone has districts or addresses
        if ($zone->districts()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete zone with existing districts');
        }
        
        if ($zone->addresses()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete zone with existing addresses');
        }
        
        $zone->delete();

        return redirect()->route('admin.zones.index')->with('success', 'Zone deleted successfully');
    }
}

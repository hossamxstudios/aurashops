<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\City;
use App\Models\Zone;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::with(['zone.city'])
                             ->withCount('addresses')
                             ->orderBy('districtName')
                             ->paginate(20);
        return view('admin.pages.districts.index', compact('districts'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'zone_id' => 'required|exists:zones,id',
            'districtId' => 'required|string|max:255',
            'districtName' => 'required|string|max:255',
            'districtOtherName' => 'nullable|string|max:255',
            'pickupAvailability' => 'nullable|boolean',
            'dropOffAvailability' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        District::create([
            'zone_id' => $request->zone_id,
            'districtId' => $request->districtId,
            'districtName' => $request->districtName,
            'districtOtherName' => $request->districtOtherName,
            'pickupAvailability' => $request->pickupAvailability ?? false,
            'dropOffAvailability' => $request->dropOffAvailability ?? false,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.districts.index')->with('success', 'District created successfully');
    }

    public function update(Request $request, $id)
    {
        $district = District::findOrFail($id);
        
        $validator = validator()->make($request->all(), [
            'zone_id' => 'required|exists:zones,id',
            'districtId' => 'required|string|max:255',
            'districtName' => 'required|string|max:255',
            'districtOtherName' => 'nullable|string|max:255',
            'pickupAvailability' => 'nullable|boolean',
            'dropOffAvailability' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $district->update([
            'zone_id' => $request->zone_id,
            'districtId' => $request->districtId,
            'districtName' => $request->districtName,
            'districtOtherName' => $request->districtOtherName,
            'pickupAvailability' => $request->pickupAvailability ?? false,
            'dropOffAvailability' => $request->dropOffAvailability ?? false,
            'is_active' => $request->is_active ?? false,
        ]);

        return redirect()->route('admin.districts.index')->with('success', 'District updated successfully');
    }

    public function destroy($id)
    {
        $district = District::findOrFail($id);
        
        // Check if district has addresses
        if ($district->addresses()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete district with existing addresses');
        }
        
        $district->delete();

        return redirect()->route('admin.districts.index')->with('success', 'District deleted successfully');
    }
}

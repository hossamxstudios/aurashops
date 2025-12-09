<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Zone;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller {

    public function index(){
        $cities = City::withCount(['zones', 'districts', 'addresses'])
                      ->orderBy('cityName')
                      ->paginate(20);
        return view('admin.pages.locations.index', compact('cities'));
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'cityId' => 'required|string|max:255|unique:cities,cityId',
            'cityName' => 'required|string|max:255',
            'cityOtherName' => 'nullable|string|max:255',
            'cityCode' => 'required|string|max:255',
            'zones' => 'nullable|array',
            'zones.*.zoneId' => 'required_with:zones|string|max:255',
            'zones.*.zoneName' => 'required_with:zones|string|max:255',
            'zones.*.zoneOtherName' => 'nullable|string|max:255',
            'zones.*.districts' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            // Create city
            $city = City::create([
                'cityId' => $request->cityId,
                'cityName' => $request->cityName,
                'cityOtherName' => $request->cityOtherName,
                'cityCode' => $request->cityCode,
            ]);

            // Create zones and districts
            if ($request->has('zones')) {
                foreach ($request->zones as $zoneData) {
                    $zone = Zone::create([
                        'city_id' => $city->id,
                        'zoneId' => $zoneData['zoneId'],
                        'zoneName' => $zoneData['zoneName'],
                        'zoneOtherName' => $zoneData['zoneOtherName'] ?? null,
                        'pickupAvailability' => isset($zoneData['pickupAvailability']),
                        'dropOffAvailability' => isset($zoneData['dropOffAvailability']),
                        'is_active' => true,
                    ]);

                    // Create districts for this zone
                    if (isset($zoneData['districts']) && is_array($zoneData['districts'])) {
                        foreach ($zoneData['districts'] as $districtData) {
                            District::create([
                                'zone_id' => $zone->id,
                                'districtId' => $districtData['districtId'],
                                'districtName' => $districtData['districtName'],
                                'districtOtherName' => $districtData['districtOtherName'] ?? null,
                                'pickupAvailability' => isset($districtData['pickupAvailability']),
                                'dropOffAvailability' => isset($districtData['dropOffAvailability']),
                                'is_active' => true,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.locations.index')->with('success', 'Location created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create location: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id){
        $city = City::with(['zones.districts'])->findOrFail($id);
        return view('admin.pages.locations.show', compact('city'));
    }

    public function view($id){
        $city = City::with(['zones.districts'])->findOrFail($id);
        return response()->json([
            'id' => $city->id,
            'cityId' => $city->cityId,
            'cityName' => $city->cityName,
            'cityOtherName' => $city->cityOtherName,
            'cityCode' => $city->cityCode,
            'zones' => $city->zones->map(function($zone) {
                return [
                    'id' => $zone->id,
                    'zoneId' => $zone->zoneId,
                    'zoneName' => $zone->zoneName,
                    'zoneOtherName' => $zone->zoneOtherName,
                    'pickupAvailability' => $zone->pickupAvailability,
                    'dropOffAvailability' => $zone->dropOffAvailability,
                    'is_active' => $zone->is_active,
                    'districts_count' => $zone->districts->count(),
                    'districts' => $zone->districts->map(function($district) {
                        return [
                            'id' => $district->id,
                            'districtId' => $district->districtId,
                            'districtName' => $district->districtName,
                            'districtOtherName' => $district->districtOtherName,
                            'pickupAvailability' => $district->pickupAvailability,
                            'dropOffAvailability' => $district->dropOffAvailability,
                            'is_active' => $district->is_active,
                        ];
                    })
                ];
            })
        ]);
    }

    public function edit($id){
        $city = City::findOrFail($id);
        return response()->json($city);
    }

    public function update(Request $request, $id){
        $city = City::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'cityId' => 'required|string|max:255|unique:cities,cityId,' . $id,
            'cityName' => 'required|string|max:255',
            'cityOtherName' => 'nullable|string|max:255',
            'cityCode' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $city->update($request->all());
        return redirect()->route('admin.locations.show', $id)->with('success', 'City updated successfully');
    }

    public function destroy($id){
        $city = City::findOrFail($id);
        DB::beginTransaction();
        try {
            // Delete all districts through zones
            foreach ($city->zones as $zone) {
                $zone->districts()->delete();
            }
            // Delete all zones
            $city->zones()->delete();
            // Delete city
            $city->delete();
            DB::commit();
            return redirect()->route('admin.locations.index')->with('success', 'City and all related data deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete city: ' . $e->getMessage());
        }
    }

    public function importJson(Request $request){
        try {
            $jsonData = $request->input('jsonData');
            if (is_string($jsonData)) {
                $data = json_decode($jsonData, true);
            } else {
                $data = $jsonData;
            }
            if (!$data || !isset($data['success']) || !$data['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON format or unsuccessful response'
                ], 400);
            }
            if (!isset($data['data']) || !is_array($data['data'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data array found in JSON'
                ], 400);
            }
            DB::beginTransaction();
            $citiesCount = 0;
            $zonesCount = 0;
            $districtsCount = 0;
            foreach ($data['data'] as $cityData) {
                // Insert or update city
                $city = City::updateOrCreate(
                    ['cityId' => $cityData['cityId']],
                    [
                        'cityName' => $cityData['cityName'],
                        'cityOtherName' => $cityData['cityOtherName'] ?? null,
                        'cityCode' => $cityData['cityCode'],
                    ]
                );
                if ($city->wasRecentlyCreated) {
                    $citiesCount++;
                }
                // Process districts (which contain zone and district data)
                if (isset($cityData['districts']) && is_array($cityData['districts'])) {
                    $processedZones = [];
                    foreach ($cityData['districts'] as $districtData) {
                        // Insert or update zone (only once per unique zoneId)
                        if (!isset($processedZones[$districtData['zoneId']])) {
                            $zone = Zone::updateOrCreate(
                                [
                                    'city_id' => $city->id,
                                    'zoneId' => $districtData['zoneId']
                                ],
                                [
                                    'zoneName' => $districtData['zoneName'],
                                    'zoneOtherName' => $districtData['zoneOtherName'] ?? null,
                                    'pickupAvailability' => true,
                                    'dropOffAvailability' => true,
                                    'is_active' => true,
                                ]
                            );
                            if ($zone->wasRecentlyCreated) {
                                $zonesCount++;
                            }
                            $processedZones[$districtData['zoneId']] = $zone;
                        } else {
                            $zone = $processedZones[$districtData['zoneId']];
                        }
                        // Insert or update district
                        $district = District::updateOrCreate(
                            [
                                'zone_id' => $zone->id,
                                'districtId' => $districtData['districtId']
                            ],
                            [
                                'districtName' => $districtData['districtName'],
                                'districtOtherName' => $districtData['districtOtherName'] ?? null,
                                'pickupAvailability' => $districtData['pickupAvailability'] ?? false,
                                'dropOffAvailability' => $districtData['dropOffAvailability'] ?? false,
                                'is_active' => true,
                            ]
                        );

                        if ($district->wasRecentlyCreated) {
                            $districtsCount++;
                        }
                    }
                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Import completed successfully',
                'stats' => [
                    'cities' => $citiesCount,
                    'zones' => $zonesCount,
                    'districts' => $districtsCount,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createZone(Request $request){
        $validator = validator()->make($request->all(), [
            'city_id' => 'required|exists:cities,id',
            'zoneId' => 'required|string|max:255',
            'zoneName' => 'required|string|max:255',
            'zoneOtherName' => 'nullable|string|max:255',
            'pickupAvailability' => 'nullable|boolean',
            'dropOffAvailability' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'districts' => 'nullable|array',
            'districts.*.districtId' => 'required_with:districts|string|max:255',
            'districts.*.districtName' => 'required_with:districts|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        DB::beginTransaction();
        try {
            // Create zone
            $zone = Zone::create([
                'city_id' => $request->city_id,
                'zoneId' => $request->zoneId,
                'zoneName' => $request->zoneName,
                'zoneOtherName' => $request->zoneOtherName,
                'pickupAvailability' => $request->pickupAvailability ?? false,
                'dropOffAvailability' => $request->dropOffAvailability ?? false,
                'is_active' => $request->is_active ?? true,
            ]);
            // Create districts if provided
            if ($request->has('districts') && is_array($request->districts)) {
                foreach ($request->districts as $districtData) {
                    District::create([
                        'zone_id' => $zone->id,
                        'districtId' => $districtData['districtId'],
                        'districtName' => $districtData['districtName'],
                        'districtOtherName' => $districtData['districtOtherName'] ?? null,
                        'pickupAvailability' => isset($districtData['pickupAvailability']),
                        'dropOffAvailability' => isset($districtData['dropOffAvailability']),
                        'is_active' => true,
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Zone created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create zone: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateZone(Request $request, $id){
        $zone = Zone::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'zoneId' => 'required|string|max:255',
            'zoneName' => 'required|string|max:255',
            'zoneOtherName' => 'nullable|string|max:255',
            'pickupAvailability' => 'nullable|boolean',
            'dropOffAvailability' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        $zone->update([
            'zoneId' => $request->zoneId,
            'zoneName' => $request->zoneName,
            'zoneOtherName' => $request->zoneOtherName,
            'pickupAvailability' => $request->pickupAvailability ?? false,
            'dropOffAvailability' => $request->dropOffAvailability ?? false,
            'is_active' => $request->is_active ?? false,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Zone updated successfully'
        ]);
    }

    public function destroyZone($id){
        $zone = Zone::findOrFail($id);
        DB::beginTransaction();
        try {
            // Delete all districts in this zone
            $zone->districts()->delete();
            // Delete zone
            $zone->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Zone and all related districts deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete zone: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateDistrict(Request $request, $id){
        $district = District::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'districtId' => 'required|string|max:255',
            'districtName' => 'required|string|max:255',
            'districtOtherName' => 'nullable|string|max:255',
            'pickupAvailability' => 'nullable|boolean',
            'dropOffAvailability' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        $district->update([
            'districtId' => $request->districtId,
            'districtName' => $request->districtName,
            'districtOtherName' => $request->districtOtherName,
            'pickupAvailability' => $request->pickupAvailability ?? false,
            'dropOffAvailability' => $request->dropOffAvailability ?? false,
            'is_active' => $request->is_active ?? false,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'District updated successfully'
        ]);
    }

    public function destroyDistrict($id){
        $district = District::findOrFail($id);
        // Check if district has addresses
        if ($district->addresses()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete district with existing addresses'
            ], 400);
        }
        $district->delete();
        return response()->json([
            'success' => true,
            'message' => 'District deleted successfully'
        ]);
    }

    public function createMultipleDistricts(Request $request){
        $validator = validator()->make($request->all(), [
            'zone_id' => 'required|exists:zones,id',
            'districts' => 'required|array|min:1',
            'districts.*.districtId' => 'required|string|max:255',
            'districts.*.districtName' => 'required|string|max:255',
            'districts.*.districtOtherName' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        DB::beginTransaction();
        try {
            $createdCount = 0;
            foreach ($request->districts as $districtData) {
                District::create([
                    'zone_id' => $request->zone_id,
                    'districtId' => $districtData['districtId'],
                    'districtName' => $districtData['districtName'],
                    'districtOtherName' => $districtData['districtOtherName'] ?? null,
                    'pickupAvailability' => isset($districtData['pickupAvailability']),
                    'dropOffAvailability' => isset($districtData['dropOffAvailability']),
                    'is_active' => true,
                ]);
                $createdCount++;
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "{$createdCount} district(s) added successfully"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to add districts: ' . $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Zone;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::withCount(['zones', 'addresses'])
                      ->orderBy('cityName')
                      ->paginate(20);
        return view('admin.pages.cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'cityId' => 'required|string|max:255|unique:cities,cityId',
            'cityName' => 'required|string|max:255',
            'cityOtherName' => 'nullable|string|max:255',
            'cityCode' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        City::create($request->all());

        return redirect()->route('admin.cities.index')->with('success', 'City created successfully');
    }

    public function update(Request $request, $id)
    {
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

        return redirect()->route('admin.cities.index')->with('success', 'City updated successfully');
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        
        // Check if city has zones or addresses
        if ($city->zones()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete city with existing zones');
        }
        
        if ($city->addresses()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete city with existing addresses');
        }
        
        $city->delete();

        return redirect()->route('admin.cities.index')->with('success', 'City deleted successfully');
    }

    public function importJson(Request $request)
    {
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
}

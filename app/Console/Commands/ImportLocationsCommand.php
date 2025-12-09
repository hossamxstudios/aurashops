<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;
use App\Models\Zone;
use App\Models\District;
use Illuminate\Support\Facades\DB;

class ImportLocationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:locations {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cities, zones, and districts from JSON file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        // Check if file exists
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        // Read and decode JSON
        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);

        if (!$data || !isset($data['success']) || !$data['success']) {
            $this->error('Invalid JSON format or unsuccessful response');
            return 1;
        }

        if (!isset($data['data']) || !is_array($data['data'])) {
            $this->error('No data array found in JSON');
            return 1;
        }

        $this->info('Starting import...');
        $progressBar = $this->output->createProgressBar(count($data['data']));

        DB::beginTransaction();

        try {
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

                $progressBar->advance();
            }

            DB::commit();
            $progressBar->finish();

            $this->newLine(2);
            $this->info('Import completed successfully!');
            $this->info("Cities created: {$citiesCount}");
            $this->info("Zones created: {$zonesCount}");
            $this->info("Districts created: {$districtsCount}");

            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->newLine();
            $this->error('Import failed: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }
    }
}

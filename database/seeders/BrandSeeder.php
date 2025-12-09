<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create brands with some featured
        Brand::factory()->count(15)->create();

        // Create some featured brands
        Brand::factory()->count(5)->create([
            'is_feature' => true,
        ]);
    }
}

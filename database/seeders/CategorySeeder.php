<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create parent categories
        $parentCategories = Category::factory()->count(5)->create([
            'parent_id' => null,
        ]);

        // Create child categories for each parent
        $parentCategories->each(function ($parent) {
            Category::factory()->count(rand(2, 4))->create([
                'parent_id' => $parent->id,
            ]);
        });

        // Create some standalone categories without parents
        Category::factory()->count(3)->create([
            'parent_id' => null,
        ]);
    }
}

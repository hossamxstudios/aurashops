<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();
        
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'details' => fake()->optional()->paragraph(),
            'website' => fake()->optional()->url(),
            'image' => null,
            'is_active' => fake()->boolean(85),
            'is_feature' => fake()->boolean(20),
        ];
    }
}

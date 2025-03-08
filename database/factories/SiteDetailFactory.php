<?php

namespace Database\Factories;

use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SiteDetail>
 */
class SiteDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site_id'       => Site::factory(),
            'keyword'       => fake()->name,
            'title'         => fake()->text,
            'rank'          => fake()->numberBetween(1, 10)
        ];
    }
}

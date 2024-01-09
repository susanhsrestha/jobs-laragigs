<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(), 
            'tags' => 'laravel, javascript, api',
            'company' => fake()->company(),
            'location' => fake()->city(),
            'email' => fake()->email(),
            'website' => fake()->url(),
            'description' => fake()->paragraph()
        ];
    }
}

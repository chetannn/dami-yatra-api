<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'vendor_id' => Vendor::factory(),
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(5),
            'ad_end_date' => now()->format('Y-m-d'),
            'is_published' => false,
            'price' => $this->faker->randomDigit,
            'duration' => '4 Night 5 Days'
        ];
    }
}

<?php

namespace Database\Factories;

use Faker\Provider\Biased;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MusicAlbum>
 */
class MusicAlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(),
            'ean' => fake()->ean13(),
            'duration' => fake()->time(),
            'volumes' => fake()->biasedNumberBetween(1, 2, 'exp'),
        ];
    }
}

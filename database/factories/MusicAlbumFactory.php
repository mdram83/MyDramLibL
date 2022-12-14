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
            'ean' => rand(1, 100) > 20 ? fake()->ean13() : null,
            'duration' => rand(1, 100) > 50 ? fake()->time() : null,
            'volumes' => rand(1, 100) > 30 ? fake()->biasedNumberBetween(1, 2, 'exp') : null,
        ];
    }
}

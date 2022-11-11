<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'isbn' => rand(1, 100) > 10 ? fake()->isbn13() : null,
            'series' => rand(1, 100) > 20 ? fake()->sentence(4) : null,
            'volume' => rand(1, 100) > 30 ? fake()->numberBetween(1, 3) : null,
            'pages' => rand(1, 100) > 40 ? fake()->numberBetween(50, 900) : null,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
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
            'published_at' => rand(1, 100) > 20 ? fake()->year() : null,
            'thumbnail' => rand(1, 100) > 30
                ? 'https://api.lorem.space/image/book?w=150&h=220&hash=' . fake()->numberBetween(10000000, 99999999)
                : null,
            'comment' => fake()->paragraph(8),
        ];
    }
}

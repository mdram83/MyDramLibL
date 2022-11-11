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
            'published_at' => rand(1, 100) > 50 ? fake()->year() : null,
            'thumbnail' => rand(1, 100) > 20
                ? 'https://api.lorem.space/image/book?w=150&h=220&hash=' . md5(fake()->word())
                : null,
            'comment' => fake()->paragraph(),
        ];
    }
}

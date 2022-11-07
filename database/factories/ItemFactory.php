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
            'published_at' => 2012,
            'thumbnail' => "https://m.media-amazon.com/images/I/51ABc0hukNL._SX384_BO1,204,203,200_.jpg",
        ];
    }
}

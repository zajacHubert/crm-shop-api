<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'product_name' => implode(' ', $this->faker->words(rand(2, 4))),
            'product_desc' => $this->faker->text(200),
            'product_category' => $this->faker->randomElement(['regular', 'bargain', 'sale', 'newest']),
            'product_price' => $this->faker->randomFloat(2, 100, 500),
        ];
    }
}

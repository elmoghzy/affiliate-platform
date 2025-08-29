<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'name' => [
                'en' => $name,
                'ar' => 'منتج تجريبي ' . $this->faker->randomNumber(2),
            ],
            'slug' => Str::slug($name),
            'description' => [
                'en' => $this->faker->sentence(),
                'ar' => 'وصف تجريبي للمنتج.',
            ],
            'price' => $this->faker->randomFloat(2, 100, 2000),
            'is_active' => true,
        ];
    }
}

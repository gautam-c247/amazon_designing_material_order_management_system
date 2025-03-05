<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'brand_id' => Brand::factory(),
            'user_id' => 1,
            'description' => $this->faker->paragraph,
            'service_status' => $this->faker->randomElement(['1', '0']),
        ];
    }
}

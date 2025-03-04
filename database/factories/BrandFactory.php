<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'user_id' => 1, // This will be overridden by the seeder
            'category_id' => 1, // This will be overridden by the seeder
            'logo' => $this->faker->imageUrl(100, 100, 'business', true, 'Faker'),
            'website_url' => $this->faker->url,
            'about' => $this->faker->paragraph,
            'pronunciation' => $this->faker->word,
            'instagram_url' => $this->faker->url,
        ];
    }
}

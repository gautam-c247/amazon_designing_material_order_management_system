<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Category;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id')->toArray();

        if (empty($categories)) {
            $this->command->info('No categories found. Please run the CategorySeeder first.');
            return;
        }

        Brand::factory()->count(5)->create([
            'category_id' => function () use ($categories) {
                return $categories[array_rand($categories)];
            },
        ]);
    }
}

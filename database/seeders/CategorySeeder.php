<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Fashion', 'status' => '1'],
            ['name' => 'Electronics', 'status' => '1'],
            ['name' => 'Home & Garden', 'status' => '1'],
            ['name' => 'Health & Beauty', 'status' => '1'],
            ['name' => 'Sports', 'status' => '1'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

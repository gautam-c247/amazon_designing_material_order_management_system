<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Electronics',
            'Books',
            'Clothing',
            'Home Appliances',
            'Sports',
            'Toys',
            'Furniture',
            'Groceries',
            'Health & Beauty',
            'Jewelry',
            'Footwear',
            'Automobiles',
            'Mobile Phones',
            'Laptops',
            'Cameras',
            'Accessories',
            'Gaming',
            'Musical Instruments',
            'Outdoor Equipment',
            'Stationery',
            'Art Supplies',
            'Pet Supplies',
            'Gardening Tools',
            'Kitchenware',
            'Bedding',
            'Travel Accessories',
            'Bags',
            'Watches',
            'Eyewear',
            'Office Supplies',
            'Fitness Equipment',
            'Skincare',
            'Haircare',
            'Baby Products',
            'School Supplies',
            'Party Supplies',
            'Craft Materials',
            'Lighting',
            'Hobbies',
            'Collectibles',
            'Antiques',
            'Footwear Accessories',
            'Sportswear',
            'Swimwear',
            'Winter Clothing',
            'Summer Wear',
            'Smart Home Devices',
            'Bookshelves',
            'Wine & Spirits',
            'Coffee Supplies',
            'Baking Essentials',
            'Cycling Gear',
            'Hiking Equipment',
            'Fishing Gear',
            'Camping Supplies',
            'Luxury Goods',
            'Decor Items',
            'Wall Art',
            'Rugs & Carpets',
            'Curtains & Blinds',
            'Home Security',
            'Cleaning Supplies',
            'Laundry Essentials',
            'Car Accessories',
            'Motorbike Gear',
            'Safety Equipment',
            'Software',
            'Networking Devices',
            '3D Printers',
            'Printers & Scanners',
            'Board Games',
            'Puzzles',
            'Toys for Kids',
            'Educational Toys',
            'Plush Toys',
            'Action Figures',
            'Video Games',
            'Virtual Reality',
            'Drones',
            'RC Vehicles',
            'Model Kits',
            'Anime Merch',
            'Pop Culture Collectibles',
            'Home Improvement Tools',
            'DIY Kits',
            'Construction Materials',
            'Paint & Coatings',
            'Plumbing Supplies',
            'Electrical Equipment',
            'Books for Teens',
            'Books for Kids',
            'Self-help Books',
            'Fiction Books',
            'Non-fiction Books',
            'Travel Guides',
            'Cookbooks',
            'Biographies',
            'Science Books',
            'History Books'
        ];
        return [
            'name' => $this->faker->unique()->randomElement($categories),
            'parent_id' => Category::inRandomOrder()->first()->id ?? null
        ];
    }
}

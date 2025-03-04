<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'service_id' => Service::factory(),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'guidelines' => $this->faker->paragraph(),
            'notes' => $this->faker->paragraph(),
            'estimated_delivery_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Pending', 'In progress', 'Completed', 'Ready for review']),
        ];
    }
}

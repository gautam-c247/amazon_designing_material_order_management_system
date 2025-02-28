<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'category' => $this->faker->randomElement(['Design', 'Marketing', 'Development']),
            'status' => $this->faker->randomElement(['0', '1']),
            'credit' => $this->faker->numberBetween(1, 100),
        ];
    }
}

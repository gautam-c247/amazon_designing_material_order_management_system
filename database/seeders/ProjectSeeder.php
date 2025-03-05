<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::factory()->count(10)->create();
        Project::factory()->count(50)->create([
            'product_id' => 1,
        ])->each(function ($project) {
            $project->service()->attach([1, 2, 3]);
        });
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // this code will get all the files from the current namespace treat it as a seeder
        // $seeders = scandir(database_path('seeders'));
        // foreach ($seeders as $seeder) {
        //     if ($seeder === '.' || $seeder === '..' || $seeder === 'DatabaseSeeder.php') {
        //         continue;
        //     }
        //     $seederClass = 'Database\\Seeders\\' . pathinfo($seeder, PATHINFO_FILENAME);
        //     if (class_exists($seederClass)) {
        //         $this->call($seederClass);
        //     }
        // }

        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
        ]);
    }
}

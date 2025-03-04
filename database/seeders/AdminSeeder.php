<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@codebank.com',
            'password' => 'Codebank@123',
        ]);
        $role = Role::create(['name' => 'admin']);
        Role::create(['name' => 'merchant']);
        Role::create(['name' => 'designer']);
        $user->assignRole($role);

    }
}

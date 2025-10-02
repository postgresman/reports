<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::insert([
            ['name' => 'admin'],
            ['name' => 'user']
        ]);

        User::insert([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'role_id' => 1,
            'password' => bcrypt('password'),
        ]);
    }
}

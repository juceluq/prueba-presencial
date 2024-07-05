<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Evento::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'admin@example.com',
            'role' => 'Admin',
        ]);
        User::factory()->create([
            'name' => 'User',
            'username' => 'user',
            'password' => bcrypt('user'),
            'email' => 'user@example.com',
            'role' => 'User',
        ]);
    }
}

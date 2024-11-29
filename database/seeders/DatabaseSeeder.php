<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a persistent admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@ttms.com',
            'password' => Hash::make('@Acesso2024'),
            'role' => 'admin'
        ]);

        // Optional: Create additional default users
        User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@ttms.com',
            'password' => Hash::make('@Acesso2024'),
            'role' => 'manager'
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'CrateOS Admin',
            'email' => 'admin@crateos.com',
            'password' => Hash::make('carmee@crateOS2025'),
            'role' => 'admin'
        ]);
    }
}

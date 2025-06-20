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
            'email' => 'admin@crateonscene.com',
            'password' => Hash::make('crateonscene'),
            'email_verified_at' => now(),
            'role' => 'admin'
        ]);
    }
}

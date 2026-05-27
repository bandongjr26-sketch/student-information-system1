<?php

namespace Database\Seeders;

use App\Models\UserAccounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        UserAccounts::updateOrCreate(
            ['username' => 'admin123'],
            [
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => 1,
                'must_change_password' => false,
            ]
        );
    }
}

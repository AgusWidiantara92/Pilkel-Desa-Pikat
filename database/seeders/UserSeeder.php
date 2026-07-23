<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@pilkelpikat.id'],
            [
                'name' => 'Administrator Pilkel Pikat',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Panitia User
        User::updateOrCreate(
            ['email' => 'panitia@pilkelpikat.id'],
            [
                'name' => 'Panitia Pilkel Pikat',
                'password' => Hash::make('password123'),
                'role' => 'panitia',
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperuserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superuserEmail = env('SUPERUSER_EMAIL', 'ClarkNav2024@gmail.com');
        $superuserPassword = env('SUPERUSER_PASSWORD', 'SuperClarkNav@2024!');

        // Check if the superuser already exists
        $superuser = User::where('email', $superuserEmail)->first();

        if (!$superuser) {
            // Create the superuser
            User::create([
                'first_name' => 'Super',
                'last_name' => 'User',
                'email' => $superuserEmail,
                'password' => Hash::make($superuserPassword),
                'isAdmin' => true,
                'isUser' => false,
            ]);
        }
    }
}
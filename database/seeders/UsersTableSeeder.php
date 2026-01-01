<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create example users for each role
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'profile' => null,
        ]);

        User::create([
            'username' => 'instructor',
            'email' => 'instructor@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_INSTRUCTOR,
            'profile' => null,
        ]);

        User::create([
            'username' => 'student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STUDENT,
            'profile' => null,
        ]);
    }
}

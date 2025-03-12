<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersData = [
            ['name' => 'John Doe', 'role' => 'Admin', 'email' => 'john@example.com', 'phone_number' => '1234567890'],
            ['name' => 'Jane Smith', 'role' => 'user', 'email' => 'jane@example.com', 'phone_number' => '2345678901'],
            ['name' => 'Emily Johnson', 'role' => 'user', 'email' => 'emily@example.com', 'phone_number' => '3456789012'],
            ['name' => 'Michael Brown', 'role' => 'Admin', 'email' => 'michael@example.com', 'phone_number' => '4567890123'],
            ['name' => 'Jessica Davis', 'role' => 'user', 'email' => 'jessica@example.com', 'phone_number' => '5678901234'],
            ['name' => 'David Wilson', 'role' => 'Admin', 'email' => 'david@example.com', 'phone_number' => '6789012345'],
            ['name' => 'Laura Moore', 'role' => 'user', 'email' => 'laura@example.com', 'phone_number' => '7890123456'],
            ['name' => 'Daniel Taylor', 'role' => 'Admin', 'email' => 'daniel@example.com', 'phone_number' => '8901234567'],
            ['name' => 'Lisa Anderson', 'role' => 'user', 'email' => 'lisa@example.com', 'phone_number' => '9012345678'],
            ['name' => 'Paul Harris', 'role' => 'Admin', 'email' => 'paul@example.com', 'phone_number' => '0123456789'],
        ];
        

        foreach ($usersData as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'), // default password
                'role' => $userData['role'],
                'phone_number' => $userData['phone_number'],
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $membersData = [
            ['name' => 'John Doe', 'role' => 'Gym Member', 'phone_number' => '1234567890', 'email' => 'john@example.com', 'gender' => 'Male', 'height' => '180', 'weight' => '75'],
            ['name' => 'Jane Smith', 'role' => 'Trainer', 'phone_number' => '2345678901', 'email' => 'jane@example.com', 'gender' => 'Female', 'height' => '165', 'weight' => '60'],
            ['name' => 'Emily Johnson', 'role' => 'Admin', 'phone_number' => '3456789012', 'email' => 'emily@example.com', 'gender' => 'Female', 'height' => '170', 'weight' => '65'],
            ['name' => 'Michael Brown', 'role' => 'Gym Member', 'phone_number' => '4567890123', 'email' => 'michael@example.com', 'gender' => 'Male', 'height' => '175', 'weight' => '80'],
            ['name' => 'Jessica Davis', 'role' => 'Gym Member', 'phone_number' => '5678901234', 'email' => 'jessica@example.com', 'gender' => 'Female', 'height' => '160', 'weight' => '55'],
            ['name' => 'David Wilson', 'role' => 'Trainer', 'phone_number' => '6789012345', 'email' => 'david@example.com', 'gender' => 'Male', 'height' => '185', 'weight' => '85'],
            ['name' => 'Laura Moore', 'role' => 'Gym Member', 'phone_number' => '7890123456', 'email' => 'laura@example.com', 'gender' => 'Female', 'height' => '165', 'weight' => '60'],
            ['name' => 'Daniel Taylor', 'role' => 'Admin', 'phone_number' => '8901234567', 'email' => 'daniel@example.com', 'gender' => 'Male', 'height' => '180', 'weight' => '75'],
            ['name' => 'Lisa Anderson', 'role' => 'Gym Member', 'phone_number' => '9012345678', 'email' => 'lisa@example.com', 'gender' => 'Female', 'height' => '160', 'weight' => '55'],
            ['name' => 'Paul Harris', 'role' => 'Trainer', 'phone_number' => '0123456789', 'email' => 'paul@example.com', 'gender' => 'Male', 'height' => '175', 'weight' => '70'],
        ];

        foreach ($membersData as $memberData) {
            Member::create($memberData);
        }
    }
}

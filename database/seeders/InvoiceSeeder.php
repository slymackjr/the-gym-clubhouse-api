<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invoiceData = [
            [
                'user_name' => 'John Doe',
                'user_phone' => '1234567890',
                'user_email' => 'john.doe@example.com',
                'member_name' => 'Jane Smith',
                'member_phone' => '0987654321',
                'amount_paid' => 200,
                'status' => 'paid',
                'package_name' => 'Monthly Membership',
                'discount_percentage' => 10,
                'start_date' => '2023-09-01',
                'end_date' => '2023-09-30',
                'member_id' => 1 // You can set this to an actual member ID
            ],
            [
                'user_name' => 'Alice Johnson',
                'user_phone' => '2345678901',
                'user_email' => 'alice.j@example.com',
                'member_name' => 'Bob Brown',
                'member_phone' => '8765432109',
                'amount_paid' => 150,
                'status' => 'unpaid',
                'package_name' => 'Quarterly Membership',
                'discount_percentage' => 5,
                'start_date' => '2023-08-01',
                'end_date' => '2023-10-31',
                'member_id' => 2 // Update member_id
            ],
            [
                'user_name' => 'Michael Green',
                'user_phone' => '3456789012',
                'user_email' => 'michael.g@example.com',
                'member_name' => 'Sara White',
                'member_phone' => '7654321098',
                'amount_paid' => 300,
                'status' => 'paid',
                'package_name' => 'Annual Membership',
                'discount_percentage' => 15,
                'start_date' => '2023-07-01',
                'end_date' => '2024-06-30',
                'member_id' => 3 // Update member_id
            ],
            [
                'user_name' => 'Chris Lee',
                'user_phone' => '4567890123',
                'user_email' => 'chris.lee@example.com',
                'member_name' => 'Anna Martin',
                'member_phone' => '6543210987',
                'amount_paid' => 250,
                'status' => 'unpaid',
                'package_name' => 'Monthly Membership',
                'discount_percentage' => 10,
                'start_date' => '2023-10-01',
                'end_date' => '2023-10-31',
                'member_id' => 4 // Update member_id
            ],
            [
                'user_name' => 'Emma Brown',
                'user_phone' => '5678901234',
                'user_email' => 'emma.b@example.com',
                'member_name' => 'Liam Cooper',
                'member_phone' => '5432109876',
                'amount_paid' => 400,
                'status' => 'paid',
                'package_name' => 'Bi-Annual Membership',
                'discount_percentage' => 12,
                'start_date' => '2023-05-01',
                'end_date' => '2023-10-31',
                'member_id' => 5 // Update member_id
            ],
            [
                'user_name' => 'David Kim',
                'user_phone' => '6789012345',
                'user_email' => 'david.k@example.com',
                'member_name' => 'Noah Turner',
                'member_phone' => '4321098765',
                'amount_paid' => 100,
                'status' => 'unpaid',
                'package_name' => 'Weekly Membership',
                'discount_percentage' => 3,
                'start_date' => '2023-11-01',
                'end_date' => '2023-11-07',
                'member_id' => 6 // Update member_id
            ],
            [
                'user_name' => 'Sophia King',
                'user_phone' => '7890123456',
                'user_email' => 'sophia.k@example.com',
                'member_name' => 'Oliver Hill',
                'member_phone' => '3210987654',
                'amount_paid' => 220,
                'status' => 'paid',
                'package_name' => 'Monthly Membership',
                'discount_percentage' => 8,
                'start_date' => '2023-06-01',
                'end_date' => '2023-06-30',
                'member_id' => 7 // Update member_id
            ],
            [
                'user_name' => 'Lucas Adams',
                'user_phone' => '8901234567',
                'user_email' => 'lucas.a@example.com',
                'member_name' => 'Ethan Scott',
                'member_phone' => '2109876543',
                'amount_paid' => 130,
                'status' => 'unpaid',
                'package_name' => 'Monthly Membership',
                'discount_percentage' => 0,
                'start_date' => '2023-07-01',
                'end_date' => '2023-07-31',
                'member_id' => 8 // Update member_id
            ],
            [
                'user_name' => 'Grace Thompson',
                'user_phone' => '9012345678',
                'user_email' => 'grace.t@example.com',
                'member_name' => 'Mason Brooks',
                'member_phone' => '1098765432',
                'amount_paid' => 180,
                'status' => 'paid',
                'package_name' => 'Quarterly Membership',
                'discount_percentage' => 6,
                'start_date' => '2023-03-01',
                'end_date' => '2023-05-31',
                'member_id' => 9 // Update member_id
            ],
            [
                'user_name' => 'Henry Wilson',
                'user_phone' => '0123456789',
                'user_email' => 'henry.w@example.com',
                'member_name' => 'Ava Foster',
                'member_phone' => '9876543210',
                'amount_paid' => 500,
                'status' => 'unpaid',
                'package_name' => 'Annual Membership',
                'discount_percentage' => 20,
                'start_date' => '2023-12-01',
                'end_date' => '2024-11-30',
                'member_id' => 10 // Update member_id
            ],
        ];

        foreach ($invoiceData as $data) {
            Invoice::create($data);
        }
    }
}

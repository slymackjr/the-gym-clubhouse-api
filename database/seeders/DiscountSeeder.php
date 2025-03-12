<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discounts = [
            ['name' => 'None', 'percentage' => 0],
            ['name' => 'Couple', 'percentage' => 15],
            ['name' => 'Family', 'percentage' => 20],
            ['name' => 'Corporate', 'percentage' => 25],
        ];

        foreach ($discounts as $discount) {
            Discount::create($discount);
        }
    }
}

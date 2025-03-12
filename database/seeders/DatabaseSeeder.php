<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            MemberSeeder::class,
            DiscountSeeder::class,
            InvoiceSeeder::class,
            PackageSeeder::class,
            CompanySeeder::class,
        ]);
    }
}

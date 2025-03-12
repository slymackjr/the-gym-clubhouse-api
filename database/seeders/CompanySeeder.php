<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add a default company profile
        CompanyProfile::create([
            'company_name' => "4J's Fitness Center",
            'company_email' => 'contact@4jsfitness.com',
            'tin' => '123456789',
            'description' => 'Your ultimate fitness partner.',
            'address' => 'Temeke Street, Dar es Salaam, Tanzania',
            'phone' => '+255-123-456-789',
            'website' => 'https://4jsfitness.com',
            'founder' => 'John Doe',
            'manager' => 'Jane Doe',
            'account_name' => '4JS FITNESS CENTER',
            'account_number' => '61057119',
        ]);
    }
}

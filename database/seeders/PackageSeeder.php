<?php 
namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            ['name' => 'One Day', 'priceUSD' => 8, 'priceTZS' => 20000, 'duration' => 1],
            ['name' => 'Two Weeks', 'priceUSD' => 56, 'priceTZS' => 150000, 'duration' => 14],
            ['name' => 'One Month', 'priceUSD' => 112, 'priceTZS' => 300000, 'duration' => 30],
            ['name' => 'Three Months', 'priceUSD' => 303, 'priceTZS' => 800000, 'duration' => 90],
            ['name' => 'Six Months', 'priceUSD' => 525, 'priceTZS' => 1584000, 'duration' => 180],
            ['name' => 'Annual', 'priceUSD' => 1143, 'priceTZS' => 3060000, 'duration' => 365],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}

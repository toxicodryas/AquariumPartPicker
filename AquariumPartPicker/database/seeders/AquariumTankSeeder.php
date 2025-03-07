<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AquariumTank;

class AquariumTankSeeder extends Seeder
{
    public function run()
    {
        $tanks = [
            [
                'name' => 'Standard Aquarium',
                'brand' => 'Aqueon',
                'volume_gallons' => 20,
                'length_inches' => 24,
                'width_inches' => 12,
                'height_inches' => 16,
                'glass_type' => 'Regular',
                'description' => 'A standard 20-gallon aquarium, perfect for beginners.',
                'price' => 39.99,
            ],
            [
                'name' => 'Rimless Crystal Aquarium',
                'brand' => 'ADA',
                'volume_gallons' => 10,
                'length_inches' => 20,
                'width_inches' => 10,
                'height_inches' => 12,
                'glass_type' => 'Low-iron',
                'description' => 'Premium rimless tank with crystal clear glass.',
                'price' => 149.99,
            ],
            // Add more tanks as needed
        ];

        foreach ($tanks as $tank) {
            AquariumTank::create($tank);
        }
    }
}

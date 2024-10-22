<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $locations = [
            [
                'admin_id' => 1,
                'name' => 'Gudang 1',
                'max_radius' => 50,
                'lat' => -6.200000,
                'long' => 106.816666,
            ],
            [
                'admin_id' => 1,
                'name' => 'Kantor 1',
                'max_radius' => 50,
                'lat' => -6.250000,
                'long' => 106.850000,
            ],
            [
                'admin_id' => 1,
                'name' => 'Gudang 2',
                'max_radius' => 50,
                'lat' => -6.300000,
                'long' => 106.780000,
            ],
            [
                'admin_id' => 1,
                'name' => 'Kantor 2',
                'max_radius' => 50,
                'lat' => -6.350000,
                'long' => 106.700000,
            ],
            [
                'admin_id' => 1,
                'name' => 'Gudang 3',
                'max_radius' => 50,
                'lat' => -6.150000,
                'long' => 106.850000,
            ],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}


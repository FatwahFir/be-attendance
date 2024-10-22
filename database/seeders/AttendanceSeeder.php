<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $year = date('Y'); 
        $months = range(1, 10);
        $userIds = [1, 2, 3, 4, 5];

        foreach ($months as $month) {
            $entries = rand(20, 60);

            $startDate = "{$year}-{$month}-01";
            $endDate = date("Y-m-t", strtotime($startDate)); 

            for ($i = 0; $i < $entries; $i++) {
                DB::table('attendances')->insert([
                    'user_id' => $faker->randomElement($userIds),
                    'lat' => $faker->latitude,
                    'long' => $faker->longitude,
                    'type' => 'in',
                    'created_at' => $faker->dateTimeBetween($startDate, $endDate),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

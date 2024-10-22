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
        $year = date('Y'); // Menggunakan tahun ini
        $months = range(1, 10); // Dari Januari sampai Oktober
        $userIds = [1, 2, 3, 4, 5]; // User ID dari 1-5

        foreach ($months as $month) {
            // Tentukan berapa banyak data yang akan di-generate (20-60 data per bulan)
            $entries = rand(20, 60);

            for ($i = 0; $i < $entries; $i++) {
                DB::table('attendances')->insert([
                    'user_id' => $faker->randomElement($userIds),
                    'lat' => $faker->latitude,
                    'long' => $faker->longitude,
                    'type' => 'in',
                    'created_at' => $faker->dateTimeBetween("{$year}-{$month}-01", "{$year}-{$month}-t"),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

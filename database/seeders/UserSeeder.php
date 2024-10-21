<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Seeder untuk User dengan Role Admin
        $admin = User::create([
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Detail untuk Admin
        UserDetail::create([
            'user_id' => $admin->id,
            'name' => 'Admin User',
            'phone' => '081234567890',
        ]);

        // Seeder untuk User Biasa
        $user = User::create([
            'username' => 'user',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);

        // Detail untuk User Biasa
        UserDetail::create([
            'user_id' => $user->id,
            'name' => 'Regular User',
            'phone' => '089876543210',
        ]);
    }
}

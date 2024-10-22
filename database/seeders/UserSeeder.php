<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        try {
            DB::beginTransaction();
            $admin = User::create([
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]);
    
            UserDetail::create([
                'user_id' => $admin->id,
                'name' => 'Admin User',
                'phone' => '081234567890',
                'address' => '123 Admin St, Admin City, Admin Country', 
            ]);
    
            $usersData = [
                ['username' => 'user1', 'name' => 'John Smith', 'phone' => '089876543211', 'address' => '456 User St, User City, User Country'],
                ['username' => 'user2', 'name' => 'Emily Johnson', 'phone' => '089876543212', 'address' => '789 User St, User City, User Country'],
                ['username' => 'user3', 'name' => 'Michael Brown', 'phone' => '089876543213', 'address' => '101 User St, User City, User Country'],
                ['username' => 'user4', 'name' => 'Sophia Davis', 'phone' => '089876543214', 'address' => '202 User St, User City, User Country'],
                ['username' => 'user5', 'name' => 'James Wilson', 'phone' => '089876543215', 'address' => '303 User St, User City, User Country'],
            ];
    
            foreach ($usersData as $userData) {
                $user = User::create([
                    'username' => $userData['username'],
                    'password' => Hash::make('password'),
                    'role' => 'user'
                ]);
    
                UserDetail::create([
                    'user_id' => $user->id,
                    'name' => $userData['name'],
                    'phone' => $userData['phone'],
                    'address' => $userData['address'], // Menambahkan address
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            echo $th->getMessage();
        }
        
    }
}


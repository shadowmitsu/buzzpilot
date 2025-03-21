<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'superadmin',
                'email' => 'superadmin@example.com',
                'full_name' => 'Super Admin',
                'whatsapp_number' => '628123456789',
                'password' => Hash::make('superadmin'),
                'role' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'operator',
                'email' => 'operator@example.com',
                'full_name' => 'Operator User',
                'whatsapp_number' => '628987654321',
                'password' => Hash::make('operator'),
                'role' => 'operator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone_number' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Endricho',
            'email' => 'richofolabessy@gmail.com',
            'phone_number' => '08123456789',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
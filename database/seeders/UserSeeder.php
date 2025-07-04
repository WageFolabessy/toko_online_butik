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
            'email' => 'admin@butikdisel.com',
            'phone_number' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dedy Wahyudi',
            'email' => 'richofolabessy@gmail.com',
            'phone_number' => '08123456789',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
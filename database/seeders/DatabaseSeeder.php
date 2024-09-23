<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'merga12@gmail.com',
            'password' => Hash::make('merga1234'),
            // 'role' => 'admin', // Make sure this matches your role column
            'role_id' => 1, // Adjust according to your role_id logic
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Find or create the 'admin' role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Check if admin user already exists
        $adminUser = User::where('email', 'admin@example.com')->first();

        if (!$adminUser) {
            // Create an admin user if it doesn't exist
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('adminpassword'),
                'role_id' => $adminRole->id,
            ]);
        }
    }
}

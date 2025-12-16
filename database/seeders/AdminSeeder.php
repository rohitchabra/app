<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // 1. Create role if not exists
        // $adminRole = Role::firstOrCreate(
        //     ['name' => 'admin', 'guard_name' => 'web']
        // );

        // 2. Create admin user if not exists
        // $admin = User::firstOrCreate(
        //     ['email' => 'admin@gmail.com'],
        //     [
        //         'name' => 'admin',
        //         'password' => Hash::make('12345678'),
        //         'email_verified_at' => now(),
        //     ]
        // );

        // 3. Assign role
        // if (!$admin->hasRole('admin')) {
        //     $admin->assignRole('admin');
        // }
    }
}

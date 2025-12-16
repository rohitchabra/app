<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Create roles
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        $editorRole = Role::firstOrCreate([
            'name' => 'editor',
            'guard_name' => 'web',
        ]);

        // 2️⃣ Define permissions
        $permissions = [
            'manage users',
            'manage roles',
            'manage permissions',
            'manage trades',
        ];

        // 3️⃣ Create permissions
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        // 4️⃣ Assign ALL permissions to admin role
        $adminRole->syncPermissions($permissions);

        // 5️⃣ Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        // 6️⃣ Assign admin role to admin user
        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}

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
        $superadminRole = Role::firstOrCreate([
            'name' => 'SuperAdmin',
            'guard_name' => 'web',
        ]);

        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'User',
            'guard_name' => 'web',
        ]);

        // 2️⃣ Define permissions
        $permissions = [
            'view users',
            'edit users',
            'create users',
            'delete users',
            
            'create roles',
            'view roles',
            'edit roles',
            'delete roles',

            'create permissions',
            'view permissions',
            'edit permissions',
            'delete permissions',

            'create trades',
            'view trades',
            'edit trades',
            'delete trades',

            'create jobs',
            'view jobs',
            'edit jobs',
            'delete jobs',

            'create customers',
            'view customers',
            'edit customers',
            'delete customers',

            'view dashboard',
        ];

        // 2️⃣ Define permissions
        $user_permissions = [
            'view dashboard',
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
        $userRole->syncPermissions($user_permissions);

        // 5️⃣ Create super admin user
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'SuperAdmin',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        // 6️⃣ Assign user role to admin user
        if (! $superadmin->hasRole('SuperAdmin')) {
            $superadmin->assignRole('SuperAdmin');
        }

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

        // 5️⃣ Create admin user
        $user = User::firstOrCreate(
            ['email' => 'himanshu@gmail.com'],
            [
                'name' => 'Himanshu',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        // 6️⃣ Assign user role to admin user
        if (! $user->hasRole('user')) {
            $user->assignRole('user');
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'full_name' => 'Pyae Phyo Win',
                'nrc' => '12/KK/123456',
                'phone' => '0123456789',
                'address' => 'Yangon, Myanmar',
                'gender' => 'male',
                'date_of_birth' => '2000-01-01',
                'email' => 'superadmin@admin.com',
                'email_verified_at' => now(),
                'password' => 'password',
                'is_opened' => true,
                'status' => true,
            ],
        ];

        // 1. Find the role safely
        $role = Role::where('name', 'superadmin')->first();

        if ($role) {
            // 2. Sync permissions safely (syncPermissions handles duplicates automatically)
            $permissions = Permission::where('guard_name', 'web')->get();
            $role->syncPermissions($permissions);
            $role->revokePermissionTo('user-dashboard');

            foreach ($users as $user) {
                // 3. Use updateOrCreate to avoid "Duplicate Entry" errors
                $newUser = User::updateOrCreate(
                    ['email' => $user['email']], // Unique identifier to check
                    [
                        'name' => $user['name'],
                        'full_name' => $user['full_name'],
                        'nrc' => $user['nrc'],
                        'phone' => $user['phone'],
                        'address' => $user['address'],
                        'gender' => $user['gender'],
                        'date_of_birth' => $user['date_of_birth'],
                        'email_verified_at' => $user['email_verified_at'],
                        'password' => bcrypt($user['password']),
                        'is_opened' => $user['is_opened'],
                        'status' => $user['status'],
                    ]
                );

                // 4. Assign role only if they don't have it
                if (!$newUser->hasRole($role->name)) {
                    $newUser->assignRole($role->name);
                }
            }
        }
    }
}

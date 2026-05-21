<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'superadmin@test.com',
                'full_name' => 'Super Admin',
                'role' => 'Superadmin',
            ],
            [
                'email' => 'university@test.com',
                'full_name' => 'University Admin',
                'role' => 'University_Admin',
            ],
            [
                'email' => 'department@test.com',
                'full_name' => 'Department Admin',
                'role' => 'Department_Admin',
            ],
            [
                'email' => 'director@test.com',
                'full_name' => 'Program Director',
                'role' => 'Program_Director',
            ],
            [
                'email' => 'lecturer@test.com',
                'full_name' => 'Lecturer',
                'role' => 'Lecturer',
            ],
        ];

        foreach ($users as $item) {
            $user = User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'full_name' => $item['full_name'],
                    'password' => Hash::make('123456'),
                    'is_approved' => true,
                    'is_active' => true,
                ]
            );

            $role = Role::firstOrCreate([
                'role_name' => $item['role'],
            ]);

            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}

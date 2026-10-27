<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@inventory.test',
                'role' => 'admin',
                'password' => 'Admin12345!',
            ],
            [
                'name' => 'Staf Toko',
                'email' => 'staff@inventory.test',
                'role' => 'staff',
                'password' => 'Staff12345!',
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'role' => $data['role'],
                    'password' => Hash::make($data['password']),
                ]
            );
        }
    }
}

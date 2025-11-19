<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@mail.unej.ac.id',
                'nim' => null,
                'password' => Hash::make('password'),
                'role' => 'superadmin',
            ],
            [
                'name' => 'Admin TU',
                'email' => 'tu@mail.unej.ac.id',
                'nim' => null,
                'password' => Hash::make('password'),
                'role' => 'tu',
            ],
            [
                'name' => 'Admin BEM',
                'email' => 'bem@mail.unej.ac.id',
                'nim' => null,
                'password' => Hash::make('password'),
                'role' => 'bem',
            ],
            [
                'name' => 'Admin BPM',
                'email' => 'bpm@mail.unej.ac.id',
                'nim' => null,
                'password' => Hash::make('password'),
                'role' => 'bpm',
            ],
        ];

        foreach ($admins as $admin) {
            User::create($admin);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@polaris.com'],
            [
                'name'     => 'Admin Polaris',
                'email'    => 'admin@polaris.com',
                'password' => Hash::make('polaris123'),
                'role'     => 'kepala_cabang',
            ]
        );

        User::updateOrCreate(
            ['email' => 'gudang@polaris.com'],
            [
                'name'     => 'Staff Gudang',
                'email'    => 'gudang@polaris.com',
                'password' => Hash::make('polaris123'),
                'role'     => 'gudang',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pembukuan@polaris.com'],
            [
                'name'     => 'Staff Pembukuan',
                'email'    => 'pembukuan@polaris.com',
                'password' => Hash::make('polaris123'),
                'role'     => 'pembukuan',
            ]
        );
    }
}
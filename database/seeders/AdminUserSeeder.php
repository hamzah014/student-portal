<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::firstOrCreate(
            [
                'email' => 'admin@localhost.com',
            ],
            [
                'name' => 'Administrator',
                'role' => 'admin',
                'password' => Hash::make('1234'),
            ]
        );
    }
}

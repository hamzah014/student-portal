<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Lecturers
        User::factory()->count(5)->create([
            'role' => 'lecturer',
            'password' => Hash::make('1234')
        ])->each(function ($user) {
            $user->update([
                'refer_code' => $this->randomCode(6),
            ]);
        });

        // Students
        User::factory()->count(5)->create([
            'role' => 'student',
            'refer_code' => null,
            'password' => Hash::make('1234')
        ]);
    }

    private function randomCode(int $length = 6): string
    {
        return strtoupper(Str::random($length));
    }
    

}

<?php

namespace Database\Seeders;

use App\Models\ClassSubject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class ClassSubjectSeeder extends Seeder
{
    
    public function run(): void
    {
        // Get all lecturers
        $lecturers = User::where('role', 'lecturer')->pluck('id');

        if ($lecturers->isEmpty()) {
            $this->command->warn('No lecturers found. Seed users first.');
            return;
        }

        $classes = [
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'Computer Science',
            'English',
        ];

        foreach ($classes as $className) {
            ClassSubject::create([
                'code' => $this->classCode(),
                'name' => $className,
                'lecturer_id' => $lecturers->random(),
            ]);
        }
    }

    private function classCode(): string
    {
        return 'CLS-' . strtoupper(Str::random(4));
    }

}

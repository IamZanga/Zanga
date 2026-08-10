<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed a test class and a test student account.
     */
    public function run(): void
    {
        $classRoom = ClassRoom::firstOrCreate(['name' => '11A']);

        Student::firstOrCreate(
            ['student_number' => 'KSSS-0001'],
            [
                'first_name' => 'Test',
                'last_name' => 'Student',
                'class_id' => $classRoom->id,
                'email' => 'ksss-0001@portal.local',
                'password' => Hash::make('password'),
                'must_change_password' => true,
            ]
        );
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Carbon\Carbon;

class EnrollmentSeeder extends Seeder
{
    public function run()
    {
        $student1 = Student::firstOrCreate(
            ['email' => 'mark@gmail.com'],
            ['name' => 'Mark', 'dob' => '2000-05-15', 'phone' => '1234567890']
        );

        // Debugging
        if (!$student1) {
            dd("Failed to create or retrieve student 1");
        }

        $student2 = Student::firstOrCreate(
            ['email' => 'joshua@gmail.com'],
            ['name' => 'Joshua', 'dob' => '1998-11-22', 'phone' => '0765432143']
        );

        // Debugging
        if (!$student2) {
            dd("Failed to create or retrieve student 2");
        }

        $student3 = Student::firstOrCreate(
            ['email' => 'orishaba@gmail.com'],
            ['name' => 'Orishaba', 'dob' => '2002-02-10', 'phone' => '07122334455']
        );

        // Debugging
        if (!$student3) {
            dd("Failed to create or retrieve student 3");
        }

        $course3 = Course::find(3);
        $course5 = Course::find(5);

        if (!$course3) {
            dd("Course 3 not found");
        }
        if (!$course5) {
            dd("Course 5 not found");
        }


        Enrollment::create([
            'student_id' => $student1->id,
            'student_name' => $student1->name,
            'course_id' => $course3->id,
            'enrollment_date' => Carbon::now(),
            'status' => 'Active',
            'grade' => null,
            'dob' => $student1->dob,
            'phone' => $student1->phone,
            'email' => $student1->email,
        ]);

        Enrollment::create([
            'student_id' => $student2->id,
            'student_name' => $student2->name,
            'course_id' => $course3->id,
            'enrollment_date' => Carbon::now(),
            'status' => 'Completed',
            'grade' => 'A',
            'dob' => $student2->dob,
            'phone' => $student2->phone,
            'email' => $student2->email,
        ]);

        Enrollment::create([
            'student_id' => $student3->id,
            'student_name' => $student3->name,
            'course_id' => $course5->id,
            'enrollment_date' => Carbon::now(),
            'status' => 'Active',
            'grade' => null,
            'dob' => $student3->dob,
            'phone' => $student3->phone,
            'email' => $student3->email,
        ]);
    }
}

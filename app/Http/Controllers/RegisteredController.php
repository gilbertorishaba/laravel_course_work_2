<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Report;

class RegisteredController extends Controller
{
    public function index()
    {
        // Fetch data from the database
        $students = Student::count();
        $courses = Course::count();
        $reports = Report::count();
        $enrollment = Enrollment::count();

        return view('dashboard', compact('students', 'courses', 'reports', 'enrollment'));
    }
}

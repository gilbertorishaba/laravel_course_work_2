<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    //shows the enrollment form
    public function showEnrollmentForm(Request $request)
    {
        // Checking user role
        if (Auth::user()->is_admin !== 1) {
            return redirect()->route('welcome')->with('error', 'Unauthorized access');
        }

        $courseId = $request->query('course');
        $course = Course::findOrFail($courseId);

        // Fetch all students to display in the enrollment form
        $students = Student::all();

        // Pass the course and students to the view
        return view('admin.enroll', compact('course', 'students'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'course_id' => 'required|exists:courses,id',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:active,completed,inactive',
            'grade' => 'nullable|string',
            'dob' => 'required|date',
            'phone' => 'required|string',
        ]);

        // Creating a new enrollment with the student_id
        $enrollment = Enrollment::create([
            'student_id' => $request->student_id,
            'student_name' => $request->name,
            'email' => $request->email,
            'course_id' => $request->course_id,
            'enrollment_date' => $request->enrollment_date,
            'status' => $request->status,
            'grade' => $request->grade,
            'dob' => $request->dob,
            'phone' => $request->phone,
        ]);

        // Return a success message or redirect to the enrollment form
        return redirect()->route('admin.enroll')->with('success', 'Enrollment created successfully!');
    }


    public function show($courseId)
    {
        // Eager load the enrollments
        $course = Course::with(['enrollments.student'])->findOrFail($courseId);

        // Checking if the course was found
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found.');
        }

        // Pass the course and its related enrollments to the view
        return view('admin.show', compact('course'));
    }
}

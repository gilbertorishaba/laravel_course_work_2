<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('course')->get();
        return view('backend.students.index', compact('students'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('backend.students.create', compact('courses'));
    }


    public function store(Request $request)
    {
        \Log::info($request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:15',
            'dob' => 'required|date',
            'course_id' => 'required|exists:courses,id',
            'profile_image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('profile_image_url')) {
            $imagePath = $request->file('profile_image_url')->store('images/students', 'public');
        }

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'course_id' => $request->course_id,
            'profile_image_url' => $imagePath,
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }


    public function show(Student $student)
    {
        return view('backend.students.show', compact('student'));
    }

    // Show the form for editing a student
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('backend.students.edit', compact('student'));
    }

    // Update the student's information
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $id,
            'course_enrolled' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
        ]);

        $student->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'course_enrolled' => $request->input('course_enrolled'),
            'dob' => $request->input('dob'),
            'phone' => $request->input('phone'),
        ]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    // Delete a student
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        if ($student->image && file_exists(public_path('images/students/' . $student->image))) {
            unlink(public_path('images/students/' . $student->image));
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }
}

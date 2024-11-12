<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\Student;
use Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Eager load--to fetch data in a single query
        $students = Student::select('id', 'name', 'email', 'phone', 'created_at')->with('course')->get();

        // Fetch all courses and the number of students enrolled in each course
        $courses = Course::pluck('course_name');
        $enrollments = Course::withCount('students')->pluck('students_count');


        return view('backend.reports.index', compact('students', 'courses', 'enrollments'));
    }


    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Fetch all courses with their enrolled students
        $courses = Course::with(['students' => function ($query) {
            $query->select('students.id', 'students.name', 'students.email', 'students.profile_image_url')
                  ->join('enrollments as e', 'students.id', '=', 'e.student_id')
                  ->join('courses as c', 'e.course_id', '=', 'c.id');
        }])->get();

        return view('backend.reports.create', compact('courses'));
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'report_type' => 'required|string|max:255',
            'generated_at' => 'required|date',
            'course_id' => 'required|exists:courses,id',
        ]);

        // Automatically set generated_by to the authenticated admin
        $validatedData['generated_by'] = Auth::user()->name;

        // Store the validated data in the database
        Report::create([
            'report_type' => $validatedData['report_type'],
            'generated_at' => $validatedData['generated_at'],
            'generated_by' => $validatedData['generated_by'],
            'course_id' => $validatedData['course_id'],
        ]);
        return redirect()->back()->with('success', 'Report generated successfully.');
    }

    /**
     * Show the form for editing the specified report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = Report::findOrFail($id);
        return view('backend.reports.edit', compact('report'));
    }

    /**
     * Update the specified report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'report_type' => 'required|string|max:255',
        ]);

        $report = Report::findOrFail($id);
        $report->update([
            'report_type' => $request->input('report_type'),
        ]);

        return redirect()->route('backend.reports.index')->with('success', 'Report updated successfully.');
    }

    /**
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('backend.reports.index')->with('success', 'Report deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentPerformance;

class StudentPerformanceController extends Controller
{
    public function index()
    {
        $performances = StudentPerformance::with('student')->get();
        return view('student_performances.index', compact('performances'));
    }

    public function create()
    {
        $students = Student::all(); // Fetch all students
        return view('student_performances.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'description' => 'required|string',
        ]);

        // Fetch student name
        $student = Student::find($request->student_id);

        StudentPerformance::create([
            'student_id' => $request->student_id,
            'student_name' => $student->first_name . ' ' . $student->last_name,
            'description' => $request->description,
        ]);

        return redirect()->route('student_performances.index')->with('success', 'Performance record added successfully!');
    }

    public function edit(StudentPerformance $performance)
    {
        $students = Student::all(); // Fetch all students for the dropdown
        return view('student_performances.edit', compact('performance', 'students'));
    }

    public function update(Request $request, StudentPerformance $performance)
    {
        $request->validate([
            'description' => 'required|string',
        ]);

        $performance->update($request->only(['description']));

        return redirect()->route('student_performances.index')->with('success', 'Performance record updated successfully!');
    }

    public function destroy(StudentPerformance $performance)
    {
        $performance->delete();
        return redirect()->route('student_performances.index')->with('success', 'Performance record deleted successfully!');
    }
}


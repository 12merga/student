<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\GradeResult;
use Illuminate\Http\Request;

class GradeResultController extends Controller
{
    
    public function index()
    {
        $gradeResults = GradeResult::with('student')->get();
        return view('grade_results.index', compact('gradeResults'));
    }

    public function create()
    {
        $students = Student::all(); // Fetch all students
        return view('grade_results.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'test1' => 'required|numeric',
            'assignment' => 'required|numeric',
            'test2' => 'required|numeric',
            'final' => 'required|numeric',
        ]);

        // Calculate total
        $total = $request->test1 + $request->assignment + $request->test2 + $request->final;

        GradeResult::create([
            'student_id' => $request->student_id,
            'test1' => $request->test1,
            'assignment' => $request->assignment,
            'test2' => $request->test2,
            'final' => $request->final,
            'total' => $total,
        ]);

        return redirect()->route('grade_results.index')->with('success', 'Grade result added successfully!');
    }

    public function edit(GradeResult $gradeResult)
    {
        $students = Student::all(); // Fetch all students for the dropdown
        return view('grade_results.edit', compact('gradeResult', 'students'));
    }

    public function update(Request $request, GradeResult $gradeResult)
    {
        $request->validate([
            'test1' => 'required|numeric',
            'assignment' => 'required|numeric',
            'test2' => 'required|numeric',
            'final' => 'required|numeric',
        ]);

        // Recalculate total
        $total = $request->test1 + $request->assignment + $request->test2 + $request->final;

        $gradeResult->update([
            'test1' => $request->test1,
            'assignment' => $request->assignment,
            'test2' => $request->test2,
            'final' => $request->final,
            'total' => $total,
        ]);

        return redirect()->route('grade_results.index')->with('success', 'Grade result updated successfully!');
    }

    public function destroy(GradeResult $gradeResult)
    {
        $gradeResult->delete();
        return redirect()->route('grade_results.index')->with('success', 'Grade result deleted successfully!');
    }

}

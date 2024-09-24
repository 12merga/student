<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\GradeResult;
use Illuminate\Http\Request;
use App\Models\StudentPerformance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return view('teachers.index', compact('teachers'));
    }

    // Show form to create a new teacher
    public function create()
    {
        return view('teachers.create');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('teacher')->attempt($credentials)) {
            return redirect()->route('teacher.dashboard');
        }

        return back()->withErrors(['message' => 'Invalid credentials']);
    }

    public function dashboard()
    {
        return view('teacher.dashboard');
    }

    private function generateTeacherPassword($firstName, $subject)
    {
        return strtolower($firstName) . ucfirst($subject); // e.g., johnMath
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'title' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email|unique:teachers',
            'subject' => 'required|string',
            'password' => 'required|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $teacher = Teacher::create($validated);

        return response()->json($teacher, 201);
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:teachers,email,' . $id,
            'subject' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $teacher = Teacher::findOrFail($id);
        $teacher->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'title' => $request->title,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'subject' => $request->subject,
            'password' => $request->password ? bcrypt($request->password) : $teacher->password,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }

    // ------------- New Methods for Grades and Performance --------------

    // Assign grades to a student
    public function assignGrade(Request $request, $studentId)
    {
        $request->validate([
            'test_1' => 'required|numeric',
            'assignment' => 'required|numeric',
            'test_2' => 'required|numeric',
            'final' => 'required|numeric',
        ]);

        // Calculate total score
        $total = $request->test_1 + $request->assignment + $request->test_2 + $request->final;

        // Find student
        $student = Student::findOrFail($studentId);

        // Save grade results
        $gradeResult = new GradeResult();
        $gradeResult->student_id = $student->id;
        $gradeResult->test_1 = $request->test_1;
        $gradeResult->assignment = $request->assignment;
        $gradeResult->test_2 = $request->test_2;
        $gradeResult->final = $request->final;
        $gradeResult->total = $total;
        $gradeResult->teacher_id = Auth::guard('teacher')->id(); // Save teacher's ID
        $gradeResult->save();

        return response()->json(['message' => 'Grade assigned successfully.', 'total' => $total]);
    }

    // Record student performance
    public function recordPerformance(Request $request, $studentId)
    {
        $request->validate([
            'student_name' => 'required|string',
            'description' => 'required|string',
        ]);

        $student = Student::findOrFail($studentId);
        $performance = new StudentPerformance();
        $performance->student_id = $student->id;
        $performance->student_name = $request->student_name;
        $performance->description = $request->description;
        $performance->teacher_id = Auth::guard('teacher')->id();
        $performance->save();

        return response()->json(['message' => 'Performance recorded successfully.']);
    }
}

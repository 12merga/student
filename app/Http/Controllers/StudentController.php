<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Auth::guard('student')->user();

        $results = $student->results;
        $performances = $student->performances;
        $events = $this->getUpcomingEvents();

        return response()->json([
            'student' => $student,
            'results' => $results,
            'performances' => $performances,
            'events' => $events,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('student')->attempt($credentials)) {
            $student = Auth::guard('student')->user();
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function viewGrades()
    {
        $student = Auth::guard('student')->user();
        $grades = $student->results; // Adjust based on your results relationship

        return response()->json([
            'grades' => $grades,
        ]);
    }

    public function viewPerformances()
    {
        $student = Auth::guard('student')->user();
        $performances = $student->performances; // Adjust based on your performances relationship

        return response()->json([
            'performances' => $performances,
        ]);
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::guard('student')->attempt($credentials)) {
    //         $student = Auth::guard('student')->user();
    //         $token = $student->createToken('StudentToken')->plainTextToken;

    //         return response()->json([
    //             'message' => 'Login successful',
    //             'token' => $token,
    //             'student' => $student,
    //         ], 200);
    //     } else {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }
    // }

    public function __construct()
    {
        if (Auth::guard('admin')->check()) {
        } else {
            return redirect()->route('login')->with('error', 'Unauthorized');
        }
    }

    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    private function getUpcomingEvents()
    {
        return [
            [
                'name' => 'School Annual Day',
                'date' => '2024-10-01',
                'description' => 'A day of performances and celebrations.',
            ],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'date_of_birth' => 'required|date',
            'age' => 'required|integer',
            'email' => 'required|email|unique:students',
            'class' => 'required|string',
        ]);

        $student = Student::create($validated);

        return response()->json($student, 201);


        Student::create([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'date_of_birth' => $request->date_of_birth,
            'age' => $request->age,
            'email' => $request->email,
            'class' => $request->class,

        ]);

        return redirect()->route('students.index')->with('success', 'Student registered successfully.');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|unique:students',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'age' => 'required|integer',
            'email' => 'required|string|email|max:255|unique:students,email,' . $id,
            'class' => 'required|string|max:255',
        ]);

        $student = Student::findOrFail($id);
        $student->update([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'date_of_birth' => $request->date_of_birth,
            'age' => $request->age,
            'email' => $request->email,
            'class' => $request->class,

        ]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}

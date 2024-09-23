<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

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

        return view('student.dashboard');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('student_id', 'password');

        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->route('student.dashboard');
        }

        return back()->withErrors(['message' => 'Invalid credentials']);
    }


    public function viewGrades()
    {
        $student = Auth::guard('student')->user();
        $grades = $student->results;

        return response()->json([
            'grades' => $grades,
        ]);
    }

    public function viewPerformances()
    {
        $student = Auth::guard('student')->user();
        $performances = $student->performances;

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
            'password' => 'required|string|min:8|confirmed',
            'class' => 'required|string',
        ]);

        $student = Student::create($validated);

        return response()->json($student, 201);

        $studentId = $this->generateStudentId($request->class);
        $hashedPassword = Hash::make($validatedData['password']);

        Student::create([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'date_of_birth' => $request->date_of_birth,
            'age' => $request->age,
            'email' => $request->email,
            'password' => Hash::make($validatedData['password']),
            'class' => $request->class,

        ]);

        Student::create($request->all());
        return redirect()->route('students.index')->with('success', 'Student registered successfully!');
    }


    private function generateStudentId($class)
    {
        $randomDigits = mt_rand(1000, 9999);
        return 'ST/' . $randomDigits . '/' . strtoupper($class);
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

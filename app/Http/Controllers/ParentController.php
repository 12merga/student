<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Models\GradeResult;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use App\Models\StudentPerformance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Routing\HasMiddleware;

class ParentController extends Controller
{
    public function create()
    {
        $students = Student::all();
        return view('parents.create', compact('students'));
    }

    public function showRegistrationForm()
    {
        $students = Student::all();
        return view('parents.register', compact('students'));
    }

    public function showLoginForm()
    {
        return view('parents.login');
    }

    public function dashboard()
    {
        $parent = Auth::guard('parent')->user();
        $student = Student::findOrFail($parent->student_id);

        $grades = GradeResult::where('student_id', $student->id)->get();
        $performances = StudentPerformance::where('student_id', $student->id)->get();

        return view('parents.dashboard', compact('student', 'grades', 'performances'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('parent')->attempt($credentials)) {
            if (Auth::guard('parent')->user()->is_approved) {
                return redirect()->route('parents.dashboard');
            } else {
                Auth::guard('parent')->logout();
                return back()->withErrors(['email' => 'Your account is not yet approved by the admin.']);
            }
        }

        return back()->withErrors(['message' => 'Invalid credentials']);
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'student_id' => 'required|exists:students,id',
            'student_first_name' => 'required|string',
            'student_last_name' => 'required|string',
            'student_middle_name' => 'nullable|string',
            'phone_number' => 'required|string',
            'email' => 'required|email|unique:parents,email',
            'password' => 'required|string|min:6',
        ]);

        ParentModel::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'student_id' => $request->student_id,
            'student_first_name' => $request->student_first_name,
            'student_last_name' => $request->student_last_name,
            'student_middle_name' => $request->student_middle_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('parents.create')->with('success', 'Registration submitted successfully! Awaiting admin approval.');
    }

    public function index()
    {
        $parents = ParentModel::with('student')->get();
        return view('parents.index', compact('parents'));

        $parent = Auth::guard('parent')->user();

        $student = Student::findOrFail($parent->student_id);
        $grades = GradeResult::where('student_id', $student->id)->get();
        $performances = StudentPerformance::where('student_id', $student->id)->get();
        return view('parents.dashboard', compact('student', 'grades', 'performances'));
    }

    public function approve($id)
    {
        $parent = ParentModel::findOrFail($id);
        $student = Student::where('student_id', $parent->student_id)
            ->where('first_name', $parent->student_first_name)
            ->where('last_name', $parent->student_last_name)
            ->where('middle_name', $parent->student_middle_name)
            ->first();

        if (!$student) {
            return response()->json([
                'error' => 'Student information does not match. Cannot approve the parent registration.'
            ], 404);
        }

        $parent->is_approved = true;
        $parent->save();

        return redirect()->route('parents.index')->with('success', 'Parent approved successfully!');
    }

    public function logout()
    {
        Auth::guard('parent')->logout();
        return redirect('/login');
    }

    public function viewResults($studentId)
    {
        $results = GradeResult::where('student_id', $studentId)->get();
        return response()->json($results);
    }

    public function viewPerformance($studentId)
    {
        $performance = StudentPerformance::where('student_id', $studentId)->get();
        return response()->json($performance);
    }

    public function paymentStatus($studentId)
    {
        $paymentStatus = Payment::where('student_id', $studentId)->first();
        return response()->json($paymentStatus);
    }

    public function update(Request $request)
    {
        $parent = Auth::guard('parent')->user();

        $validated = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email|unique:parents,email,' . $parent->id,
            'password' => 'nullable|string|min:8',
        ]);

        $parent->first_name = $validated['first_name'];
        $parent->middle_name = $validated['middle_name'];
        $parent->last_name = $validated['last_name'];
        $parent->phone_number = $validated['phone_number'];
        $parent->email = $validated['email'];

        if ($validated['password']) {
            $parent->password = Hash::make($validated['password']);
        }

        // $parent->save();

        return redirect()->route('parents.dashboard')->with('success', 'Profile updated successfully.');
    }
}

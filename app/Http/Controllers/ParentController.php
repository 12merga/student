<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GradeResult;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\StudentPerformance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Routing\HasMiddleware;

class ParentController extends Controller
{

    public function register(Request $request)
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

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('parent')->attempt($credentials)) {
            if (Auth::guard('parent')->user()->is_approved) {
                return redirect()->route('parent.dashboard');
            } else {
                Auth::guard('parent')->logout();
                return back()->withErrors(['email' => 'Your account is not yet approved by the admin.']);
            }
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::guard('parent')->logout();
        return redirect('/login');
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
}



// public static function middleware()
//     {
//         return [
//             'isAdmin' => ['only' => ['approveParent']],
//         ];
//     }
//     public function approveParent($parentId)
//     {
//         $parent = \App\Models\ParentModel::find($parentId);

//         if ($parent) {
//             $parent->is_approved = true;
//             $parent->save();

//             return redirect()->back()->with('success', 'Parent approved successfully.');
//         }

//         return redirect()->back()->with('error', 'Parent not found.');
//     }

//     // Parent self-registration
//     public function create()
//     {
//         $students = Student::all();
//         return view('parents.create', compact('students'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'first_name' => 'required|string',
//             'middle_name' => 'nullable|string',
//             'last_name' => 'required|string',
//             'student_id' => 'required|exists:students,id',
//             'student_first_name' => 'required|string',
//             'student_last_name' => 'required|string',
//             'student_middle_name' => 'nullable|string',
//             'phone_number' => 'required|string',
//             'email' => 'required|email|unique:parents,email',
//             'password' => 'required|string|min:6',
//         ]);

//         ParentModel::create([
//             'first_name' => $request->first_name,
//             'middle_name' => $request->middle_name,
//             'last_name' => $request->last_name,
//             'student_id' => $request->student_id,
//             'student_first_name' => $request->student_first_name,
//             'student_last_name' => $request->student_last_name,
//             'student_middle_name' => $request->student_middle_name,
//             'phone_number' => $request->phone_number,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//         ]);

//         return redirect()->route('parents.create')->with('success', 'Registration submitted successfully! Awaiting admin approval.');
//     }

//     public function approve($id)
//     {
//         $parent = ParentModel::findOrFail($id);
//         $student = Student::where('student_id', $parent->student_id)
//             ->where('first_name', $parent->student_first_name)
//             ->where('last_name', $parent->student_last_name)
//             ->where('middle_name', $parent->student_middle_name)
//             ->first();

//         if (!$student) {
//             return response()->json([
//                 'error' => 'Student information does not match. Cannot approve the parent registration.'
//             ], 404);
//         }

//         $parent->is_approved = true;
//         $parent->save();

//         return redirect()->route('parents.index')->with('success', 'Parent approved successfully!');
//     }

//     public function login(Request $request)
//     {
//         $credentials = $request->only('email', 'password');

//         if (Auth::guard('parent')->attempt($credentials)) {
//             if (Auth::guard('parent')->user()->is_approved) {
//                 return redirect()->route('parent.dashboard');
//             } else {
//                 Auth::guard('parent')->logout();
//                 return back()->withErrors(['email' => 'Your account is not yet approved by the admin.']);
//             }
//         }

//         return back()->withErrors([
//             'email' => 'These credentials do not match our records.',
//         ]);
//     }

//     public function logout()
//     {
//         Auth::guard('parent')->logout();
//         return redirect('/login');
//     }

//     public function index()
//     {
//         $parents = ParentModel::with('student')->get();
//         return view('parents.index', compact('parents'));

//         $parent = Auth::guard('parent')->user();

//         $student = Student::findOrFail($parent->student_id);
//         $grades = GradeResult::where('student_id', $student->id)->get();
//         $performances = StudentPerformance::where('student_id', $student->id)->get();
//         return view('parents.dashboard', compact('student', 'grades', 'performances'));
//     }
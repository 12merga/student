<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    // Parent self-registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'student_first_name' => 'required|string',
            'student_middle_name' => 'nullable|string',
            'student_last_name' => 'required|string',
            'student_id' => 'required|string|exists:students,student_id',
            'phone_number' => 'required|string',
            'email' => 'required|email|unique:parents,email',
            'password' => 'required|string|min:6|confirmed', // password_confirmation must match
        ]);

        // Create the parent record
        $parent = ParentModel::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'student_first_name' => $request->student_first_name,
            'student_middle_name' => $request->student_middle_name,
            'student_last_name' => $request->student_last_name,
            'student_id' => $request->student_id,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'approved' => false, // Initially not approved
        ]);

        return response()->json([
            'message' => 'Parent registered successfully. Awaiting admin approval.',
            'parent' => $parent
        ], 201);
    }

    // Admin approves parent registration after checking student info
    public function approve(Request $request, $parent_id)
    {
        // Find the parent by ID
        $parent = ParentModel::findOrFail($parent_id);

        // Find the student by student_id and check name match
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

        // Approve the parent
        $parent->approved = true;
        $parent->save();

        return response()->json(['message' => 'Parent approved successfully.']);
    }
}

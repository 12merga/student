<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('teacher')->attempt($credentials)) {
            $teacher = Auth::guard('teacher')->user();
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
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

        // Hash the password

        $uniqueId = uniqid();
        $teachersId = strtoupper($request->subject . '-' . $uniqueId);

        $validated['password'] = Hash::make($validated['password']);

        $teacher = Teacher::create($validated);

        return response()->json($teacher, 201);

        Teacher::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'title' => $request->title,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'subject' => $request->subject,
            'password' => bcrypt($request->password),
            'teachersId' => $teachersId,

        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
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

        $uniqueId = uniqid();
        $teachersId = strtoupper($request->subject . '-' . $uniqueId);

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
            'teachersId' => $teachersId,

        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}

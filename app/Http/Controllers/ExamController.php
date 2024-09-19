<?php

namespace App\Http\Controllers;

use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;

class ExamController extends Controller
{

    public function __construct()
    {
        $this->middleware('is_admin')  ->only(['store', 'update', 'destroy']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class' => 'required|string',
            'subject' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'examiner' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
            'students' => 'array',
            'students.*' => 'exists:students,id',
        ]);

        $examSchedule = ExamSchedule::create([
            'class' => $request->class,
            'subject' => $request->subject,
            'date' => $request->date,
            'location' => $request->location,
            'examiner' => $request->examiner,
            'teacher_id' => $request->teacher_id,
        ]);

        // Attach students to the exam schedule
        if ($request->has('students')) {
            $examSchedule->students()->attach($request->students);
        }

        return response()->json(['message' => 'Exam schedule created successfully!', 'exam_schedule' => $examSchedule], 201);
    }

    public function show($id)
    {
        $examSchedule = ExamSchedule::with('teacher', 'students')->findOrFail($id);
        return response()->json($examSchedule);
    }

    public function index()
    {
        // Return all exam schedules, might be filtered by class or date if needed
        $examSchedules = ExamSchedule::with('teacher', 'students')->get();
        return response()->json($examSchedules);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'class' => 'sometimes|string',
            'subject' => 'sometimes|string',
            'date' => 'sometimes|date',
            'location' => 'sometimes|string',
            'examiner' => 'sometimes|string',
            'teacher_id' => 'sometimes|exists:teachers,id',
            'students' => 'array',
            'students.*' => 'exists:students,id',
        ]);

        $examSchedule = ExamSchedule::findOrFail($id);
        $examSchedule->update($request->only([
            'class',
            'subject',
            'date',
            'location',
            'examiner',
            'teacher_id',
        ]));

        // Sync students to the exam schedule
        if ($request->has('students')) {
            $examSchedule->students()->sync($request->students);
        }

        return response()->json(['message' => 'Exam schedule updated successfully!', 'exam_schedule' => $examSchedule]);
    }

    public function destroy($id)
    {
        $examSchedule = ExamSchedule::findOrFail($id);
        $examSchedule->students()->detach(); // Remove the association with students
        $examSchedule->delete();

        return response()->json(['message' => 'Exam schedule deleted successfully!']);
    }
}

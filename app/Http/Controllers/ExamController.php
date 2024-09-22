<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\HasMiddleware;

class ExamController extends Controller
{

    public static function middleware()
    {
        return [
            'isAdmin' => ['only' => ['approveParent']],
        ];
    }
    // public function __construct()
    // {
    //     $this->middleware('is_admin')  ->only(['store', 'update', 'destroy']);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'class' => 'required|string',
            'subject' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'examiner' => 'required|string',
            'teacher_id' => 'required|integer|exists:teachers,id', // Assuming teacher_id refers to teachers table
        ]);

        ExamSchedule::create([
            'class' => $request->class,
            'subject' => $request->subject,
            'date' => $request->date,
            'location' => $request->location,
            'examiner' => $request->examiner,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('exams.index')->with('success', 'Exam schedule created successfully!');
    }


    public function show($id)
    {
        $examSchedule = ExamSchedule::with('teacher', 'students')->findOrFail($id);
        return response()->json($examSchedule);
    }

    public function index()
    {
        $examSchedules = ExamSchedule::with('teacher', 'students')->get();
        return response()->json($examSchedules);
    }

    public function update(Request $request, ExamSchedule $exam)
    {
        $request->validate([
            'class' => 'required|string',
            'subject' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'examiner' => 'required|string',
            'teacher_id' => 'required|integer|exists:teachers,id',
        ]);

        $exam->update([
            'class' => $request->class,
            'subject' => $request->subject,
            'date' => $request->date,
            'location' => $request->location,
            'examiner' => $request->examiner,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('exams.index')->with('success', 'Exam schedule updated successfully!');
    }


    public function destroy(ExamSchedule $exam)
    {
        // $this->authorize('delete', $exam);
        $exam->delete();

        return redirect()->route('exams.index')->with('success', 'Exam schedule deleted successfully!');
    }
}

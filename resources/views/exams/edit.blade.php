 
@extends('layouts.app')

@section('content')
    <h1>Edit Exam Schedule</h1>

    <form action="{{ route('exams.update', $exam->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="class">Class</label>
            <input type="text" name="class" id="class" class="form-control" value="{{ $exam->class }}" required>
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" value="{{ $exam->subject }}" required>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $exam->date }}" required>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ $exam->location }}" required>
        </div>

        <div class="form-group">
            <label for="examiner">Examiner</label>
            <input type="text" name="examiner" id="examiner" class="form-control" value="{{ $exam->examiner }}" required>
        </div>

        <div class="form-group">
            <label for="teacher_id">Teacher ID</label>
            <input type="number" name="teacher_id" id="teacher_id" class="form-control" value="{{ $exam->teacher_id }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Schedule</button>
    </form>
@endsection

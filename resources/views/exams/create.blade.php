 
@extends('layouts.app')

@section('content')
    <h1>Add Exam Schedule</h1>

    <form action="{{ route('exams.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="class">Class</label>
            <input type="text" name="class" id="class" class="form-control" value="{{ old('class') }}" required>
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required>
        </div>

        <div class="form-group">
            <label for="examiner">Examiner</label>
            <input type="text" name="examiner" id="examiner" class="form-control" value="{{ old('examiner') }}" required>
        </div>

        <div class="form-group">
            <label for="teacher_id">Teacher ID</label>
            <input type="number" name="teacher_id" id="teacher_id" class="form-control" value="{{ old('teacher_id') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Schedule</button>
    </form>
@endsection

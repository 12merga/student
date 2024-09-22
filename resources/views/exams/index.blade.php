 
@extends('layouts.app')

@section('content')
    <h1>Exam Schedules</h1>
    <a href="{{ route('exams.create') }}" class="btn btn-primary">Add Exam Schedule</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Class</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Location</th>
                <th>Examiner</th>
                <th>Teacher ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($exams as $exam)
                <tr>
                    <td>{{ $exam->class }}</td>
                    <td>{{ $exam->subject }}</td>
                    <td>{{ $exam->date }}</td>
                    <td>{{ $exam->location }}</td>
                    <td>{{ $exam->examiner }}</td>
                    <td>{{ $exam->teacher_id }}</td>
                    <td>
                        <a href="{{ route('exams.edit', $exam->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

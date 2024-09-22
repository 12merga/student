 
@extends('layouts.app')

@section('content')
    <h1>Edit Student Performance</h1>

    <form action="{{ route('student_performances.update', $performance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="student_id">Student</label>
            <select name="student_id" id="student_id" class="form-control" required>
                <option value="">Select Student</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ $student->id == $performance->student_id ? 'selected' : '' }}>
                        {{ $student->first_name }} {{ $student->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ $performance->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Student Performance</button>
    </form>
@endsection

 
@extends('layouts.app')

@section('content')
    <h1>Edit Grade Result</h1>

    <form action="{{ route('grade_results.update', $gradeResult->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="student_id">Student</label>
            <select name="student_id" id="student_id" class="form-control" required>
                <option value="">Select Student</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ $student->id == $gradeResult->student_id ? 'selected' : '' }}>
                        {{ $student->first_name }} {{ $student->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="test1">Test 1</label>
            <input type="number" name="test1" id="test1" class="form-control" value="{{ $gradeResult->test1 }}" required>
        </div>

        <div class="form-group">
            <label for="assignment">Assignment</label>
            <input type="number" name="assignment" id="assignment" class="form-control" value="{{ $gradeResult->assignment }}" required>
        </div>

        <div class="form-group">
            <label for="test2">Test 2</label>
            <input type="number" name="test2" id="test2" class="form-control" value="{{ $gradeResult->test2 }}" required>
        </div>

        <div class="form-group">
            <label for="final">Final</label>
            <input type="number" name="final" id="final" class="form-control" value="{{ $gradeResult->final }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Grade Result</button>
    </form>
@endsection

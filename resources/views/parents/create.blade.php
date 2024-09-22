 
@extends('layouts.app')

@section('content')
    <h1>Parent Registration</h1>

    <form action="{{ route('parents.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="middle_name">Middle Name</label>
            <input type="text" name="middle_name" id="middle_name" class="form-control">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="student_id">Student</label>
            <select name="student_id" id="student_id" class="form-control" required>
                <option value="">Select Student</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="student_first_name">Student First Name</label>
            <input type="text" name="student_first_name" id="student_first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="student_last_name">Student Last Name</label>
            <input type="text" name="student_last_name" id="student_last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="student_middle_name">Student Middle Name</label>
            <input type="text" name="student_middle_name" id="student_middle_name" class="form-control">
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
@endsection

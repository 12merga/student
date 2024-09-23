@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h2>Welcome, Admin!</h2>
    <p>Use the menu to manage students, teachers, exam schedules, and class periods.</p>

    <!-- Links to management pages -->
    <ul>
        <li><a href="{{ route('students.index') }}">Manage Students</a></li>
        <li><a href="{{ route('teachers.index') }}">Manage Teachers</a></li>
        <li><a href="{{ route('exam-schedules.index') }}">Manage Exam Schedules</a></li>
        <li><a href="{{ route('class-periods.index') }}">Manage Class Periods</a></li>
    </ul>
@endsection

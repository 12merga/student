 
@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
    <h1>Student Dashboard</h1>
    <ul>
        <li><a href="{{ route('student.grades') }}">View Grades</a></li>
        <li><a href="{{ route('student.performances') }}">View Performances</a></li>
        <li><a href="{{ route('student.exam-schedules') }}">View Exam Schedules</a></li>
        <li><a href="{{ route('student.class-periods') }}">View Class Periods</a></li>
    </ul>
@endsection

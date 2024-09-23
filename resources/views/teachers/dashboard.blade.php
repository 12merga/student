 
@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
    <h1>Teacher Dashboard</h1>
    <ul>
        <li><a href="{{ route('teachers.grades') }}">Add Grades</a></li>
        <li><a href="{{ route('teachers.performance', ['student_id' => 1]) }}">View Student Performance</a></li>
    </ul>
@endsection

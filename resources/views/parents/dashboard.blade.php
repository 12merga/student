 
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ Auth::guard('parent')->user()->first_name }}!</h1>

    <h2>Student: {{ $student->first_name }} {{ $student->last_name }}</h2>

    <h3>Grade Results</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Test 1</th>
                <th>Assignment</th>
                <th>Test 2</th>
                <th>Final</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
                <tr>
                    <td>{{ $grade->test_1 }}</td>
                    <td>{{ $grade->assignment }}</td>
                    <td>{{ $grade->test_2 }}</td>
                    <td>{{ $grade->final }}</td>
                    <td>{{ $grade->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Performance</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($performances as $performance)
                <tr>
                    <td>{{ $performance->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

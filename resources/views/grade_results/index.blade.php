 
@extends('layouts.app')

@section('content')
    <h1>Grade Results</h1>
    <a href="{{ route('grade_results.create') }}" class="btn btn-primary">Add Grade Result</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Test 1</th>
                <th>Assignment</th>
                <th>Test 2</th>
                <th>Final</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gradeResults as $result)
                <tr>
                    <td>{{ $result->student->first_name }} {{ $result->student->last_name }}</td>
                    <td>{{ $result->test1 }}</td>
                    <td>{{ $result->assignment }}</td>
                    <td>{{ $result->test2 }}</td>
                    <td>{{ $result->final }}</td>
                    <td>{{ $result->total }}</td>
                    <td>
                        <a href="{{ route('grade_results.edit', $result->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('grade_results.destroy', $result->id) }}" method="POST" style="display:inline;">
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

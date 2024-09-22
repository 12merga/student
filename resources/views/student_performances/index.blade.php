 
@extends('layouts.app')

@section('content')
    <h1>Student Performances</h1>
    <a href="{{ route('student_performances.create') }}" class="btn btn-primary">Add Student Performance</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($performances as $performance)
                <tr>
                    <td>{{ $performance->student_name }}</td>
                    <td>{{ $performance->description }}</td>
                    <td>
                        <a href="{{ route('student_performances.edit', $performance->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('student_performances.destroy', $performance->id) }}" method="POST" style="display:inline;">
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

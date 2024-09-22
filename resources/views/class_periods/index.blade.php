 
@extends('layouts.app')

@section('content')
    <h1>Class Periods</h1>
    <a href="{{ route('class_periods.create') }}" class="btn btn-primary">Add Class Period</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Class</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($class_periods as $period)
                <tr>
                    <td>{{ $period->class }}</td>
                    <td>{{ $period->monday }}</td>
                    <td>{{ $period->tuesday }}</td>
                    <td>{{ $period->wednesday }}</td>
                    <td>{{ $period->thursday }}</td>
                    <td>{{ $period->friday }}</td>
                    <td>
                        <a href="{{ route('class_periods.edit', $period->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('class_periods.destroy', $period->id) }}" method="POST" style="display:inline;">
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

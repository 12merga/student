 
@extends('layouts.app')

@section('content')
    <h1>Parent Registrations</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Parent Name</th>
                <th>Student Name</th>
                <th>Email</th>
                <th>Approved</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parents as $parent)
                <tr>
                    <td>{{ $parent->first_name }} {{ $parent->last_name }}</td>
                    <td>{{ $parent->student_first_name }} {{ $parent->student_last_name }}</td>
                    <td>{{ $parent->email }}</td>
                    <td>{{ $parent->is_approved ? 'Yes' : 'No' }}</td>
                    <td>
                        @if (!$parent->is_approved)
                            <form action="{{ route('parents.approve', $parent->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                        @endif

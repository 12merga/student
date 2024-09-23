 
@extends('layouts.app')

@section('content')
<div class="login-container">
    <h2>Student Login</h2>
    <form method="POST" action="{{ route('student.login') }}">
        @csrf
        <label for="student_id">Student ID:</label>
        <input type="text" name="student_id" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Login</button>
        
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
@endsection

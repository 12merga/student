<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to Your Dashboard</h1>
        <p>Hello, {{ auth()->user()->name }}!</p>

        <h2>Your Child's Information</h2>
        <ul>
            @foreach($students as $student)
            <li>
            <li><a href="{{ route('parents.grades', ['student_id' => auth()->user()->student_id]) }}">View Grades</a></li>
            <li><a href="{{ route('parents.performance', ['student_id' => auth()->user()->student_id]) }}">View Performance</a></li>
            <a href="{{ route('parents.paymentStatus', $student->id) }}">Payment Status</a>
            </li>
        @endforeach
        </ul>

        <a href="{{ route('auth.logout') }}" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>


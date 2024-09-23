<!DOCTYPE html>
<html>
<head>
    <title>Register Student</title>
</head>
<body>
    <h1>Register Student</h1>

    <form action="{{ route('students.register') }}" method="POST">
        @csrf
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>
        <br>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        <br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
        <br>
        <label for="middle_name">Middle Name:</label>
        <input type="text" id="middle_name" name="middle_name">
        <br>
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required>
        <br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        <br>
    
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        <br>
        <label for="class">Class:</label>
        <input type="text" id="class" name="class" required>
        <br>
        <button type="submit">Register</button>
    </form>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
</body>
</html>


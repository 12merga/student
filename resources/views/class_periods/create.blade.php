 
@extends('layouts.app')

@section('content')
    <h1>Add Class Period</h1>

    <form action="{{ route('class_periods.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="class">Class</label>
            <input type="text" name="class" id="class" class="form-control" value="{{ old('class') }}" required>
        </div>

        <div class="form-group">
            <label for="monday">Monday</label>
            <input type="text" name="monday" id="monday" class="form-control" value="{{ old('monday') }}">
        </div>

        <div class="form-group">
            <label for="tuesday">Tuesday</label>
            <input type="text" name="tuesday" id="tuesday" class="form-control" value="{{ old('tuesday') }}">
        </div>

        <div class="form-group">
            <label for="wednesday">Wednesday</label>
            <input type="text" name="wednesday" id="wednesday" class="form-control" value="{{ old('wednesday') }}">
        </div>

        <div class="form-group">
            <label for="thursday">Thursday</label>
            <input type="text" name="thursday" id="thursday" class="form-control" value="{{ old('thursday') }}">
        </div>

        <div class="form-group">
            <label for="friday">Friday</label>
            <input type="text" name="friday" id="friday" class="form-control" value="{{ old('friday') }}">
        </div>

        <button type="submit" class="btn btn-primary">Add Period</button>
    </form>
@endsection

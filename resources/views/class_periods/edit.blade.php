 
@extends('layouts.app')

@section('content')
    <h1>Edit Class Period</h1>

    <form action="{{ route('class_periods.update', $class_period->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="class">Class</label>
            <input type="text" name="class" id="class" class="form-control" value="{{ $class_period->class }}" required>
        </div>

        <div class="form-group">
            <label for="monday">Monday</label>
            <input type="text" name="monday" id="monday" class="form-control" value="{{ $class_period->monday }}">
        </div>

        <div class="form-group">
            <label for="tuesday">Tuesday</label>
            <input type="text" name="tuesday" id="tuesday" class="form-control" value="{{ $class_period->tuesday }}">
        </div>

        <div class="form-group">
            <label for="wednesday">Wednesday</label>
            <input type="text" name="wednesday" id="wednesday" class="form-control" value="{{ $class_period->wednesday }}">
        </div>

        <div class="form-group">
            <label for="thursday">Thursday</label>
            <input type="text" name="thursday" id="thursday" class="form-control" value="{{ $class_period->thursday }}">
        </div>

        <div class="form-group">
            <label for="friday">Friday</label>
            <input type="text" name="friday" id="friday" class="form-control" value="{{ $class_period->friday }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Period</button>
    </form>
@endsection

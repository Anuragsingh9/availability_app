@extends('layouts.app')

@section('title', 'Edit Availability')

@section('content')
    <h1>Edit Availability</h1>
    <form action="{{ route('admin.availabilities.update', $availability->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $availability->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="{{ $availability->date }}" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" name="start_time" id="start_time" value="{{ $availability->start_time }}" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" name="end_time" id="end_time" value="{{ $availability->end_time }}" required>
        </div>
        <div class="form-group">
            <label for="interval">Interval (in minutes)</label>
            <input type="number" name="interval" id="interval" value="{{ $availability->interval }}" required>
        </div>
        <button type="submit">Update Availability</button>
    </form>
@endsection
@extends('layouts.app')

@section('title', 'Add Availability')

@section('content')
<div class="" style="text-align: center;">
    <h1>Add Availability</h1>
    <form action="{{ route('admin.availabilities.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" required min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" name="start_time" id="start_time" min="{{ \Carbon\Carbon::now()->format('H:i') }}" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" name="end_time" id="end_time" required min="{{ \Carbon\Carbon::now()->format('H:i') }}">
        </div>
        <div class="form-group">
            <label for="interval">Interval (in minutes)</label>
            <input type="number" name="interval" id="interval" required>
        </div>
        <button type="submit">Add Availability</button>
    </form>
</div>
<script>
    document.getElementById('date').addEventListener('change', function() {
        const today = "{{ \Carbon\Carbon::today()->format('Y-m-d') }}";
        const timeInput = document.getElementById('time');
        
        if (this.value === today) {
            timeInput.min = "{{ \Carbon\Carbon::now()->format('H:i') }}";
        } else if (this.value > today) {
            timeInput.min = "00:00";
        }
    });
</script>
@endsection
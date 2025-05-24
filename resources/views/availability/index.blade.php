@extends('layouts.app')

@section('title', 'Availability')

@section('content')
    <h1>Availability</h1>

    <div class="filter">
        <form method="GET" action="{{ route('availability.index') }}">
            <label for="category_id">Select Category</label>
            <select name="category_id" id="category_id" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="start_date" value="{{ $startDate }}">
        </form>
    </div>

    <div class="navigation">
        <a href="{{ route('availability.index', ['start_date' => $previousStart, 'category_id' => $categoryId]) }}">← Previous</a>
        <a href="{{ route('availability.index', ['start_date' => $nextStart, 'category_id' => $categoryId]) }}">Next →</a>
    </div>

    <div class="days">
        @foreach($days as $day)
            <div class="day">
                <h3>{{ $day->format('D M j') }}</h3>
                <ul class="slots">
                    @if(!empty($slotsByDay[$day->toDateString()]))
                        @foreach($slotsByDay[$day->toDateString()] as $slot)
                            <li class="slot category-{{ $slot['category_id'] }}">
                                {{ $slot['start'] }} - {{ $slot['end'] }} ({{ $slot['category'] }})
                            </li>
                        @endforeach
                    @else
                        <li>No slots available</li>
                    @endif
                </ul>
            </div>
        @endforeach
    </div>
@endsection
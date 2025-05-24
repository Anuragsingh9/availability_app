@extends('layouts.app')

@section('title', 'Availability List')

@section('content')
    <h1>Availability List</h1>
    @if(session('success'))
        <div class="success" id="success-message">
            {{ session('success') }}
            <span class="close-btn" onclick="document.getElementById('success-message').style.display='none'">&times;</span>
        </div>
    @endif
    <div class="">
        <a href="{{ route('admin.availabilities.create') }}" class="btn btn-primary">Add Availability</a>
    </div>   
    <form  method="GET" action="{{ route('admin.availabilities.index') }}">
        <div class="form-group">
            <label for="category_id">Filter by Category</label>
            <select name="category_id" id="category_id" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Interval (minutes)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($availabilities as $availability)
                <tr>
                    <td>{{ $availability->category->name }}</td>
                    <td>{{ $availability->date }}</td>
                    <td>{{ $availability->start_time }}</td>
                    <td>{{ $availability->end_time }}</td>
                    <td>{{ $availability->interval }}</td>
                    <td>
                        <a href="{{ route('admin.availabilities.edit', $availability->id) }}" class="action-btn edit-btn">Edit</a>
                        <form action="{{ route('admin.availabilities.destroy', $availability->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this availability?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $availabilities->appends(request()->query())->links() }}
    </div>
    @if(session('success'))
        <script>
            setTimeout(function() {
                document.getElementById('success-message').style.display = 'none';
            }, 5000);
        </script>
    @endif
@endsection
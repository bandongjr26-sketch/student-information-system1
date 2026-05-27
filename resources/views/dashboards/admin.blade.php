@extends('layout.format')

@section('title', 'Admin Dashboard')

@section('content')
<div class="p-4 bg-light rounded border">
    <h2>Admin Dashboard</h2>
    <p>Welcome, {{ $user }}. This is your admin dashboard.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('students.create') }}" class="btn btn-success me-2">Add Student</a>
    <a href="{{ route('teachers.create') }}" class="btn btn-primary me-2">Add Teacher</a>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">View Students</a>
</div>
@endsection

@extends('layout.format')

@section('title', 'Student Dashboard')

@section('content')
<div class="p-4 bg-light rounded border">
    <h2>Student Dashboard</h2>
    <p class="mb-0">Welcome, {{ $user }}. This is your student dashboard.</p>
</div>
@endsection

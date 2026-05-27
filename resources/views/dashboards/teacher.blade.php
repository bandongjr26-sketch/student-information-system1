@extends('layout.format')

@section('title', 'Teacher Dashboard')

@section('content')
<div class="p-4 bg-light rounded border">
    <h2>Teacher Dashboard</h2>
    <p class="mb-0">Welcome, {{ $user }}. This is your teacher dashboard.</p>
</div>
@endsection

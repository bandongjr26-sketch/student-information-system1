@extends('layout.format')

@section('title','Add Degree')

@section('content')

<div class="form-container mt-5 mx-auto" style="max-width: 500px;">
    <h2 class="text-center mb-4">Add New Degree</h2>

    <form id="addDegreeForm" action="{{ route('degrees.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="form-label fw-bold">Degree Title</label>
            <input type="text" id="degree_title" name="degree_title" value="{{ old('degree_title') }}" class="form-control styled-input" placeholder="Enter degree title" required>
            @error('degree_title')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" id="saveDegree" class="gradient-btn btn-lg me-3">Save Degree</button>
            <a href="{{ route('degrees.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

@endsection

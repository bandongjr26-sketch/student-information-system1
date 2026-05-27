@extends('layout.format')

@section('title', 'Edit Degree')

@section('content')

<div class="form-container mt-5 mx-auto" style="max-width: 500px;">
    <h2 class="text-center mb-4">Edit Degree</h2>

    <form id="editDegreeForm" action="{{ route('degrees.update', $degree) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" id="degree_id" value="{{ $degree->id }}">

        <div class="mb-4">
            <label class="form-label fw-bold">Degree Title</label>
            <input type="text" id="degree_title" name="degree_title" class="form-control styled-input" value="{{ old('degree_title', $degree->degree_title) }}" required>
            @error('degree_title')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" id="updateDegree" class="gradient-btn btn-lg me-3">Update Degree</button>
            <a href="{{ route('degrees.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

@endsection

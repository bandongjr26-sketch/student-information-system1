@extends('layout.format')

@section('title','Add Degree')

@section('content')

<div class="form-container mt-5 mx-auto" style="max-width: 500px;">
    <h2 class="text-center mb-4">Add New Degree</h2>

    <form id="addDegreeForm">
        @csrf

        <div class="mb-4">
            <label class="form-label fw-bold">Degree Title</label>
            <input type="text" id="degree_title" class="form-control styled-input" placeholder="Enter degree title" required>
        </div>

        <div class="text-center">
            <button type="button" id="saveDegree" class="gradient-btn btn-lg me-3">Save Degree</button>
            <a href="{{ route('degrees.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    window.addDegreeRoutes = {
        store: "{{ route('degrees.store') }}",
        index: "{{ route('degrees.index') }}"
    };
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endpush

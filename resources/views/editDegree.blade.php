@extends('layout.format')

@section('title', 'Edit Degree')

@section('content')

<div class="form-container mt-5 mx-auto" style="max-width: 500px;">
    <h2 class="text-center mb-4">Edit Degree</h2>

    <form id="editDegreeForm">
        @csrf
        <input type="hidden" id="degree_id" value="{{ $degree->id }}">

        <div class="mb-4">
            <label class="form-label fw-bold">Degree Title</label>
            <input type="text" id="degree_title" class="form-control styled-input" value="{{ $degree->degree_title }}" required>
        </div>

        <div class="text-center">
            <button type="button" id="updateDegree" class="gradient-btn btn-lg me-3">Update Degree</button>
            <a href="{{ route('degrees.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    window.editDegreeRoutes = {
        base: "{{ url('degrees') }}",
        index: "{{ route('degrees.index') }}"
    };
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endpush

@extends('layout.format')

@section('title','Degrees')

@section('content')

<h2>Degrees</h2>

<div id="degree-alert" class="alert d-none"></div>

<form id="degree-form" class="row g-2 mb-3">
    @csrf
    <input type="hidden" id="degree-id">
    <div class="col-md-8">
        <input type="text" id="degree_title" class="form-control" placeholder="Degree name">
        <div id="degree-title-error" class="text-danger small mt-1"></div>
    </div>
    <div class="col-md-4">
        <button type="submit" id="save-degree" class="btn btn-success">Add Degree</button>
        <button type="button" id="cancel-edit" class="btn btn-secondary d-none">Cancel</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Degree Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="degree-table-body">
        <tr>
            <td colspan="3" class="text-center">Loading degrees...</td>
        </tr>
    </tbody>
</table>

@endsection

@push('scripts')
<script>
    window.degreeRoutes = {
        index: "{{ route('degrees.index') }}",
        base: "{{ url('degrees') }}"
    };
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endpush

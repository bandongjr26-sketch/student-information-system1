@extends('layout.format')

@section('title', 'Stud info')

@section('content')
<h2>Student List</h2>
@if(!empty($user))
Welcome, {{ $user }}!<br>
@endif
<!-- Add Student Button -->
<a href="{{ route('students.create') }}" class="btn btn-success mb-3">Add Student</a>

<div id="student-alert" class="alert d-none"></div>
<small id="student-list-status" class="text-muted d-block mb-2"></small>

<table class="table table-bordered table-striped">
    <thead class="table-primary">
        <tr>
            <td>Full Name</td>
            <td>Email</td>
            <td>Contact Number</td> 
            <td>Degree</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody id="student-table-body">
        <tr>
            <td colspan="5" class="text-center">Loading students...</td>
        </tr>
    </tbody>
</table>
@endsection

@push('scripts')
<script>
    window.studentRoutes = {
        index: "{{ route('students.index') }}",
        base: "{{ url('students') }}"
    };
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>
@endpush

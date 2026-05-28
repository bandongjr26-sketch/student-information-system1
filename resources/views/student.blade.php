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
        </tr>
    </thead>
    <tbody id="student-table-body">
        @forelse($students as $student)
            <tr>
                <td>
                    {{ collect([$student->lname, $student->mname, $student->fname])->filter()->join(', ') }}
                </td>
                <td>{{ $student->email ?? $student->userAccount->email ?? 'N/A' }}</td>
                <td>{{ $student->contactno ?? 'N/A' }}</td>
                <td>{{ $student->degree->degree_title ?? 'N/A' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No students found</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $students->links() }}
@endsection

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
        @forelse($studentAccounts as $studentAccount)
            @php($student = $studentAccount->student)
            <tr>
                <td>
                    @if($student)
                        {{ collect([$student->lname, $student->mname, $student->fname])->filter()->join(', ') }}
                    @else
                        {{ $studentAccount->username }}
                    @endif
                </td>
                <td>{{ $studentAccount->email ?? 'N/A' }}</td>
                <td>{{ $student->contactno ?? 'N/A' }}</td>
                <td>{{ $student->degree->degree_title ?? 'N/A' }}</td>
                <td>
                    @if($student)
                        <a href="{{ route('students.show', $student) }}" class="btn btn-info btn-sm me-1">View</a>
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                        <form method="POST" action="{{ route('students.destroy', $student) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                        </form>
                    @else
                        <span class="text-muted">No student profile</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No students found</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $studentAccounts->links() }}
@endsection

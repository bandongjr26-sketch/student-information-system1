@extends('layout.format')

@section('title', 'Student Accounts')

@section('content')
<h2>Student List</h2>
@if(!empty($user))
Welcome, {{ $user }}!<br>
@endif

<table class="table table-bordered table-striped mt-3">
    <thead class="table-primary">
        <tr>
            <td>Username</td>
            <td>Full Name</td>
            <td>Email</td>
            <td>Contact Number</td>
            <td>Degree</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
        @forelse($studentAccounts as $studentAccount)
            @php($student = $studentAccount->student)
            <tr>
                <td>{{ $studentAccount->username }}</td>
                <td>
                    @if($student)
                        {{ collect([$student->lname, $student->mname, $student->fname])->filter()->join(', ') }}
                    @else
                        <span class="text-muted">No student profile</span>
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
                        <span class="text-muted">No actions available</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No student accounts found</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $studentAccounts->links() }}
@endsection

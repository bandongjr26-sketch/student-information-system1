@extends('layout.format')

@section('title', 'Student Account')

@section('content')
<h2>Student Account Details</h2>

<p>Username: {{ $studentAccount->username }}</p>
<p>Email: {{ $studentAccount->email }}</p>

@if($student)
    <p>First Name: {{ $student->fname }}</p>
    <p>Middle Name: {{ $student->mname ?: 'No middle name' }}</p>
    <p>Last Name: {{ $student->lname }}</p>
    <p>Contact: {{ $student->contactno ?: 'No contact number' }}</p>
    <p>Degree: {{ $student->degree->degree_title ?? 'No degree' }}</p>
@else
    <p>Student Details: No student details yet</p>
@endif

<a href="{{ route('student-accounts.index') }}" class="btn btn-secondary">Back to Student List</a>
@endsection

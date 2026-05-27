@extends('layout.format')

@section('title','Student Info')

@section('content')

<h2>Student Information</h2>

<p>First Name: {{$student->fname}}</p>
<p>Middle Name: {{$student->mname}}</p>
<p>Last Name: {{$student->lname}}</p>
<p>Email: {{$student->userAccount->email ?? 'N/A'}}</p>
<p>Contact: {{$student->contactno}}</p>
<p>Degree: {{$student->degree->degree_title ?? 'N/A'}}</p>

<a href="{{ route('students.index') }}">Back to Student List</a>

@endsection

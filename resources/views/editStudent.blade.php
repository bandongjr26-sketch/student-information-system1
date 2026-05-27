@extends('layout.format')

@section('title', 'Edit Student')

@section('content')

<div class="form-container mt-5">
    <h2 class="text-center mb-4">Edit Student</h2>

    <form id="editStudentForm" action="{{ route('students.update', $student) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" id="student_id" value="{{ $student->id }}">

        <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">First Name</label>
                    <input type="text" id="f_name" name="fname" class="form-control styled-input" value="{{ old('fname', $student->fname) }}">
                </div>
            </div>
            <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Middle Name</label>
                    <input type="text" id="m_name" name="mname" class="form-control styled-input" value="{{ old('mname', $student->mname) }}">
                </div>
            </div>

            <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Last Name</label>
                    <input type="text" id="l_name" name="lname" class="form-control styled-input" value="{{ old('lname', $student->lname) }}">
                </div>
            </div>
            <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" id="e_mail" name="email" class="form-control styled-input" value="{{ old('email', $student->userAccount->email ?? '') }}">
                </div>
            </div>

            <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Contact Number</label>
                    <input type="tel" id="contact_no" name="contactno" class="form-control styled-input" value="{{ old('contactno', $student->contactno) }}">
                </div>
            </div>
            <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Degree</label>
                    <select id="degree_id" name="degree_id" class="form-control styled-input">
                        <option value="">Select Degree</option>
                        @foreach($degrees as $degree)
                            <option value="{{ $degree->id }}"
                                @selected(old('degree_id', $student->degree_id) == $degree->id)>
                                {{ $degree->degree_title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        <div class="text-center">
            <button type="submit" id="updateStudent" class="gradient-btn btn-lg me-3">Update Student</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
        @if($errors->any())
        <div class= "alert alert-danger">
            
                @foreach($errors->all() as $error)
                {{$error}} </br>
                @endforeach
            
        </div>
        @endif
    </form>
</div>

@endsection

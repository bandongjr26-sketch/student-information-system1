@extends('layout.format')

@section('title','Add Student')

@section('content')

<div class="form-container mt-5">
    <h2 class="text-center mb-4">Add New Student</h2>

    <form id="addStudentForm" action="{{ route('students.store') }}" method="POST">
        @csrf

<div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">First Name</label>
                    <input type="text" id="f_name" name="fname" value="{{ old('fname') }}" class="form-control styled-input">
                </div>
            </div>
            <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Middle Name</label>
                    <input type="text" id="m_name" name="mname" value="{{ old('mname') }}" class="form-control styled-input">
                </div>
            </div>

<div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Last Name</label>
                    <input type="text" id="l_name" name="lname" value="{{ old('lname') }}" class="form-control styled-input">
                </div>
            </div>
            <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" id="e_mail" name="email" value="{{ old('email') }}" class="form-control styled-input">
                </div>
            </div>

<div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Contact Number</label>
                    <input type="tel" id="contact_no" name="contactno" value="{{ old('contactno') }}" class="form-control styled-input" inputmode="numeric" pattern="[0-9]{11}" maxlength="11">
                </div>
            </div>
            <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Degree</label>
                    <select id="degree_id" name="degree_id" class="form-control styled-input">
                        <option value="">Select Degree</option>
                        @foreach($degrees as $degree)
                            <option value="{{ $degree->id }}" @selected(old('degree_id') == $degree->id)>
                                {{ $degree->degree_title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

       
            
            <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control styled-input">
                </div>
            </div>
             <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" id="password" name="password" class="form-control styled-input">
                </div>
            </div>

             <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Re-enter Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control styled-input">
                </div>
            </div>

        <div class="text-center">
            <button type="submit" id="saveStudent" class="gradient-btn btn-lg me-3">Save Student</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
</br>
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

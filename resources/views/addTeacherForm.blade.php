@extends('layout.format')

@section('title', 'Add Teacher')

@section('content')
<div class="form-container mt-5">
    <h2 class="text-center mb-4">Add New Teacher</h2>

    <form id="addTeacherForm" action="{{ route('teachers.store') }}" method="POST">
        @csrf

        <div class="text-center mb-4">
            <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                <label class="form-label fw-bold">Username</label>
                <input type="text" id="teacher_username" name="username" value="{{ old('username') }}" class="form-control styled-input">
            </div>
        </div>

        <div class="text-center mb-4">
            <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                <label class="form-label fw-bold">Email</label>
                <input type="email" id="teacher_email" name="email" value="{{ old('email') }}" class="form-control styled-input">
            </div>
        </div>

        <div class="text-center mb-4">
            <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                <label class="form-label fw-bold">Password</label>
                <input type="password" id="teacher_password" name="password" class="form-control styled-input">
            </div>
        </div>

        <div class="text-center mb-4">
            <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                <label class="form-label fw-bold">Re-enter Password</label>
                <input type="password" id="teacher_password_confirmation" name="password_confirmation" class="form-control styled-input">
            </div>
        </div>

        <div class="text-center">
            <button type="submit" id="saveTeacher" class="gradient-btn btn-lg me-3">Save Teacher</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-lg">Cancel</a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mt-4">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif
    </form>
</div>
@endsection

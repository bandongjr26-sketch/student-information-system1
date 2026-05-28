@extends('layout.format')

@section('title', 'Edit Student Account')

@section('content')
<div class="form-container mt-5">
    <h2 class="text-center mb-4">Edit Student Account</h2>

    <form action="{{ route('student-accounts.update', $studentAccount) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="text-center mb-4">
            <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                <label class="form-label fw-bold">Username</label>
                <input type="text" name="username" value="{{ old('username', $studentAccount->username) }}" class="form-control styled-input">
            </div>
        </div>

        <div class="text-center mb-4">
            <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" value="{{ old('email', $studentAccount->email) }}" class="form-control styled-input">
            </div>
        </div>

        @if($student)
            <div class="text-center mb-4">
                <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                    <label class="form-label fw-bold">Full Name</label>
                    <input type="text" value="{{ collect([$student->lname, $student->mname, $student->fname])->filter()->join(', ') }}" class="form-control styled-input" disabled>
                </div>
            </div>
        @endif

        <div class="text-center mb-4">
            <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                <label class="form-label fw-bold">New Password</label>
                <input type="password" name="password" class="form-control styled-input">
            </div>
        </div>

        <div class="text-center mb-4">
            <div class="mb-3" style="max-width: 400px; margin: 0 auto;">
                <label class="form-label fw-bold">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control styled-input">
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="gradient-btn btn-lg me-3">Update Account</button>
            <a href="{{ route('student-accounts.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
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

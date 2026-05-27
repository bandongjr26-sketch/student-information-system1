@extends('layout.format')

@section('title', 'Change Password')

@section('content')
<div class="form-container mt-5">
    <h2 class="text-center mb-3">Change Your Password</h2>
    <p class="text-center text-muted mb-4">Please create a new password before opening your dashboard.</p>

    <form id="changePasswordForm">
        @csrf

        <div class="mb-3" style="max-width: 420px; margin: 0 auto;">
            <label class="form-label fw-bold">Current Password</label>
            <input type="password" id="change_current_password" class="form-control styled-input" required>
        </div>

        <div class="mb-3" style="max-width: 420px; margin: 0 auto;">
            <label class="form-label fw-bold">New Password</label>
            <input type="password" id="change_new_password" class="form-control styled-input" required>
        </div>

        <div class="mb-4" style="max-width: 420px; margin: 0 auto;">
            <label class="form-label fw-bold">Re-enter Password</label>
            <input type="password" id="change_new_password_confirmation" class="form-control styled-input" required>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" style="max-width: 420px; margin: 0 auto 1rem;">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <div class="text-center">
            <button type="button" id="changePasswordBtn" class="gradient-btn btn-lg">Update Password</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    window.changePasswordRoutes = {
        update: "{{ route('password.update') }}"
    };
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endpush

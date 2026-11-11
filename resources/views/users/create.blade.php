@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-2">Add New User</h2>
    <p class="text-muted">Create a new account.</p>

    <div class="card shadow-sm border-0 p-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name"
                    class="form-control"
                    value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email"
                    class="form-control"
                    value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="">Select Role</option>
                    <option value="staff">Staff</option>
                    <option value="teacher">Teacher</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password"
                    name="password_confirmation"
                    class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">
                Create Account
            </button>

            <a href="{{ route('users.index') }}"
                class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@endsection
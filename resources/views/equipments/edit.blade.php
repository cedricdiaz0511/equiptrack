@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-2">Edit User</h2>
    <p class="text-muted">Update account information.</p>

    <div class="card shadow-sm border-0 p-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $user->name) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email', $user->email) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Account Role</label>

                <select name="role" class="form-select" required>
                    @foreach (['admin', 'staff', 'teacher', 'student'] as $role)
                        <option value="{{ $role }}"
                            {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <hr>

            <h5>Change Password</h5>
            <p class="text-muted">
                Leave blank if you do not want to change the password.
            </p>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       minlength="8">
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">
                Save Changes
            </button>

            <a href="{{ route('users.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@endsection
```

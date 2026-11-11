@extends('layouts.app')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('page-subtitle', 'Manage administrator, staff, teacher, and student accounts.')

@section('content')

<style>
    .users-page {
        padding: 5px 0 30px;
    }

    .users-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .users-stat {
        background: white;
        padding: 22px;
        border-radius: 17px;
        border: 1px solid #e4eaf4;
        box-shadow: 0 8px 25px rgba(30, 60, 100, .05);
    }

    .users-stat span {
        color: #718096;
        font-size: 13px;
    }

    .users-stat h2 {
        color: #102b50;
        font-size: 30px;
        margin: 12px 0 0;
    }

    .users-panel {
        background: white;
        padding: 25px;
        border-radius: 18px;
        border: 1px solid #e4eaf4;
        box-shadow: 0 8px 25px rgba(30, 60, 100, .05);
    }

    .users-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 22px;
    }

    .users-header h2 {
        color: #102b50;
        margin: 0 0 6px;
    }

    .users-header p {
        color: #718096;
        font-size: 13px;
        margin: 0;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table th {
        background: #f5f8fc;
        color: #64748b;
        font-size: 12px;
        text-align: left;
        padding: 15px;
        text-transform: uppercase;
    }

    .users-table td {
        padding: 16px 15px;
        border-bottom: 1px solid #edf1f7;
        color: #334155;
        font-size: 13px;
    }

    .role-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: capitalize;
    }

    .role-admin {
        background: #e8efff;
        color: #245bea;
    }

    .role-staff {
        background: #fff2df;
        color: #c27a16;
    }

    .role-teacher {
        background: #e7f9ef;
        color: #168653;
    }

    .role-student {
        background: #f0eaff;
        color: #7446c7;
    }

    .user-actions {
        display: flex;
        gap: 7px;
        align-items: center;
    }

    .user-btn {
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .edit-btn {
        background: #eaf1ff;
        color: #245bea;
    }

    .delete-btn {
        background: #fff0f0;
        color: #dc3545;
    }

    .add-user-btn {
        background: #2563eb;
        color: white;
        padding: 11px 17px;
        border-radius: 9px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
    }

    .alert-success {
        background: #e8f8ef;
        color: #168653;
        padding: 13px 16px;
        border-radius: 9px;
        margin-bottom: 18px;
    }

    .alert-error {
        background: #fff0f0;
        color: #dc3545;
        padding: 13px 16px;
        border-radius: 9px;
        margin-bottom: 18px;
    }

    @media(max-width: 900px) {
        .users-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width: 600px) {
        .users-stats {
            grid-template-columns: 1fr;
        }

        .users-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .users-table {
            min-width: 650px;
        }
    }
</style>

<div class="users-page">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- USER STATISTICS --}}

    <div class="users-stats">

        <div class="users-stat">
            <span>Total Users</span>
            <h2>{{ $totalUsers }}</h2>
        </div>

        <div class="users-stat">
            <span>Administrators</span>
            <h2>{{ $totalAdmins }}</h2>
        </div>

        <div class="users-stat">
            <span>Staff / Teachers</span>
            <h2>{{ $totalStaff + $users->filter(fn($u) => strtolower(trim($u->role ?? '')) === 'teacher')->count() }}</h2>
        </div>

        <div class="users-stat">
            <span>Students</span>
            <h2>{{ $totalStudents }}</h2>
        </div>

    </div>

    {{-- USER TABLE --}}

    <section class="users-panel">

        <div class="users-header">
            <div>
                <h2>Registered Accounts</h2>
                <p>View and manage all accounts registered in EquipTrack.</p>
            </div>

            <a href="{{ route('users.create') }}" class="add-user-btn">
                + Add New User
            </a>
        </div>

        <div style="overflow-x:auto;">

            <table class="users-table">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Account ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)

                        @php
                            $role = strtolower(trim($user->role ?? 'student'));
                        @endphp

                        <tr>

                            <td>
                                <strong>{{ $user->name }}</strong>
                            </td>

                            <td>{{ $user->email }}</td>

                            <td>
                                <span class="role-badge
                                    {{ in_array($role, ['admin', 'administrator']) ? 'role-admin' :
                                    ($role === 'staff' ? 'role-staff' :
                                    ($role === 'teacher' ? 'role-teacher' : 'role-student')) }}">
                                    {{ $role }}
                                </span>
                            </td>

                            <td>{{ $user->getKey() }}</td>

                            <td>
                                <div class="user-actions">

                                    <a href="{{ route('users.edit', $user->getKey()) }}"
                                       class="user-btn edit-btn">
                                        Edit
                                    </a>

                                    @if(!in_array($role, ['admin', 'administrator'])
                                        && (string) $user->getKey() !== (string) auth()->id())

                                        <form action="{{ route('users.destroy', $user->getKey()) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this account?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="user-btn delete-btn">
                                                Delete
                                            </button>

                                        </form>

                                    @endif

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" style="text-align:center; padding:30px;">
                                No registered users found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

</div>

@endsection
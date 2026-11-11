
@extends('layouts.app')

@section('title', 'Borrowing History')
@section('page-title', 'Borrowing History')
@section('page-subtitle', 'View and manage equipment borrowing requests.')

@section('content')

<style>
.borrow-panel {
    background: white;
    padding: 25px;
    border-radius: 16px;
    border: 1px solid #e4eaf4;
}

.borrow-table {
    width: 100%;
    border-collapse: collapse;
}

.borrow-table th {
    background: #f5f8fc;
    padding: 14px;
    color: #64748b;
    text-align: left;
    font-size: 12px;
}

.borrow-table td {
    padding: 15px;
    border-bottom: 1px solid #edf1f7;
    font-size: 13px;
}

.borrow-status {
    padding: 6px 11px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    background: #fff3cd;
    color: #997000;
}

.borrow-actions {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.borrow-actions button {
    border: 0;
    padding: 8px 12px;
    border-radius: 7px;
    color: white;
    cursor: pointer;
    font-weight: 600;
}

.approve { background: #16a36a; }
.reject { background: #dc3545; }
.release { background: #2563eb; }
.return { background: #0d9488; }
</style>

<div class="borrow-panel">

    @if(session('success'))
        <div style="background:#e8f8ef;color:#168653;padding:12px;margin-bottom:15px;border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#fff0f0;color:#dc3545;padding:12px;margin-bottom:15px;border-radius:8px;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h2>{{ auth()->user()->role === 'student' ? 'My Borrowing Requests' : 'Borrowing Requests' }}</h2>

        @if(strtolower(auth()->user()->role) === 'student')
            <a href="{{ route('equipment.index') }}" class="btn btn-primary">
                Browse Equipment
            </a>
        @endif
    </div>

    <div style="overflow-x:auto;">
        <table class="borrow-table">

            <thead>
                <tr>
                    @if(strtolower(auth()->user()->role) !== 'student')
                        <th>Student</th>
                    @endif
                    <th>Equipment</th>
                    <th>Quantity</th>
                    <th>Purpose</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            @forelse($borrowings as $borrowing)

                @php
                    $role = strtolower(auth()->user()->role);
                    $status = strtolower($borrowing->status);
                @endphp

                <tr>

                    @if($role !== 'student')
                        <td>
                            {{ $borrowing->user_name }}
                            <br>
                            <small>{{ $borrowing->user_email }}</small>
                        </td>
                    @endif

                    <td>{{ $borrowing->equipment_name }}</td>

                    <td>{{ $borrowing->quantity }}</td>

                    <td>{{ $borrowing->purpose }}</td>

                    <td>{{ $borrowing->expected_return_date }}</td>

                    <td>
                        <span class="borrow-status">
                            {{ $borrowing->status }}
                        </span>
                    </td>

                    <td>
                        <div class="borrow-actions">

                            @if(in_array($role, ['admin','administrator','teacher']) && $status === 'pending')

                                <form method="POST" action="{{ route('borrowings.approve', $borrowing->getKey()) }}">
                                    @csrf
                                    <button class="approve">Approve</button>
                                </form>

                                <form method="POST" action="{{ route('borrowings.reject', $borrowing->getKey()) }}">
                                    @csrf
                                    <button class="reject">Reject</button>
                                </form>

                            @endif

                            @if(in_array($role, ['admin','administrator','staff','teacher']) && $status === 'approved')

                                <form method="POST" action="{{ route('borrowings.release', $borrowing->getKey()) }}">
                                    @csrf
                                    <button class="release">Release Equipment</button>
                                </form>

                            @endif

                            @if(in_array($role, ['admin','administrator','staff','teacher']) && $status === 'released')

                                <form method="POST" action="{{ route('borrowings.return', $borrowing->getKey()) }}">

                                    @csrf

                                    <select name="return_condition" required>
                                        <option value="">Select condition</option>
                                        <option value="Good">Good</option>
                                        <option value="Damaged">Damaged</option>
                                        <option value="Needs Repair">Needs Repair</option>
                                    </select>

                                    <textarea name="return_notes" placeholder="Return notes"></textarea>

                                    <button class="return" type="submit">Mark Returned</button>
                                </form>

                            @endif

                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" style="text-align:center;padding:30px;">
                        No borrowing requests found.
                    </td>
                </tr>

            @endforelse

            </tbody>
        </table>
    </div>

</div>

@endsection

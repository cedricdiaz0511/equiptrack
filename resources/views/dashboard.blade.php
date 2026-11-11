
@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('page-subtitle')
    @if(strtolower(auth()->user()->role ?? '') === 'student')
        Welcome to your student equipment dashboard.
    @else
        A clear overview of your equipment operations.
    @endif
@endsection

@section('content')

@php
    $role = strtolower(trim(auth()->user()->role ?? ''));

    $isStudent = $role === 'student';
    $isAdmin = in_array($role, ['admin', 'administrator']);
    $isTeacher = $role === 'teacher';
@endphp

<style>
    .et-dashboard {
        padding: 5px 0 30px;
        background:
            radial-gradient(circle at 85% 5%, rgba(59,130,246,.12), transparent 30%),
            linear-gradient(135deg, #f0f6ff, #f8fbff 55%, #e8f2ff);
        border-radius: 18px;
    }

    /* WELCOME BANNER */

    .et-welcome {
        position: relative;
        overflow: hidden;
        min-height: 205px;
        padding: 35px 40px;
        margin-bottom: 24px;
        border-radius: 22px;
        display: flex;
        align-items: center;

        background:
            linear-gradient(90deg,
                rgba(5,36,91,.98) 0%,
                rgba(0,85,180,.87) 48%,
                rgba(0,93,180,.18) 100%
            ),
            url('https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1600&q=85')
            center 48% / cover no-repeat;

        box-shadow: 0 12px 30px rgba(30,91,170,.18);
    }

    .et-welcome-content {
        position: relative;
        z-index: 2;
        max-width: 650px;
        color: white;
    }

    .et-welcome-label {
        display: inline-block;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #93d5ff;
        margin-bottom: 12px;
    }

    .et-welcome h2 {
        color: white;
        font-size: clamp(25px,3vw,36px);
        font-weight: 800;
        margin: 0 0 10px;
    }

    .et-welcome p {
        color: #e0efff;
        font-size: 15px;
        margin: 0;
        line-height: 1.7;
    }

    /* STATISTICS */

    .et-stats {
        display: grid;
        grid-template-columns: repeat(4,minmax(0,1fr));
        gap: 16px;
        margin-bottom: 25px;
    }

    .et-stat {
        background: rgba(255,255,255,.96);
        padding: 22px;
        border-radius: 18px;
        border: 1px solid #e5edf8;
        box-shadow: 0 7px 20px rgba(31,65,114,.07);
        transition: .2s ease;
    }

    .et-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(31,65,114,.12);
    }

    .et-stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }

    .et-stat-title {
        color: #526681;
        font-size: 13px;
        font-weight: 700;
    }

    .et-stat-icon {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 22px;
        font-weight: 800;
    }

    .et-blue {
        background: #e7f0ff;
        color: #1769e8;
    }

    .et-green {
        background: #e2f8ed;
        color: #07965b;
    }

    .et-orange {
        background: #fff1dc;
        color: #e58a08;
    }

    .et-red {
        background: #ffe8e9;
        color: #e33c46;
    }

    .et-stat-value {
        font-size: 34px;
        font-weight: 850;
        line-height: 1.2;
        color: #102b50;
    }

    .et-stat-note {
        font-size: 12px;
        color: #7b8da8;
        margin-top: 6px;
    }

    /* CONTENT PANEL */

    .et-section {
        background: rgba(255,255,255,.97);
        border: 1px solid #e4ebf5;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 8px 25px rgba(31,65,114,.07);
        margin-bottom: 22px;
    }

    .et-section-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 22px;
    }

    .et-section-head h2 {
        color: #102b50;
        font-size: 20px;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .et-section-head p {
        color: #8191a9;
        font-size: 13px;
        margin: 0;
    }

    /* BUTTONS */

    .et-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 18px;
        border-radius: 11px;
        text-decoration: none !important;
        font-size: 13px;
        font-weight: 750;
        transition: .2s ease;
    }

    .et-btn-primary {
        background: linear-gradient(135deg,#1478f5,#1551c9);
        color: white !important;
        box-shadow: 0 5px 12px rgba(21,94,210,.18);
    }

    .et-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 17px rgba(21,94,210,.25);
    }

    .et-btn-light {
        background: #edf4ff;
        color: #1754a6 !important;
    }

    .et-btn-light:hover {
        background: #dceaff;
    }

    /* EQUIPMENT TABLE */

    .et-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .et-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 550px;
    }

    .et-table thead {
        background: #edf4ff;
    }

    .et-table th {
        padding: 15px 13px;
        color: #607694;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .6px;
        text-align: left;
    }

    .et-table td {
        padding: 16px 13px;
        border-bottom: 1px solid #edf1f7;
        color: #40536d;
        font-size: 13px;
    }

    .et-table tbody tr:hover {
        background: #f7faff;
    }

    .et-equipment-name {
        color: #102b50 !important;
        font-weight: 750;
    }

    /* STATUS */

    .et-status {
        display: inline-flex;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .et-status-available {
        background: #e2f8ed;
        color: #07864f;
    }

    .et-status-borrowed {
        background: #fff1dc;
        color: #b66a00;
    }

    .et-status-maintenance {
        background: #ffe8e9;
        color: #ce343e;
    }

    .et-empty {
        text-align: center;
        padding: 30px !important;
        color: #8998ad !important;
    }

    .et-section-footer {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 22px;
    }

    /* STUDENT INFORMATION */

    .et-info-box {
        background: linear-gradient(135deg,#edf5ff,#f8fbff);
        border: 1px solid #dceaff;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 22px;
    }

    .et-info-box h3 {
        color: #153b70;
        font-size: 17px;
        font-weight: 800;
        margin: 0 0 8px;
    }

    .et-info-box p {
        color: #71839e;
        font-size: 13px;
        line-height: 1.7;
        margin: 0;
    }

    /* RESPONSIVE */

    @media(max-width:1000px) {
        .et-stats {
            grid-template-columns: repeat(2,minmax(0,1fr));
        }
    }

    @media(max-width:600px) {
        .et-welcome {
            min-height: 180px;
            padding: 25px 20px;
            background-position: center;
        }

        .et-welcome h2 {
            font-size: 25px;
        }

        .et-stats {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .et-stat {
            padding: 15px;
        }

        .et-stat-value {
            font-size: 27px;
        }

        .et-section {
            padding: 17px;
        }

        .et-section-head {
            align-items: flex-start;
        }

        .et-btn {
            font-size: 12px;
        }
    }
</style>


<div class="et-dashboard">

    {{-- WELCOME BANNER --}}

    <section class="et-welcome">

        <div class="et-welcome-content">

            <span class="et-welcome-label">
                EQUIPTRACK | SCHOOL EQUIPMENT MANAGEMENT
            </span>

            <h2>
                Welcome back,<br>
                {{ auth()->user()->name }}!
            </h2>

            @if($isStudent)

                <p>
                    Browse school equipment and check its current availability.
                </p>

            @elseif($isTeacher)

                <p>
                    Monitor school equipment and manage your equipment operations.
                </p>

            @else

                <p>
                    Manage, monitor, and organize your school equipment records.
                </p>

            @endif

        </div>

    </section>


    {{-- EQUIPMENT STATISTICS --}}

    <div class="et-stats">

        <section class="et-stat">

            <div class="et-stat-top">
                <span class="et-stat-title">Total Equipment</span>
                <span class="et-stat-icon et-blue">▤</span>
            </div>

            <div class="et-stat-value">
                {{ number_format($totalQuantity) }}
            </div>

            <div class="et-stat-note">
                Registered units
            </div>

        </section>


        <section class="et-stat">

            <div class="et-stat-top">
                <span class="et-stat-title">Available</span>
                <span class="et-stat-icon et-green">✓</span>
            </div>

            <div class="et-stat-value">
                {{ number_format($availableQuantity) }}
            </div>

            <div class="et-stat-note">
                Ready for use
            </div>

        </section>


        <section class="et-stat">

            <div class="et-stat-top">
                <span class="et-stat-title">Borrowed</span>
                <span class="et-stat-icon et-orange">↗</span>
            </div>

            <div class="et-stat-value">
                {{ number_format($borrowedQuantity) }}
            </div>

            <div class="et-stat-note">
                Currently borrowed
            </div>

        </section>


        <section class="et-stat">

            <div class="et-stat-top">
                <span class="et-stat-title">Under Maintenance</span>
                <span class="et-stat-icon et-red">⚒</span>
            </div>

            <div class="et-stat-value">
                {{ number_format($maintenanceQuantity) }}
            </div>

            <div class="et-stat-note">
                Temporarily unavailable
            </div>

        </section>

    </div>


    {{-- STUDENT DASHBOARD --}}

    @if($isStudent)

        <section class="et-section">

            <div class="et-section-head">

                <div>
                    <h2>Equipment Information</h2>

                    <p>
                        View registered school equipment and check its current status.
                    </p>
                </div>

                <a href="{{ route('equipment.index') }}"
                   class="et-btn et-btn-light">
                    View all equipment →
                </a>

            </div>


            <div class="et-info-box">

                <h3>Student Equipment Portal</h3>

                <p>
                    Welcome to EquipTrack! You can browse the equipment
                    inventory, check available quantities, and view the
                    current status of each registered item.
                </p>

            </div>


            <div class="et-table-wrap">

                <table class="et-table">

                    <thead>
                        <tr>
                            <th>Equipment</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recentEquipments as $equipment)

                            <tr>

                                <td class="et-equipment-name">
                                    {{ $equipment->name }}
                                </td>

                                <td>
                                    {{ $equipment->category }}
                                </td>

                                <td>

                                    <span class="et-status
                                        {{ $equipment->status === 'Available'
                                            ? 'et-status-available'
                                            : ($equipment->status === 'Borrowed'
                                                ? 'et-status-borrowed'
                                                : 'et-status-maintenance') }}">

                                        {{ $equipment->status }}

                                    </span>

                                </td>

                                <td>
                                    {{ number_format((int) $equipment->quantity) }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="et-empty">
                                    No equipment has been registered yet.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="et-section-footer">

                <a href="{{ route('equipment.index') }}"
                   class="et-btn et-btn-primary">
                    ☷ View Equipment Inventory
                </a>

            </div>

        </section>


    {{-- ADMIN AND TEACHER DASHBOARD --}}

    @else

        <section class="et-section">

            <div class="et-section-head">

                <div>
                    <h2>Equipment Information</h2>

                    <p>
                        Latest registered equipment records in your inventory.
                    </p>
                </div>

                <a href="{{ route('equipment.index') }}"
                   class="et-btn et-btn-light">
                    View all equipment →
                </a>

            </div>


            <div class="et-table-wrap">

                <table class="et-table">

                    <thead>
                        <tr>
                            <th>Equipment</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recentEquipments as $equipment)

                            <tr>

                                <td class="et-equipment-name">
                                    {{ $equipment->name }}
                                </td>

                                <td>
                                    {{ $equipment->category }}
                                </td>

                                <td>

                                    <span class="et-status
                                        {{ $equipment->status === 'Available'
                                            ? 'et-status-available'
                                            : ($equipment->status === 'Borrowed'
                                                ? 'et-status-borrowed'
                                                : 'et-status-maintenance') }}">

                                        {{ $equipment->status }}

                                    </span>

                                </td>

                                <td>
                                    {{ number_format((int) $equipment->quantity) }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="et-empty">
                                    No equipment has been added yet.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="et-section-footer">

                @if($isAdmin || $isTeacher)

                    <a href="{{ route('equipment.create') }}"
                       class="et-btn et-btn-primary">
                        ＋ Add New Equipment
                    </a>

                @endif

                @if($isAdmin)

                    <a href="{{ route('analytics') }}"
                       class="et-btn et-btn-light">
                        View Analytics →
                    </a>

                @endif

            </div>

        </section>

    @endif

</div>

@endsection

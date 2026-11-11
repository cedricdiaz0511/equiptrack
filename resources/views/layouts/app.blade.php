
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | EquipTrack</title>

    <style>
        :root {
            --navy: #101a2e;
            --navy-soft: #182640;
            --blue: #2563eb;
            --bg: #f3f6fb;
            --surface: #ffffff;
            --text: #17243b;
            --muted: #718096;
            --line: #e5eaf2;
            --green: #0f9f6e;
            --amber: #c27a12;
            --red: #c24141;
            --shadow: 0 8px 28px rgba(20, 35, 65, .06);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: Inter, ui-sans-serif, system-ui,
                -apple-system, "Segoe UI", sans-serif;
        }

        a {
            color: inherit;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 252px;
            padding: 26px 17px;
            background: var(--navy);
            color: #dce6f7;
            display: flex;
            flex-direction: column;
            z-index: 20;
            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 5px 12px 34px;
            color: #fff;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .brand-mark {
            display: grid;
            place-items: center;
            width: 37px;
            height: 37px;
            border-radius: 12px;
            background: linear-gradient(135deg, #38bdf8, #2563eb);
            color: white;
            font-size: 19px;
        }

        .nav-label {
            padding: 0 13px 11px;
            color: #8090aa;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-size: 10px;
            font-weight: 800;
        }

        .nav-links {
            display: grid;
            gap: 7px;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            border-radius: 10px;
            text-decoration: none;
            color: #b9c6da;
            font-size: 14px;
            font-weight: 600;
            transition: .18s ease;
        }

        .nav-links a:hover {
            background: var(--navy-soft);
            color: #fff;
        }

        .nav-links a.active {
            color: #fff;
            background: var(--blue);
            box-shadow: 0 7px 18px rgba(37, 99, 235, .25);
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 17px;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 18px 12px 0;
            color: #8493aa;
            font-size: 11px;
            line-height: 1.6;
        }

        /* MAIN CONTENT */

        .main {
            margin-left: 252px;
            min-height: 100vh;
            padding: 34px 38px 50px;
        }

        .topbar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 28px;
        }

        .eyebrow {
            color: var(--blue);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.25px;
            margin-bottom: 8px;
        }

        h1 {
            margin: 0;
            font-size: 29px;
            line-height: 1.2;
            letter-spacing: -.8px;
        }

        .subtitle {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 14px;
        }

        /* USER PROFILE */

        .profile {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 8px 12px 8px 8px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 13px;
            box-shadow: var(--shadow);
        }

        .avatar {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            background: #e8efff;
            color: var(--blue);
            font-weight: 800;
        }

        .profile strong {
            display: block;
            font-size: 12px;
        }

        .profile small {
            display: block;
            color: var(--muted);
            font-size: 10px;
            margin-top: 2px;
        }

        /* ALERT MESSAGES */

        .flash {
            padding: 13px 16px;
            border-radius: 11px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .flash.success {
            background: #e6f8ef;
            color: #087647;
            border: 1px solid #c7eed9;
        }

        .flash.error {
            background: #fff0f0;
            color: #a42c2c;
            border: 1px solid #f5d0d0;
        }

        /* DASHBOARD CARDS */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 22px;
        }

        .stat-card, .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 15px;
            box-shadow: var(--shadow);
        }

        .stat-card {
            padding: 21px 22px;
            position: relative;
            overflow: hidden;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            font-size: 17px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-top: 14px;
        }

        .stat-note {
            color: var(--muted);
            font-size: 11px;
            margin-top: 3px;
        }

        .icon-blue {
            background: #eaf1ff;
            color: #2563eb;
        }

        .icon-green {
            background: #e6f8ef;
            color: #0f9f6e;
        }

        .icon-amber {
            background: #fff4df;
            color: #c27a12;
        }

        .icon-red {
            background: #fff0f0;
            color: #c24141;
        }

        /* PANELS */

        .panel {
            padding: 22px;
            margin-bottom: 20px;
        }

        .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 17px;
        }

        .panel h2 {
            font-size: 16px;
            margin: 0;
            letter-spacing: -.2px;
        }

        .panel-desc {
            color: var(--muted);
            font-size: 12px;
            margin: 5px 0 0;
        }

        /* BUTTONS */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 15px;
            border: 0;
            border-radius: 9px;
            text-decoration: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            transition: .18s ease;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-light {
            background: #f0f4fa;
            color: #40516b;
        }

        .btn-light:hover {
            background: #e5ebf4;
        }

        .btn-danger {
            background: #fff0f0;
            color: #b83232;
        }

        /* TABLE */

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th {
            padding: 12px 13px;
            text-align: left;
            color: #8290a5;
            background: #f8fafd;
            text-transform: uppercase;
            letter-spacing: .65px;
            font-size: 10px;
            font-weight: 800;
        }

        td {
            padding: 14px 13px;
            border-bottom: 1px solid #edf0f5;
            font-size: 12px;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .equipment-name {
            font-weight: 700;
            color: #263650;
        }

        .muted {
            color: var(--muted);
        }

        /* STATUS */

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 30px;
            padding: 6px 10px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status:before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-available {
            background: #e7f8ef;
            color: #0d8a5a;
        }

        .status-borrowed {
            background: #fff4df;
            color: #b7791f;
        }

        .status-maintenance {
            background: #fff0f0;
            color: #bd4141;
        }

        /* FORMS */

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 17px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group.full {
            grid-column: 1/-1;
        }

        label {
            font-size: 12px;
            font-weight: 700;
            color: #40516b;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #dce3ed;
            border-radius: 9px;
            background: #fff;
            color: var(--text);
            font-family: inherit;
            font-size: 13px;
            outline: none;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #80a5fa;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .field-error {
            color: #b83232;
            font-size: 11px;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-top: 20px;
        }

        .search {
            max-width: 290px;
        }

        .empty {
            padding: 35px 15px;
            text-align: center;
            color: var(--muted);
            font-size: 13px;
        }

        /* ANALYTICS */

        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .bar-row {
            margin: 17px 0;
        }

        .bar-label {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 700;
        }

        .bar-track {
            height: 9px;
            background: #edf1f7;
            border-radius: 20px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            border-radius: 20px;
            background: linear-gradient(90deg, #2563eb, #38bdf8);
        }

        /* SETTINGS */

        .setting-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 16px 0;
            border-bottom: 1px solid var(--line);
        }

        .setting-row:last-child {
            border-bottom: 0;
        }

        .setting-row strong {
            display: block;
            font-size: 13px;
        }

        .setting-row small {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        /* RESPONSIVE */

        @media(max-width: 1100px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .main {
                padding: 28px 24px;
            }
        }

        @media(max-width: 760px) {
            .sidebar {
                width: 72px;
                padding: 20px 9px;
            }

            .brand {
                justify-content: center;
                padding: 5px 0 28px;
                font-size: 0;
            }

            .brand-mark {
                flex: none;
            }

            .nav-label,
            .nav-text,
            .sidebar-bottom {
                display: none;
            }

            .nav-links a {
                justify-content: center;
                padding: 14px 8px;
            }

            .nav-icon {
                font-size: 19px;
            }

            .main {
                margin-left: 72px;
                padding: 22px 14px 35px;
            }

            .topbar {
                align-items: flex-start;
            }

            h1 {
                font-size: 24px;
            }

            .profile {
                padding: 6px;
            }

            .profile-info {
                display: none;
            }

            .stats-grid {
                gap: 10px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-value {
                font-size: 25px;
            }

            .analytics-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .panel {
                padding: 16px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    @php
        $user = auth()->user();

        $userRole = strtolower(trim((string) ($user->role ?? '')));

        $isAdmin = in_array(
            $userRole,
            ['admin', 'administrator'],
            true
        );

        $isTeacher = $userRole === 'teacher';

        $canManageEquipment = $isAdmin || $isTeacher;
    @endphp

    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="brand">
            <span class="brand-mark">E</span>
            <span class="nav-text">EquipTrack</span>
        </div>

        <div class="nav-label">Workspace</div>

        <!-- ROLE-BASED NAVIGATION -->

        <nav class="nav-links">

            <!-- ALL USERS: DASHBOARD -->
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">▦</span>
                <span class="nav-text">Dashboard</span>
            </a>

            <!-- ALL USERS: EQUIPMENT INVENTORY -->
            <a href="{{ route('equipment.index') }}"
               class="{{ request()->routeIs('equipment.index') ? 'active' : '' }}">
                <span class="nav-icon">▤</span>
                <span class="nav-text">Equipment Inventory</span>
            </a>

            <!-- TEACHER AND ADMIN -->
            @if($canManageEquipment)

                <a href="{{ route('equipment.create') }}"
                   class="{{ request()->routeIs('equipment.create') ? 'active' : '' }}">
                    <span class="nav-icon">＋</span>
                    <span class="nav-text">Add Equipment</span>
                </a>

                <a href="{{ route('analytics') }}"
                   class="{{ request()->routeIs('analytics') ? 'active' : '' }}">
                    <span class="nav-icon">▥</span>
                    <span class="nav-text">Analytics</span>
                </a>

            @endif

            <!-- ADMIN ONLY -->
            @if($isAdmin)

                <a href="{{ route('users.index') }}"
                   class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span class="nav-icon">♟</span>
                    <span class="nav-text">User Management</span>
                </a>

                <a href="{{ route('settings') }}"
                   class="{{ request()->routeIs('settings') ? 'active' : '' }}">
                    <span class="nav-icon">⚙</span>
                    <span class="nav-text">Settings</span>
                </a>

            @endif

        </nav>

        <div class="sidebar-bottom">
            EQUIPTRACK<br>
            Equipment Management System<br>
            Version 1.0
        </div>

    </aside>

    <!-- MAIN CONTENT -->

    <main class="main">

        <header class="topbar">

            <div>

                <div class="eyebrow">
                    Equipment management
                </div>

                <h1>
                    @yield('page-title', 'Dashboard')
                </h1>

                <p class="subtitle">
                    @yield(
                        'page-subtitle',
                        'Manage and monitor your equipment in one place.'
                    )
                </p>

            </div>

            <!-- DYNAMIC USER PROFILE -->

            <div class="profile">

                <div class="avatar">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>

                <div class="profile-info">

                    <strong>
                        {{ $user->name ?? 'User' }}
                    </strong>

                    <small>
                        {{ ucfirst($userRole ?: 'user') }} Account
                    </small>

                </div>

                <!-- LOGOUT -->

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit" class="btn btn-danger">
                        Logout
                    </button>

                </form>

            </div>

        </header>

        <!-- SUCCESS MESSAGE -->

        @if(session('success'))

            <div class="flash success">
                {{ session('success') }}
            </div>

        @endif

        <!-- ERROR MESSAGE -->

        @if(session('error'))

            <div class="flash error">
                {{ session('error') }}
            </div>

        @endif

        <!-- PAGE CONTENT -->

        @yield('content')

    </main>

    @stack('scripts')

</body>
</html>

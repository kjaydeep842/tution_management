<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Portal – {{ \App\Models\Setting::get('site_name', 'BrightMind') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            margin: 0;
        }

        .parent-nav {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 12px rgba(99, 102, 241, 0.3);
        }

        .parent-nav .brand {
            color: #fff;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .parent-nav .nav-links {
            display: flex;
            gap: 4px;
        }

        .parent-nav a {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            transition: all .15s;
        }

        .parent-nav a:hover,
        .parent-nav a.active {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .parent-nav .user-badge {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .hamburger {
            display: none;
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            padding: 8px;
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            background: #8b5cf6;
            padding: 16px;
            flex-direction: column;
            gap: 8px;
            z-index: 40;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu a {
            color: #fff;
            text-decoration: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        .mobile-menu a.active {
            background: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 1024px) {
            .parent-nav {
                padding: 0 16px;
            }

            .parent-nav .nav-links {
                display: none;
            }

            .parent-nav .desktop-user {
                display: none !important;
            }

            .hamburger {
                display: block;
            }

            .mobile-menu {
                display: flex;
            }
        }

        .parent-main {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .badge-present {
            background: #d1fae5;
            color: #065f46;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-absent {
            background: #fee2e2;
            color: #991b1b;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-late {
            background: #fef3c7;
            color: #92400e;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            padding: 10px 14px;
            font-size: 12px;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 1px solid #f1f5f9;
            text-align: left;
        }

        td {
            padding: 12px 14px;
            border-bottom: 1px solid #f8fafc;
            font-size: 14px;
            color: #374151;
        }
    </style>
</head>

<body>
    <nav class="parent-nav" x-data="{ open: false }">
        <div class="brand">🎓 {{ \App\Models\Setting::get('site_name', 'BrightMind') }}</div>

        <!-- Desktop Navigation -->
        <div class="nav-links">
            <a href="{{ route('parent.dashboard') }}"
                class="{{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('parent.attendance') }}"
                class="{{ request()->routeIs('parent.attendance') ? 'active' : '' }}">Attendance</a>
            <a href="{{ route('parent.exams') }}"
                class="{{ request()->routeIs('parent.exams') ? 'active' : '' }}">Exams</a>
            <a href="{{ route('parent.fees') }}"
                class="{{ request()->routeIs('parent.fees') ? 'active' : '' }}">Fees</a>
            <a href="{{ route('parent.past-records') }}"
                class="{{ request()->routeIs('parent.past-records') ? 'active' : '' }}">Past Records</a>
            <a href="{{ route('parent.guidance.index') }}"
                class="{{ request()->routeIs('parent.guidance.*') ? 'active' : '' }}">Guidance</a>
            <a href="{{ route('parent.performance') }}"
                class="{{ request()->routeIs('parent.performance') ? 'active' : '' }}">Performance</a>
            <a href="{{ route('parent.profile') }}"
                class="{{ request()->routeIs('parent.profile') ? 'active' : '' }}">Profile</a>
        </div>

        <div class="desktop-user" style="display:flex; align-items:center; gap:12px;">
            <span class="user-badge">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit"
                    style="background:rgba(255,255,255,0.15); border:none; color:#fff; padding:7px 14px; border-radius:8px; font-size:13px; cursor:pointer;">Logout</button>
            </form>
        </div>

        <!-- Hamburger Icon -->
        <button class="hamburger" @click="open = !open">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 28px; height: 28px;">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Mobile Menu -->
        <div class="mobile-menu" x-show="open" x-transition @click.away="open = false" style="display: none;">
            <a href="{{ route('parent.dashboard') }}"
                class="{{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('parent.attendance') }}"
                class="{{ request()->routeIs('parent.attendance') ? 'active' : '' }}">Attendance</a>
            <a href="{{ route('parent.exams') }}"
                class="{{ request()->routeIs('parent.exams') ? 'active' : '' }}">Exams</a>
            <a href="{{ route('parent.fees') }}"
                class="{{ request()->routeIs('parent.fees') ? 'active' : '' }}">Fees</a>
            <a href="{{ route('parent.past-records') }}"
                class="{{ request()->routeIs('parent.past-records') ? 'active' : '' }}">Past Records</a>
            <a href="{{ route('parent.guidance.index') }}"
                class="{{ request()->routeIs('parent.guidance.*') ? 'active' : '' }}">Guidance</a>
            <a href="{{ route('parent.performance') }}"
                class="{{ request()->routeIs('parent.performance') ? 'active' : '' }}">Performance</a>
            <a href="{{ route('parent.profile') }}"
                class="{{ request()->routeIs('parent.profile') ? 'active' : '' }}">Profile</a>

            <div
                style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px; margin-top: 8px; display: flex; align-items: center; justify-content: space-between;">
                <span class="user-badge" style="background:none; padding: 0;">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit"
                        style="background:rgba(255,255,255,0.15); border:none; color:#fff; padding:7px 14px; border-radius:8px; font-size:13px; cursor:pointer;">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="parent-main">
        @if(session('success'))
            <div
                style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:14px; font-weight:500;">
                ✓ {{ session('success') }}
            </div>
        @endif
        {{ $slot ?? '' }}
        @yield('content')
    </main>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ \App\Models\Setting::get('site_name', \App\Models\Setting::get('site_name', config('app.name', 'BrightMind'))) }}
        – Admin Panel
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 9999px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s;
            gap: 10px;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.07);
            color: white;
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35);
        }

        .card {
            background: white;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            padding: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            padding: 28px;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            font-weight: 600;
            border-radius: 12px;
            font-size: 14px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
            gap: 6px;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: white;
            color: #374151;
            font-weight: 600;
            border-radius: 12px;
            font-size: 14px;
            text-decoration: none;
            border: 1.5px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.2s;
            gap: 6px;
        }

        .btn-secondary:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        .input-field {
            width: 100%;
            padding: 11px 16px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }

        .input-field:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            background: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #f8fafc;
            padding: 14px 20px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid #f1f5f9;
        }

        tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid #f9fafb;
            font-size: 14px;
            color: #374151;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-green {
            background: #dcfce7;
            color: #166534;
        }

        .badge-red {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-amber {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-purple {
            background: #ede9fe;
            color: #5b21b6;
        }
    </style>
</head>

<body class="bg-gray-50 antialiased text-gray-900" x-data="{ sidebarOpen: false }">
    <!-- Sidebar Overlay (mobile) -->
    <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:leave="transition ease-in duration-200" class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        style="background:#0f172a; transition:transform 0.3s;">
        <!-- Brand -->
        <div style="padding:24px 20px 16px; border-bottom:1px solid rgba(255,255,255,0.07);">
            <div style="display:flex; align-items:center; gap:10px;">
                <div
                    style="width:36px; height:36px; background:{{ \App\Models\Setting::get('site_logo') ? 'transparent' : 'linear-gradient(135deg,#6366f1,#8b5cf6)' }}; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden;">
                    @if($logo = \App\Models\Setting::get('site_logo'))
                        <img src="{{ asset('storage/' . $logo) }}" class="w-full h-full object-cover">
                    @else
                        <svg width="18" height="18" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        </svg>
                    @endif
                </div>
                <div>
                    <div style="color:white; font-weight:800; font-size:15px;">
                        {{ \App\Models\Setting::get('site_name', 'BrightMind') }}
                    </div>
                    <div style="color:#64748b; font-size:11px; font-weight:500;">Admin Panel</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav style="flex:1; padding:12px 12px; overflow-y:auto;">
            <div
                style="font-size:10px; font-weight:700; color:#475569; letter-spacing:2px; text-transform:uppercase; padding:8px 14px 12px;">
                MAIN MENU</div>
            <a href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.settings.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Settings
            </a>
            <a href="{{ route('inquiries.index') }}"
                class="sidebar-link {{ request()->routeIs('inquiries.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                Inquiries
            </a>
            <a href="{{ route('students.index') }}"
                class="sidebar-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
                </svg>
                Students
            </a>
            <a href="{{ route('admin.parents.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.parents.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Parents
            </a>
            <a href="{{ route('tuition-classes.index') }}"
                class="sidebar-link {{ request()->routeIs('tuition-classes.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Batches / Classes
            </a>
            <a href="{{ route('teachers.index') }}"
                class="sidebar-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Teachers
            </a>
            <a href="{{ route('branches.index') }}"
                class="sidebar-link {{ request()->routeIs('branches.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Branches
            </a>

            <div
                style="font-size:10px; font-weight:700; color:#475569; letter-spacing:2px; text-transform:uppercase; padding:16px 14px 8px;">
                FINANCE</div>
            <a href="{{ route('fees.index') }}" class="sidebar-link {{ request()->routeIs('fees.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Fees
            </a>
            <a href="{{ route('payments.index') }}"
                class="sidebar-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                Payments
            </a>

            <div
                style="font-size:10px; font-weight:700; color:#475569; letter-spacing:2px; text-transform:uppercase; padding:16px 14px 8px;">
                ACADEMIC</div>
            <a href="{{ route('attendance.index') }}"
                class="sidebar-link {{ request()->routeIs('attendance.index') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Attendance
            </a>
            <a href="{{ route('attendance.report') }}"
                class="sidebar-link {{ request()->routeIs('attendance.report') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Attendance Report
            </a>
            <a href="{{ route('assignments.index') }}"
                class="sidebar-link {{ request()->routeIs('assignments.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Assignments
            </a>
            <a href="{{ route('exams.index') }}"
                class="sidebar-link {{ request()->routeIs('exams.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                </svg>
                Exams & Marks
            </a>
            <a href="{{ route('performance-reports.index') }}"
                class="sidebar-link {{ request()->routeIs('performance-reports.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Performance Reports
            </a>
            <a href="{{ route('admin.guidance.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.guidance.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                Guidance Requests
            </a>
        </nav>

        <!-- Logout -->
        <div style="padding:16px 12px; border-top:1px solid rgba(255,255,255,0.07);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link"
                    style="width:100%; border:none; cursor:pointer; background:transparent;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="lg:pl-64 min-h-screen flex flex-col transition-all duration-300">
        <!-- Topbar -->
        <header class="bg-white border-b border-f1f5f9 sticky top-0 z-30 transition-all duration-300">
            <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
                <!-- Mobile & Desktop Left Section -->
                <div class="flex items-center gap-4">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Page Breadcrumb (Hidden on extra small screens) -->
                    <div class="hidden xs:flex items-center text-sm text-gray-500 truncate max-w-[150px] sm:max-w-none">
                        <span class="truncate">{{ \App\Models\Setting::get('site_name', 'BrightMind') }}</span>
                        <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span
                            class="font-semibold text-gray-900 truncate">{{ ucfirst(request()->segment(1) ?? 'Dashboard') }}</span>
                    </div>
                </div>

                <!-- Right Section: User Info -->
                <div class="flex items-center gap-2 sm:gap-4">
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-xs text-gray-400 uppercase tracking-wider font-bold">Admin</span>
                        <span class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="relative group">
                        <div
                            class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-indigo-100 ring-2 ring-white">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 bg-slate-50/50">
            @if(session('success'))
                <div
                    class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-start gap-3 text-sm sm:text-base animate-in fade-in slide-in-from-top-4 duration-300">
                    <div class="flex-shrink-0 bg-green-100 p-1 rounded-full">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Success!</p>
                        <p class="text-green-600/90">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div
                    class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-start gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                    <span class="flex-shrink-0 text-xl">⚠️</span>
                    <div>
                        <p class="font-semibold">Error Occurred</p>
                        <p class="text-red-600/90">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="max-w-7xl mx-auto">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
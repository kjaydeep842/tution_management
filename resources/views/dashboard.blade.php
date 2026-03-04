<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
        <p class="text-gray-500">Welcome back! Here's what's happening today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8 sm:mb-10">
        <!-- Students -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">+12%</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Total Students</h3>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_students'] }}</p>
        </div>

        <!-- Inquiries -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Pending</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">New Inquiries</h3>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_inquiries'] }}</p>
        </div>

        <!-- Classes -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Active Classes</h3>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_classes'] }}</p>
        </div>

        <!-- Pending Fees -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Outstanding Fees</h3>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">₹{{ number_format($stats['pending_fees'], 2) }}
            </p>
        </div>
    </div>

    <!-- Second Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        <!-- Recent Inquiries -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6 text-left">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Recent Inquiries</h2>
            @forelse($recentInquiries as $inquiry)
                <div
                    class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-xl transition-colors border-b last:border-0 border-gray-50">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-indigo-100 text-indigo-700 flex items-center justify-center rounded-full font-bold text-sm">
                            {{ substr($inquiry->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $inquiry->name }}</p>
                            <p class="text-xs text-gray-500">{{ $inquiry->contact }}</p>
                        </div>
                    </div>
                    <a href="{{ route('inquiries.index') }}"
                        class="text-xs font-semibold text-indigo-600 hover:text-indigo-900">View</a>
                </div>
            @empty
                <div class="py-10 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 italic">No new inquiries at the moment.</p>
                </div>
            @endforelse
        </div>

        <!-- Attendance Snapshot -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6 text-left">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Today's Attendance Snapshot</h2>
            @if($todayAttendanceCount > 0)
                <div class="flex flex-col items-center justify-center py-6">
                    <div class="relative w-32 h-32 mb-4">
                        <svg class="w-full h-full" viewBox="0 0 36 36">
                            <path class="text-gray-100" stroke-width="3" fill="none" stroke="currentColor"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-indigo-500" stroke-width="3"
                                stroke-dasharray="{{ ($todayAttendanceCount / max($stats['total_students'], 1)) * 100 }}, 100"
                                stroke-linecap="round" fill="none" stroke="currentColor"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-bold text-gray-900">{{ $todayAttendanceCount }}</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Present</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 font-medium">Out of {{ $stats['total_students'] }} total students
                        enrolled.</p>
                </div>
            @else
                <div class="py-10 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 italic">Attendance marking for today has not started.</p>
                    <a href="{{ route('attendance.index') }}"
                        class="mt-4 inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-900">
                        Mark Attendance Now →
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
        <p class="text-gray-500">Welcome back! Here's what's happening today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Students -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
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
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_students'] }}</p>
        </div>

        <!-- Inquiries -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
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
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_inquiries'] }}</p>
        </div>

        <!-- Classes -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
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
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_classes'] }}</p>
        </div>

        <!-- Pending Fees -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
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
            <p class="text-3xl font-bold text-gray-900 mt-1">₹{{ number_format($stats['pending_fees'], 2) }}</p>
        </div>
    </div>

    <!-- Quick Actions or Trend Charts can be added here -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Recent Inquiries</h2>
            <p class="text-sm text-gray-500 italic">No new inquiries at the moment.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Today's Attendance Snapshot</h2>
            <p class="text-sm text-gray-500 italic">Attendance marking for today has not started.</p>
        </div>
    </div>
</x-admin-layout>
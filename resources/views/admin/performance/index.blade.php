<x-admin-layout>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Student Performance Reports</h1>
            <p class="text-gray-500">Generate and manage performance reports for students.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">Roll No</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">Student Name</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">Class</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($students as $student)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $student->roll_no ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $student->full_name }}</div>
                            <div class="text-xs text-gray-500">{{ $student->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $student->tuitionClass->name }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('performance-reports.create', $student) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg font-semibold hover:bg-indigo-100 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Analyze & Send
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
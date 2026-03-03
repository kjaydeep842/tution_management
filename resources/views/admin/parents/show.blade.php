<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Parent Details</h1>
            <p class="text-gray-500">Detailed information about the parent account and linked students.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('admin.parents.edit', $parent) }}" class="btn-primary inline-flex justify-center">Edit Parent</a>
            <a href="{{ route('admin.parents.index') }}" class="btn-secondary inline-flex justify-center">← Back</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr,1.5fr] gap-6">
        {{-- Parent Account Card --}}
        <div class="card h-fit">
            <div class="flex items-center gap-4 mb-6 pb-5 border-b border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-extrabold flex-shrink-0">
                    {{ substr($parent->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-gray-900 leading-tight">{{ $parent->name }}</h2>
                    <span class="badge badge-purple mt-1">Parent Account</span>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Email Address</p>
                    <p class="text-[15px] text-gray-700 font-medium break-all">{{ $parent->email }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Phone Number</p>
                    <p class="text-[15px] text-gray-700 font-medium">{{ $parent->phone ?? 'Not provided' }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Account Created</p>
                    <p class="text-[15px] text-gray-700 font-medium">
                        {{ $parent->created_at->format('d M, Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Associated Students Card --}}
        <div class="card">
            <h3 class="text-base font-bold text-gray-700 mb-5">Associated Students
                ({{ $parent->students->count() }})</h3>

            @if($parent->students->count() > 0)
                <div class="overflow-x-auto border border-gray-100 rounded-xl">
                    <table class="w-full min-w-[500px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Student</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Class/Batch
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Roll No</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($parent->students as $student)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $student->full_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $student->email ?? 'No email' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $student->tuitionClass->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 font-mono">
                                        {{ $student->roll_no ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('students.show', $student) }}"
                                            class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Profile</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-10 px-5 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-gray-500 text-sm">No students are currently linked to this parent account.</p>
                    <a href="{{ route('admin.parents.edit', $parent) }}"
                        class="inline-block mt-4 text-indigo-600 font-semibold hover:underline">Link Students Now</a>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
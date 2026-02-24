<x-admin-layout>
    <div style="margin-bottom:28px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Parent Details</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">Detailed information about the parent account and linked
                students.</p>
        </div>
        <div style="display:flex; gap:12px;">
            <a href="{{ route('admin.parents.edit', $parent) }}" class="btn-primary">Edit Parent</a>
            <a href="{{ route('admin.parents.index') }}" class="btn-secondary">← Back</a>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1.5fr; gap:24px;">
        {{-- Parent Account Card --}}
        <div class="card">
            <div
                style="display:flex; align-items:center; gap:16px; margin-bottom:24px; padding-bottom:20px; border-bottom:1px solid #f1f5f9;">
                <div
                    style="width:64px; height:64px; background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:24px; font-weight:800;">
                    {{ substr($parent->name, 0, 1) }}
                </div>
                <div>
                    <h2 style="font-size:20px; font-weight:800; color:#0f172a; margin:0;">{{ $parent->name }}</h2>
                    <span class="badge badge-purple" style="margin-top:4px;">Parent Account</span>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:16px;">
                <div>
                    <p
                        style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">
                        Email Address</p>
                    <p style="font-size:15px; color:#374151; font-weight:500;">{{ $parent->email }}</p>
                </div>
                <div>
                    <p
                        style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">
                        Phone Number</p>
                    <p style="font-size:15px; color:#374151; font-weight:500;">{{ $parent->phone ?? 'Not provided' }}
                    </p>
                </div>
                <div>
                    <p
                        style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">
                        Account Created</p>
                    <p style="font-size:15px; color:#374151; font-weight:500;">
                        {{ $parent->created_at->format('d M, Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Associated Students Card --}}
        <div class="card">
            <h3 style="font-size:16px; font-weight:700; color:#374151; margin:0 0 20px;">Associated Students
                ({{ $parent->students->count() }})</h3>

            @if($parent->students->count() > 0)
                <div class="overflow-hidden border border-gray-100 rounded-xl">
                    <table class="w-full">
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
                <div
                    style="padding:40px 20px; text-align:center; background:#f8fafc; border-radius:14px; border:1px dashed #cbd5e1;">
                    <svg width="32" height="32" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"
                        style="margin:0 auto 12px;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p style="color:#64748b; font-size:14px;">No students are currently linked to this parent account.</p>
                    <a href="{{ route('admin.parents.edit', $parent) }}"
                        class="inline-block mt-4 text-indigo-600 font-semibold hover:underline">Link Students Now</a>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Batches / Classes</h1>
            <p class="text-gray-500">All tuition batches across branches</p>
        </div>
        <a href="{{ route('tuition-classes.create') }}" class="btn-primary inline-flex justify-center">+ Create
            Batch</a>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[1000px]">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Batch Name</th>
                        <th>Subject</th>
                        <th>Branch</th>
                        <th>Teacher</th>
                        <th>Students</th>
                        <th>Schedule</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                        <tr>
                            <td style="color:#94a3b8; font-size:13px;">{{ $classes->firstItem() + $loop->index }}</td>
                            <td>
                                <div style="font-weight:700; color:#0f172a;">{{ $class->name }}</div>
                            </td>
                            <td class="max-w-[300px]">
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach(explode(', ', $class->subject) as $subj)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase tracking-tighter shadow-sm whitespace-nowrap">
                                            {{ $subj }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                @if($class->branch)
                                    <span class="badge badge-purple">{{ $class->branch->name }}</span>
                                @else
                                    <span style="color:#94a3b8; font-size:13px;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($class->teacher)
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <div
                                            style="width:30px; height:30px; border-radius:50%; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; font-weight:700; font-size:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                            {{ substr($class->teacher->name, 0, 1) }}
                                        </div>
                                        <span style="font-size:14px; color:#374151;">{{ $class->teacher->name }}</span>
                                    </div>
                                @else
                                    <span style="color:#94a3b8; font-size:13px;">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-green">{{ $class->students_count ?? $class->students->count() }}
                                    students</span>
                            </td>
                            <td style="color:#64748b; font-size:13px; max-width:180px;">{{ $class->schedule_info ?? '—' }}
                            </td>
                            <td>
                                <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                                    <a href="{{ route('tuition-classes.edit', $class) }}"
                                        class="btn-secondary whitespace-nowrap"
                                        style="padding:6px 14px; font-size:13px;">Edit</a>
                                    <form action="{{ route('tuition-classes.destroy', $class) }}" method="POST"
                                        onsubmit="return confirm('Delete this batch?')" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="whitespace-nowrap"
                                            style="padding:6px 14px; font-size:13px; background:#fff1f2; color:#e11d48; border:1.5px solid #fecdd3; border-radius:10px; cursor:pointer; font-weight:600;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:48px; color:#94a3b8;">
                                No batches yet. <a href="{{ route('tuition-classes.create') }}"
                                    style="color:#6366f1;">Create
                                    one →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($classes->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $classes->links() }}</div>
        @endif
    </div>
</x-admin-layout>
<x-admin-layout>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Batches / Classes</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">All tuition batches across branches</p>
        </div>
        <a href="{{ route('tuition-classes.create') }}" class="btn-primary">+ Create Batch</a>
    </div>

    <div class="card" style="padding:0; overflow:hidden;">
        <table>
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
                        <td>
                            <span class="badge badge-blue">{{ $class->subject }}</span>
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
                                        {{ substr($class->teacher->name, 0, 1) }}</div>
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
                        <td style="color:#64748b; font-size:13px; max-width:180px;">{{ $class->schedule_info ?? '—' }}</td>
                        <td>
                            <div style="display:flex; gap:8px; align-items:center;">
                                <a href="{{ route('tuition-classes.edit', $class) }}" class="btn-secondary"
                                    style="padding:6px 14px; font-size:13px;">Edit</a>
                                <form action="{{ route('tuition-classes.destroy', $class) }}" method="POST"
                                    onsubmit="return confirm('Delete this batch?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        style="padding:6px 14px; font-size:13px; background:#fff1f2; color:#e11d48; border:1.5px solid #fecdd3; border-radius:10px; cursor:pointer; font-weight:600;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:48px; color:#94a3b8;">
                            No batches yet. <a href="{{ route('tuition-classes.create') }}" style="color:#6366f1;">Create
                                one →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($classes->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #f1f5f9;">{{ $classes->links() }}</div>
        @endif
    </div>
</x-admin-layout>
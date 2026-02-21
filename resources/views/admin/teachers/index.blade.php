<x-admin-layout>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Teachers</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">Manage all teaching staff</p>
        </div>
        <a href="{{ route('teachers.create') }}" class="btn-primary">+ Add Teacher</a>
    </div>

    <div class="card" style="padding:0; overflow:hidden;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Specialisation</th>
                    <th>Branch</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td style="color:#94a3b8; font-size:13px;">{{ $teachers->firstItem() + $loop->index }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div
                                    style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; font-weight:700; font-size:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    {{ substr($teacher->name, 0, 1) }}</div>
                                <span style="font-weight:600; color:#0f172a;">{{ $teacher->name }}</span>
                            </div>
                        </td>
                        <td style="color:#64748b; font-size:13px;">{{ $teacher->phone ?? '—' }}</td>
                        <td style="color:#64748b; font-size:13px;">{{ $teacher->email ?? '—' }}</td>
                        <td>
                            @if($teacher->subject_specialisation)
                                <span class="badge badge-blue">{{ $teacher->subject_specialisation }}</span>
                            @else
                                <span style="color:#94a3b8; font-size:13px;">—</span>
                            @endif
                        </td>
                        <td>
                            @if($teacher->branch)
                                <span class="badge badge-purple">{{ $teacher->branch->name }}</span>
                            @else
                                <span style="color:#94a3b8; font-size:13px;">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $teacher->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:8px; align-items:center;">
                                <a href="{{ route('teachers.edit', $teacher) }}" class="btn-secondary"
                                    style="padding:6px 14px; font-size:13px;">Edit</a>
                                <form action="{{ route('teachers.destroy', $teacher) }}" method="POST"
                                    onsubmit="return confirm('Remove this teacher?')">
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
                            No teachers added yet. <a href="{{ route('teachers.create') }}" style="color:#6366f1;">Add one
                                →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($teachers->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #f1f5f9;">{{ $teachers->links() }}</div>
        @endif
    </div>
</x-admin-layout>
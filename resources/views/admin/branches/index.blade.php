<x-admin-layout>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Branches</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">Manage tuition centre locations</p>
        </div>
        <a href="{{ route('branches.create') }}" class="btn-primary">+ Add Branch</a>
    </div>

    <div class="card" style="padding:0; overflow:hidden;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Teachers</th>
                    <th>Batches</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($branches as $branch)
                    <tr>
                        <td style="color:#94a3b8; font-size:13px;">{{ $loop->iteration }}</td>
                        <td>
                            <div style="font-weight:700; color:#0f172a;">{{ $branch->name }}</div>
                        </td>
                        <td style="color:#64748b; font-size:13px;">{{ $branch->address ?? '—' }}</td>
                        <td style="color:#64748b; font-size:13px;">{{ $branch->phone ?? '—' }}</td>
                        <td>
                            <span class="badge badge-blue">{{ $branch->teachers_count }} Teachers</span>
                        </td>
                        <td>
                            <span class="badge badge-purple">{{ $branch->tuition_classes_count }} Batches</span>
                        </td>
                        <td>
                            @if($branch->is_active)
                                <span class="badge badge-green">Active</span>
                            @else
                                <span class="badge badge-red">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:8px; align-items:center;">
                                <a href="{{ route('branches.edit', $branch) }}" class="btn-secondary"
                                    style="padding:6px 14px; font-size:13px;">Edit</a>
                                <form action="{{ route('branches.destroy', $branch) }}" method="POST"
                                    onsubmit="return confirm('Delete this branch?')">
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
                            No branches yet. <a href="{{ route('branches.create') }}" style="color:#6366f1;">Add one →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Branches</h1>
            <p class="text-gray-500">Manage tuition centre locations</p>
        </div>
        <a href="{{ route('branches.create') }}" class="btn-primary inline-flex justify-center">+ Add Branch</a>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
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
                            <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                                <a href="{{ route('branches.edit', $branch) }}" class="btn-secondary whitespace-nowrap"
                                    style="padding:6px 14px; font-size:13px;">Edit</a>
                                <form action="{{ route('branches.destroy', $branch) }}" method="POST"
                                    onsubmit="return confirm('Delete this branch?')" class="m-0">
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
                            No branches yet. <a href="{{ route('branches.create') }}" style="color:#6366f1;">Add one →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-admin-layout>
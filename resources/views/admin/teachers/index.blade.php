<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Teachers</h1>
            <p class="text-gray-500">Manage all teaching staff</p>
        </div>
        <a href="{{ route('teachers.create') }}" class="btn-primary w-full sm:w-auto justify-center">+ Add Teacher</a>
    </div>

    <div class="card p-0 overflow-hidden shadow-sm border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-[1000px]">
                <thead>
                    <tr>
                        <th class="w-16">#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Specialisation</th>
                        <th>Branch</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="text-gray-400 font-mono text-xs">{{ $teachers->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-bold text-sm flex items-center justify-center flex-shrink-0 shadow-sm">
                                        {{ substr($teacher->name, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $teacher->name }}</span>
                                </div>
                            </td>
                            <td class="text-gray-600 text-sm">{{ $teacher->phone ?? '—' }}</td>
                            <td class="text-gray-600 text-sm">{{ $teacher->email ?? '—' }}</td>
                            <td>
                                @if($teacher->subject_specialisation)
                                    <span class="badge badge-blue">{{ $teacher->subject_specialisation }}</span>
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                            <td>
                                @if($teacher->branch)
                                    <span class="badge badge-purple">{{ $teacher->branch->name }}</span>
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $teacher->is_active ? 'badge-green' : 'badge-red' }}">
                                    {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('teachers.edit', $teacher) }}" class="btn-secondary px-3 py-1.5 text-xs">Edit</a>
                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Remove this teacher?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs bg-red-50 text-red-600 border border-red-100 rounded-lg hover:bg-red-100 transition-colors font-semibold">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12">
                                <div class="flex flex-col items-center gap-2">
                                    <p class="text-gray-400 italic">No teachers added yet.</p>
                                    <a href="{{ route('teachers.create') }}" class="text-indigo-600 font-medium hover:underline">Add one →</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($teachers->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #f1f5f9;">{{ $teachers->links() }}</div>
        @endif
    </div>
</x-admin-layout>
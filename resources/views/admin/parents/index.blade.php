<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Parent Management</h1>
            <p class="text-gray-500">Manage parent accounts and their student associations.</p>
        </div>
        <a href="{{ route('admin.parents.create') }}"
            class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-100">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Add New Parent
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Parent</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Associated
                            Students</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($parents as $parent)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-indigo-100 text-indigo-700 flex items-center justify-center rounded-full font-bold text-sm">
                                    {{ substr($parent->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $parent->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $parent->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $parent->phone ?? 'No phone' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if($parent->students->count() > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($parent->students as $student)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $student->full_name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 italic">No students linked</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.parents.show', $parent) }}"
                                class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View</a>
                            <a href="{{ route('admin.parents.edit', $parent) }}"
                                class="text-amber-600 hover:text-amber-900 text-sm font-medium ml-3">Edit</a>
                            <form action="{{ route('admin.parents.destroy', $parent) }}" method="POST" class="inline ml-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this parent account? Students will be unlinked but not deleted.')"
                                    class="text-rose-600 hover:text-rose-900 text-sm font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">No parents found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        {{ $parents->links() }}
    </div>
</div>
</x-admin-layout>
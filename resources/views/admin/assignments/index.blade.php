<x-admin-layout>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Assignments</h1>
            <p class="text-gray-500">Manage assignments and student submissions.</p>
        </div>
        <a href="{{ route('assignments.create') }}"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-100">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            New Assignment
        </a>
    </div>

    <div class="space-y-4">
        @forelse($assignments as $assignment)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div class="flex items-start space-x-5">
                    <div
                        class="w-12 h-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-xl">
                        📝</div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">{{ $assignment->title }}</h3>
                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                            <span>Class: {{ $assignment->tuitionClass->name }}</span>
                            <span>Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y') }}</span>
                            <span>Submissions: {{ $assignment->submissions->count() }}</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('assignments.show', $assignment) }}"
                    class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">View →</a>
            </div>
        @empty
            <div
                class="py-20 bg-white rounded-2xl border border-dashed border-gray-300 flex flex-col items-center justify-center">
                <p class="text-gray-500 italic">No assignments created yet.</p>
                <a href="{{ route('assignments.create') }}" class="mt-4 text-indigo-600 font-bold hover:underline">Create
                    your first assignment</a>
            </div>
        @endforelse
    </div>
    <div class="mt-6">{{ $assignments->links() }}</div>
</x-admin-layout>
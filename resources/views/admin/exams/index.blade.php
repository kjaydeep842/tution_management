<x-admin-layout>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Exams & Results</h1>
            <p class="text-gray-500">Schedule exams and record student marks.</p>
        </div>
        <a href="{{ route('exams.create') }}"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-100">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Schedule Exam
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Exam</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Class</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Marks</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($exams as $exam)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $exam->name }}</div>
                            <div class="text-xs text-gray-500">{{ $exam->subject }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $exam->tuitionClass->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($exam->exam_date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm font-mono font-bold text-gray-900">{{ $exam->total_marks }}</td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('exams.marks', $exam) }}"
                                class="text-xs px-3 py-1.5 bg-green-50 text-green-700 font-bold rounded-lg hover:bg-green-100 transition-colors">Enter
                                Marks</a>
                            <a href="{{ route('exams.show', $exam) }}"
                                class="text-xs px-3 py-1.5 bg-indigo-50 text-indigo-700 font-bold rounded-lg hover:bg-indigo-100 transition-colors">Results</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No exams scheduled.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">{{ $exams->links() }}</div>
    </div>
</x-admin-layout>
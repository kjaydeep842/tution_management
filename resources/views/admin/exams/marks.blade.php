<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Enter Marks – {{ $exam->name }}</h1>
        <p class="text-gray-500">Class: <strong>{{ $exam->tuitionClass->name }}</strong> | Subject:
            <strong>{{ $exam->subject }}</strong> | Total: <strong>{{ $exam->total_marks }}</strong> marks</p>
    </div>

    <form action="{{ route('exams.store-marks', $exam) }}" method="POST">
        @csrf
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Roll No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Marks
                            Obtained (/ {{ $exam->total_marks }})</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Remarks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($students as $student)
                        @php $existingMark = $marks->firstWhere('student_id', $student->id); @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-9 h-9 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center font-bold text-sm">
                                        {{ substr($student->first_name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $student->full_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-mono text-gray-500">{{ $student->roll_no ?? '–' }}</td>
                            <td class="px-6 py-4">
                                <input type="number" name="marks[{{ $student->id }}][marks_obtained]"
                                    value="{{ $existingMark->marks_obtained ?? '' }}" min="0" max="{{ $exam->total_marks }}"
                                    placeholder="–"
                                    class="w-28 px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-sm outline-none focus:ring-2 focus:ring-indigo-400">
                            </td>
                            <td class="px-6 py-4">
                                <input type="text" name="marks[{{ $student->id }}][remarks]"
                                    value="{{ $existingMark->remarks ?? '' }}" placeholder="Optional remark"
                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-sm outline-none focus:ring-2 focus:ring-indigo-400">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-end space-x-4">
            <a href="{{ route('exams.index') }}"
                class="px-6 py-2.5 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition-colors">Back</a>
            <button type="submit"
                class="px-10 py-2.5 bg-green-600 text-white font-bold rounded-xl shadow-lg hover:bg-green-700 transition-all">Save
                Marks</button>
        </div>
    </form>
</x-admin-layout>
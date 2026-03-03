@extends('layouts.parent')
@section('content')
    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-900">Exam Marks: {{ $student->full_name }}</h3>
                <p class="text-gray-500 text-sm">View all exam results and performance history.</p>
            </div>

            @if($examMarks->isEmpty())
                <div class="bg-white p-12 rounded-2xl shadow-sm border border-gray-100 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-50 text-gray-400 rounded-full mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800">No marks recorded yet</h4>
                    <p class="text-gray-500">Exam results will appear here once the teacher records them.</p>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
                    <table class="w-full text-left" style="min-width: 600px;">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Exam &
                                    Subject</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Time
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                    Marks Obtained</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Result</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($examMarks as $mark)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $mark->exam->name }}</div>
                                        <div class="text-xs text-indigo-600 font-medium">{{ $mark->exam->subject }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700">
                                            {{ \Carbon\Carbon::parse($mark->exam->exam_date)->format('d M Y') }}</div>
                                        @if($mark->exam->start_time)
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($mark->exam->start_time)->format('h:i A') }}
                                                @if($mark->exam->end_time) -
                                                {{ \Carbon\Carbon::parse($mark->exam->end_time)->format('h:i A') }} @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span
                                                class="text-lg font-black {{ ($mark->marks_obtained / $mark->exam->total_marks) * 100 < 35 ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $mark->marks_obtained }}
                                            </span>
                                            <span class="text-[10px] text-gray-400 font-bold">OUT OF
                                                {{ $mark->exam->total_marks }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php 
                                                                                $percentage = ($mark->marks_obtained / $mark->exam->total_marks) * 100;
                                            $isPass = $percentage >= ($mark->exam->passing_marks ?? 35);
                                        @endphp
                                             @if($isPass)
                                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">PASSED</span>
                                            @else
                                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">FAILED</span>
                                        @endif
                                        @if($mark->remarks)
                                            <p class="text-[10px] text-gray-500 mt-1 italic">{{ $mark->remarks }}</p>
                                        @endif
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
            @endif
            </div>
        </div>
@endsection

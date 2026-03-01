@extends('layouts.parent')
@section('content')
    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-900">Performance Reports for {{ $student->full_name }}</h3>
                <p class="text-gray-500 text-sm">Download your child's academic analysis and teacher recommendations.</p>
            </div>

            @if($reports->isEmpty())
                <div class="bg-white p-12 rounded-2xl shadow-sm border border-gray-100 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-50 text-gray-400 rounded-full mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800">No reports generated yet</h4>
                    <p class="text-gray-500">The teacher hasn't shared any performance analysis reports yet.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($reports as $report)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">{{ $report->report_date->format('F Y') }}</span>
                                        <h4 class="text-lg font-bold text-gray-900 mt-1">Monthly Report</h4>
                                    </div>
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full">
                                        {{ $report->overall_performance }}
                                    </span>
                                </div>

                                <div class="space-y-3 mb-6">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Report Date</span>
                                        <span class="text-gray-900 font-medium">{{ $report->report_date->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Teacher</span>
                                        <span class="text-gray-900 font-medium">{{ $report->teacher->name }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-2 text-xs mb-6">
                                    <span class="text-gray-400">Analysis:</span>
                                    @if($report->weak_subjects)
                                        <span class="text-red-500 font-medium">{{ count($report->weak_subjects) }} Improvement areas</span>
                                    @else
                                        <span class="text-green-500 font-medium">All subjects stable</span>
                                    @endif
                                </div>

                                <a href="{{ route('parent.performance.download', $report) }}" 
                                   class="block w-full text-center py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download PDF
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
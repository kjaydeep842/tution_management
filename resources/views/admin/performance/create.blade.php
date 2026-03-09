<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Performance Analysis: {{ $student->full_name }}</h1>
        <p class="text-gray-500">Review system analysis and send final report to parents.</p>
    </div>

    <form action="{{ route('performance-reports.store', $student) }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Analysis Section -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        System Performance Analysis
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="p-4 bg-green-50 rounded-xl border border-green-100">
                            <span class="text-xs font-bold text-green-600 uppercase tracking-wider">Strong
                                Subjects</span>
                            <div class="mt-2 space-y-1">
                                @forelse($strong_subjects as $subject)
                                    <div class="flex items-center text-sm text-green-800">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $subject }}
                                    </div>
                                    <input type="hidden" name="strong_subjects[]" value="{{ $subject }}">
                                @empty
                                    <span class="text-sm text-gray-500 italic">No strong subjects identified yet</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="p-4 bg-red-50 rounded-xl border border-red-100">
                            <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Weak Subjects</span>
                            <div class="mt-2 space-y-1">
                                @forelse($weak_subjects as $subject)
                                    <div class="flex items-center text-sm text-red-800">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $subject }}
                                    </div>
                                    <input type="hidden" name="weak_subjects[]" value="{{ $subject }}">
                                @empty
                                    <span class="text-sm text-gray-500 italic">No critical weak subjects identified</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Subject-wise Average Marks (%)</h3>
                    <div class="space-y-4">
                        @foreach($marks_data as $subject => $percentage)
                            <div>
                                <div class="flex justify-between text-xs font-medium text-gray-600 mb-1">
                                    <span>{{ $subject }}</span>
                                    <span>{{ round($percentage) }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ $percentage < 45 ? 'bg-red-500' : ($percentage > 75 ? 'bg-green-500' : 'bg-indigo-500') }}"
                                        style="width: {{ $percentage }}%"></div>
                                </div>
                                <input type="hidden" name="marks_data[{{ $subject }}]" value="{{ $percentage }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Teacher Suggestions (Managing Weak
                        Subjects)</label>
                    <textarea name="suggestions" rows="6"
                        placeholder="Write constructive feedback and how to improve weak subjects..."
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">{{ old('suggestions') }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">Provide specific steps for improvement.</p>
                </div>
            </div>

            <!-- Report Details Sidebar -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Report Settings</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Report Date</label>
                            <input type="date" name="report_date" value="{{ date('Y-m-d') }}" required
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Overall Performance</label>
                            <select name="overall_performance" required
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:ring-2 focus:ring-indigo-500">
                                <option value="Excellent">Excellent</option>
                                <option value="Very Good">Very Good</option>
                                <option value="Good" selected>Good</option>
                                <option value="Needs Improvement">Needs Improvement</option>
                                <option value="Below Average">Below Average</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col space-y-3">
                    <button type="submit"
                        class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg hover:bg-indigo-700 transition-all flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Send to Parent
                    </button>
                    <a href="{{ route('performance-reports.index') }}"
                        class="w-full py-4 bg-white text-gray-700 font-bold rounded-2xl border border-gray-200 hover:bg-gray-50 transition-all text-center">
                        Discard
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-admin-layout>
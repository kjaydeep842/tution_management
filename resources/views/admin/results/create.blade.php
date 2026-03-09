<x-admin-layout>
    <div style="margin-bottom:28px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0 0 4px;">Add Student Result</h1>
            <p style="color:#64748b; font-size:14px; margin:0;">Success story to be displayed on landing page.</p>
        </div>
        <a href="{{ route('results.index') }}" class="btn-secondary">← Back</a>
    </div>

    <form action="{{ route('results.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="card">
                <h2
                    style="font-size:15px; font-weight:700; color:#374151; margin:0 0 20px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    Student Information</h2>
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Student Name *</label>
                        <input type="text" name="student_name" class="input-field" required
                            value="{{ old('student_name') }}" placeholder="e.g. Rahul Sharma">
                        @error('student_name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Exam Name *</label>
                        <input type="text" name="exam_name" class="input-field" required value="{{ old('exam_name') }}"
                            placeholder="e.g. SSC Board 2024">
                        @error('exam_name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Score / Percentage *</label>
                        <input type="text" name="marks_percentage" class="input-field" required
                            value="{{ old('marks_percentage') }}" placeholder="e.g. 96.5%">
                        @error('marks_percentage') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Achievement (Optional)</label>
                        <input type="text" name="achievement" class="input-field" value="{{ old('achievement') }}"
                            placeholder="e.g. 1st Rank in Science">
                        @error('achievement') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <h2
                    style="font-size:15px; font-weight:700; color:#374151; margin:0 0 20px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
                    Media & Visibility</h2>
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Student Photo</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        @error('image') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer mt-4">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <span class="text-sm font-medium text-gray-700">Display on landing page</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary">Save Result Story</button>
            <a href="{{ route('results.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</x-admin-layout>
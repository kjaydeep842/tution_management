<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Schedule Exam</h1>
        <p class="text-gray-500">Create a new exam and set details.</p>
    </div>

    <form action="{{ route('exams.store') }}" method="POST" class="max-w-xl">
        @csrf
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Exam Name *</label>
                <input type="text" name="name" required value="{{ old('name') }}"
                    placeholder="e.g. Unit Test 1 – Chapter 3"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subject *</label>
                    <input type="text" name="subject" required value="{{ old('subject') }}"
                        placeholder="e.g. Mathematics"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Class *</label>
                    <select name="tuition_class_id" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('tuition_class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Exam Date *</label>
                    <input type="date" name="exam_date" required value="{{ old('exam_date') }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Total Marks *</label>
                    <input type="number" name="total_marks" required value="{{ old('total_marks', 100) }}" min="1"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Passing Marks</label>
                <input type="number" name="passing_marks" value="{{ old('passing_marks', 35) }}" min="0"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('exams.index') }}"
                class="px-6 py-2.5 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit"
                class="px-10 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition-all">Schedule
                Exam</button>
        </div>
    </form>
</x-admin-layout>
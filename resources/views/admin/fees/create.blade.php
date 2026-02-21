<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Add Fee Record</h1>
        <p class="text-gray-500">Create a new fee invoice for a student.</p>
    </div>

    <form action="{{ route('fees.store') }}" method="POST" class="max-w-xl">
        @csrf
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Student *</label>
                <select name="student_id" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->full_name }} ({{ $student->tuitionClass->name ?? '' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Amount (₹) *</label>
                    <input type="number" name="amount" step="0.01" required value="{{ old('amount') }}"
                        placeholder="e.g. 2500"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fee Type *</label>
                    <select name="fee_type" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="Monthly Tuition">Monthly Tuition</option>
                        <option value="Registration Fee">Registration Fee</option>
                        <option value="Exam Fee">Exam Fee</option>
                        <option value="Material Fee">Material Fee</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Due Date *</label>
                <input type="date" name="due_date" required value="{{ old('due_date') }}"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('fees.index') }}"
                class="px-6 py-2.5 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit"
                class="px-10 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition-all">Create
                Fee Record</button>
        </div>
    </form>
</x-admin-layout>
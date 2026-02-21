<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Create Assignment</h1>
        <p class="text-gray-500">Add a new assignment for a class.</p>
    </div>

    <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl">
        @csrf
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Assignment Title *</label>
                <input type="text" name="title" required value="{{ old('title') }}"
                    placeholder="e.g. Chapter 5 – Algebra Exercises"
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
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Assigned Date</label>
                    <input type="date" name="assigned_date" value="{{ old('assigned_date', date('Y-m-d')) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Due Date *</label>
                    <input type="date" name="due_date" required value="{{ old('due_date') }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" placeholder="Describe the assignment task..."
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Attachment (PDF/Image)</label>
                <input type="file" name="attachment"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-sm">
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('assignments.index') }}"
                class="px-6 py-2.5 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit"
                class="px-10 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition-all">Publish
                Assignment</button>
        </div>
    </form>
</x-admin-layout>
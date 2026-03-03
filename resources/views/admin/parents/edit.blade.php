<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Parent</h1>
            <p class="text-gray-500">Update parent account details and student associations.</p>
        </div>
        <a href="{{ route('admin.parents.index') }}" class="btn-secondary whitespace-nowrap">← Back</a>
    </div>

    <form action="{{ route('admin.parents.update', $parent) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Account Details --}}
            <div class="card">
                <h2 class="text-base font-bold text-gray-700 mb-5 pb-3 border-b border-gray-100">
                    Account Details</h2>
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full
                            Name *</label>
                        <input type="text" name="name" class="input-field" required
                            value="{{ old('name', $parent->name) }}" placeholder="e.g. John Doe">
                        @error('name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email
                            Address *</label>
                        <input type="email" name="email" class="input-field" required
                            value="{{ old('email', $parent->email) }}" placeholder="parent@example.com">
                        @error('email') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Mobile
                            Number</label>
                        <input type="text" name="phone" class="input-field" value="{{ old('phone', $parent->phone) }}"
                            placeholder="+91 98765 43210">
                        @error('phone') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Security & Association --}}
            <div class="flex flex-col gap-6">
                <div class="card">
                    <h2 class="text-base font-bold text-gray-700 mb-5 pb-3 border-b border-gray-100">
                        Security</h2>
                    <div class="flex flex-col gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">New
                                Password</label>
                            <input type="password" name="password" class="input-field"
                                placeholder="Leave blank to keep current">
                            <p class="text-gray-400 text-[11px] mt-1">Only enter a password if you want
                                to change it.</p>
                            @error('password') <p class="text-rose-600 text-xs mt-1">{{ $message }}
                            </p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm
                                Password</label>
                            <input type="password" name="password_confirmation" class="input-field">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h2 class="text-base font-bold text-gray-700 mb-5 pb-3 border-b border-gray-100">
                        Associate Students</h2>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Select
                            Students</label>
                        <div class="max-h-[200px] overflow-y-auto p-3 bg-gray-50 rounded-xl border-1.5 border-gray-200">
                            @php $linkedIds = $parent->students->pluck('id')->toArray(); @endphp
                            @forelse($students as $student)
                                <label class="flex items-center gap-2 mb-2 cursor-pointer">
                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" {{ in_array($student->id, old('student_ids', $linkedIds)) ? 'checked' : '' }}
                                        class="w-4 h-4 accent-indigo-600">
                                    <span class="text-sm text-gray-700">{{ $student->full_name }}
                                        ({{ $student->tuitionClass->name }})</span>
                                </label>
                            @empty
                                <p class="text-sm text-gray-400 italic">No students available.</p>
                            @endforelse
                        </div>
                        @error('student_ids') <p class="text-rose-600 text-xs mt-1">{{ $message }}
                        </p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('admin.parents.index') }}" class="btn-secondary w-full sm:w-auto text-center order-2 sm:order-1">Cancel</a>
            <button type="submit" class="btn-primary w-full sm:w-auto order-1 sm:order-2">Update Parent Account</button>
        </div>
    </form>
</x-admin-layout>
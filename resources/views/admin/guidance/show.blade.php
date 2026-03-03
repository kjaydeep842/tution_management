<x-admin-layout>
    <div class="mb-8 flex items-center space-x-4">
        <a href="{{ route('admin.guidance.index') }}"
            class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:border-gray-300 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Respond to Guidance Request</h1>
            <p class="text-gray-500 text-sm">Provide academic guidance for {{ $guidance->student->full_name }} in
                **{{ $guidance->subject }}**.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Student Info</h3>
                <div class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium uppercase text-xs">Full Name:</span>
                        <span class="text-gray-900 font-semibold">{{ $guidance->student->full_name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium uppercase text-xs">Roll No:</span>
                        <span class="text-gray-900 font-semibold">#{{ $guidance->student->roll_no }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium uppercase text-xs">Class:</span>
                        <span class="text-gray-900 font-semibold">{{ $guidance->tuitionClass->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium uppercase text-xs">Weak Subject:</span>
                        <span class="text-red-600 font-bold uppercase">{{ $guidance->subject }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 rounded-2xl p-6 border border-red-100">
                <h3 class="text-sm font-bold text-red-900 uppercase mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    Parent's Concern
                </h3>
                <p class="text-red-800 text-sm italic font-medium">
                    "{{ $guidance->parent_message }}"
                </p>
                <p class="mt-3 text-xs text-red-400">Received {{ $guidance->created_at->diffForHumans() }}</p>
            </div>
        </div>

        <!-- Response Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <form action="{{ route('admin.guidance.respond', $guidance->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">My Guidance Response *</label>
                            <textarea name="admin_response" rows="8" required
                                placeholder="Provide clear, actionable steps for the student to improve..."
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('admin_response', $guidance->admin_response) }}</textarea>
                            @error('admin_response') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Update Status</label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="pending" {{ $guidance->status === 'pending' ? 'checked' : '' }}
                                        class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-600 font-medium">Keep Pending</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="resolved" {{ $guidance->status === 'resolved' ? 'checked' : '' }}
                                        class="w-4 h-4 text-green-600 focus:ring-indigo-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-600 font-medium">Mark Resolved</span>
                                </label>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100">
                            <button type="submit"
                                class="px-10 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition-all flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Save Guidance & Notify Parent
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
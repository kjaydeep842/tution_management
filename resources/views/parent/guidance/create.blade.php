@extends('layouts.parent')

@section('title', 'Request Subject Guidance')

@section('content')
    <div class="mb-8">
        <a href="{{ route('parent.guidance.index') }}"
            class="text-indigo-600 hover:text-indigo-800 font-bold flex items-center mb-4 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Back to List
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Request Special Guidance</h1>
        <p class="text-gray-500 text-sm">Briefly tell us what subject your child needs more focus on.</p>
    </div>

    <div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('parent.guidance.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Select Weak Subject *</label>
                    <select name="subject" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select a subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}">{{ $subject }}</option>
                        @endforeach
                    </select>
                    @error('subject') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Message to Teacher *</label>
                    <textarea name="parent_message" rows="5" required
                        placeholder="Example: My child is struggling with Algebra concepts. Please guide them on how to practice effectively..."
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 resize-none outline-none">{{ old('parent_message') }}</textarea>
                    @error('parent_message') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    <p class="mt-2 text-xs text-gray-400 italic">Please provide at least 10 characters.</p>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition-all">Submit
                        Guidance Request</button>
                </div>
            </div>
        </form>
    </div>
@endsection
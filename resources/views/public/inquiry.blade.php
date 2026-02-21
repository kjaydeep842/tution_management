<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Form - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-indigo-600 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden">
        <div class="px-8 py-10">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Get Started</h1>
            <p class="text-gray-500 mb-8">Fill in your details and we'll get back to you with the best class options.
            </p>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all outline-none"
                        placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Number</label>
                    <input type="text" name="contact" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all outline-none"
                        placeholder="+91 98765 43210">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Interested Class</label>
                    <select name="tuition_class_id"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all outline-none">
                        <option value="">Select a class (Optional)</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }} - {{ $class->subject }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Where did you hear about us?</label>
                    <input type="text" name="source"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all outline-none"
                        placeholder="Friend, Social Media, etc.">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Additional Notes</label>
                    <textarea name="notes" rows="3"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all outline-none"
                        placeholder="Any specific requirements?"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                    Submit Inquiry
                </button>
            </form>
        </div>
        <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
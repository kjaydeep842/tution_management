@extends('layouts.parent')

@section('title', 'Weak Subject Guidance')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Academic Guidance</h1>
            <p class="text-gray-500 text-sm">Notify teachers about subjects where you need extra support.</p>
        </div>
        <a href="{{ route('parent.guidance.create') }}"
            class="px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl shadow-md hover:bg-indigo-700 transition-all flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>New Request</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($requests->isEmpty())
            <div class="p-12 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                    </path>
                </svg>
                <p class="text-lg font-medium">No guidance requests yet.</p>
                <p class="mt-1">Submit a request to start a conversation with the teacher.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Subject</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($requests as $request)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $request->created_at->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $request->subject }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2.5 py-1 text-xs font-bold rounded-full {{ $request->status === 'resolved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button onclick="openModal('guidance-{{ $request->id }}')"
                                        class="text-indigo-600 font-bold hover:text-indigo-800 transition-colors">View
                                        Conversation</button>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div id="modal-guidance-{{ $request->id }}"
                                class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl">
                                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                                            <h3 class="text-xl font-bold text-gray-900">{{ $request->subject }} Guidance</h3>
                                            <button onclick="closeModal('guidance-{{ $request->id }}')"
                                                class="text-gray-400 hover:text-gray-600">&times;</button>
                                        </div>
                                        <div class="p-6 space-y-6">
                                            <div>
                                                <p class="text-xs font-bold text-gray-400 uppercase mb-2">My Message</p>
                                                <div class="p-4 bg-gray-50 rounded-xl text-gray-700 text-sm italic">
                                                    "{{ $request->parent_message }}"
                                                </div>
                                            </div>

                                            @if($request->admin_response)
                                                <div>
                                                    <p class="text-xs font-bold text-indigo-400 uppercase mb-2">Teacher's Guidance</p>
                                                    <div class="p-4 bg-indigo-50 rounded-xl text-indigo-900 text-sm">
                                                        {{ $request->admin_response }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-center py-4">
                                                    <span class="text-sm text-gray-400 italic">Waiting for teacher's response...</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-6 bg-gray-50 rounded-b-2xl text-right">
                                            <button onclick="closeModal('guidance-{{ $request->id }}')"
                                                class="px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
        }
        function closeModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
        }
    </script>
@endsection
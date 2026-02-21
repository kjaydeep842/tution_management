<x-admin-layout>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Student Inquiries</h1>
            <p class="text-gray-500">Manage and track potential student leads.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Class Interest
                    </th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($inquiries as $inquiry)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $inquiry->name }}</div>
                            <div class="text-xs text-gray-500">Source: {{ $inquiry->source ?? 'Direct' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $inquiry->contact }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $inquiry->tuitionClass->name ?? 'Any' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                                    'converted' => 'bg-green-50 text-green-700 border-green-100',
                                    'closed' => 'bg-gray-50 text-gray-700 border-gray-100',
                                ][$inquiry->status];
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium border rounded-full {{ $statusClasses }}">
                                {{ ucfirst($inquiry->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <form action="{{ route('inquiries.update-status', $inquiry) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="text-xs bg-gray-50 border-gray-200 rounded-lg outline-none focus:ring-1 focus:ring-indigo-500">
                                    <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="converted" {{ $inquiry->status == 'converted' ? 'selected' : '' }}>
                                        Converted</option>
                                    <option value="closed" {{ $inquiry->status == 'closed' ? 'selected' : '' }}>Closed
                                    </option>
                                </select>
                            </form>
                            @if($inquiry->status != 'converted')
                                <a href="{{ route('students.create', ['inquiry_id' => $inquiry->id]) }}"
                                    class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-xs font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                    Enroll
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No inquiries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $inquiries->links() }}
        </div>
    </div>
</x-admin-layout>
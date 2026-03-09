<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Fees Management</h1>
            <p class="text-gray-500">Track and manage all student fee records.</p>
        </div>
        <a href="{{ route('fees.create') }}"
            class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-100">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Add Fee
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[900px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($fees as $fee)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-xs font-mono text-gray-500">{{ $fee->invoice_no }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $fee->student->full_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $fee->fee_type }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">₹{{ number_format($fee->amount, 2) }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $badge = ['unpaid' => 'bg-rose-50 text-rose-700', 'paid' => 'bg-green-50 text-green-700', 'partial' => 'bg-amber-50 text-amber-700'][$fee->status] ?? 'bg-gray-50 text-gray-700';
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ ucfirst($fee->status) }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($fee->status !== 'paid')
                                    <a href="{{ route('payments.create-for-fee', $fee) }}"
                                        class="text-xs font-bold text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1.5 rounded-lg whitespace-nowrap">Record
                                        Payment</a>
                                @else
                                    <span class="text-xs text-green-600 font-semibold whitespace-nowrap">✓ Paid</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">No fee records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">{{ $fees->links() }}</div>
    </div>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">{{ $fees->links() }}</div>
    </div>
</x-admin-layout>
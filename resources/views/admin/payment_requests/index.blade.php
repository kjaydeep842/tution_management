@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 leading-tight">Payment Verification</h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Manage and verify payment notifications from parents</p>
        </div>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50">
                        <th
                            class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">
                            Student</th>
                        <th
                            class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">
                            Fee Details</th>
                        <th
                            class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">
                            Amount</th>
                        <th
                            class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">
                            Payment Info</th>
                        <th
                            class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">
                            Status</th>
                        <th
                            class="px-6 py-4 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($requests as $request)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $request->student->full_name }}</div>
                                <div class="text-xs text-slate-500">{{ $request->student->admission_no }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-700">{{ $request->fee->fee_type }}</div>
                                <div class="text-xs text-slate-500">Invoice: {{ $request->fee->invoice_no }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">₹{{ number_format($request->amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-700 font-medium">{{ $request->payment_mode }}</div>
                                @if($request->txn_id)
                                    <div class="text-xs text-slate-500">TXN: {{ $request->txn_id }}</div>
                                @endif
                                @if($request->receipt_path)
                                    <a href="{{ asset('storage/' . $request->receipt_path) }}" target="_blank"
                                        class="text-[10px] text-indigo-600 font-bold hover:underline flex items-center gap-1 mt-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View Receipt
                                    </a>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($request->status === 'pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Pending</span>
                                @elseif($request->status === 'approved')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Approved</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($request->status === 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('payment-requests.approve', $request) }}" method="POST"
                                            onsubmit="return confirm('Approve this payment?')">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                        <button type="button" onclick="openRejectModal({{ $request->id }})"
                                            class="p-2 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @else
                                    <div class="text-center text-xs text-slate-400 font-medium">Processed on
                                        {{ $request->updated_at->format('d M') }}</div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <p class="text-slate-500 font-bold">No payment requests found</p>
                                    <p class="text-xs text-slate-400 mt-1">New requests from parents will appear here</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
            <div class="px-6 py-4 border-t border-slate-50">
                {{ $requests->links() }}
            </div>
        @endif
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-extrabold text-slate-900">Reject Payment Request</h3>
                <button onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="p-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Reason for Rejection</label>
                    <textarea name="admin_notes" rows="3" required class="input-field min-h-[100px]"
                        placeholder="Explain why the request is being rejected..."></textarea>
                </div>
                <div class="px-6 py-4 bg-slate-50 flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-slate-800">Cancel</button>
                    <button type="submit"
                        class="px-6 py-2 bg-rose-600 text-white rounded-xl text-sm font-bold hover:bg-rose-700 shadow-lg shadow-rose-200 transition-all">Reject
                        Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/payment-requests/${id}/reject`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
@endsection
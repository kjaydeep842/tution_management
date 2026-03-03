<x-admin-layout>
    <div class="mb-8 p-4 bg-indigo-50 border border-indigo-100 rounded-2xl sm:bg-transparent sm:border-0 sm:p-0">
        <h1 class="text-2xl font-bold text-gray-900">Record Payment</h1>
        <p class="text-gray-500 mt-1">Invoice: <span
                class="font-mono font-bold text-indigo-600">{{ $fee->invoice_no }}</span> | <span class="hidden xs:inline">Student: </span><span
                class="font-bold">{{ $fee->student->full_name }}</span> | <span class="hidden xs:inline">Due: </span><span class="text-green-600 font-bold">₹{{ number_format($fee->amount, 2) }}</span></p>
    </div>

    <form action="{{ route('payments.store') }}" method="POST" class="max-w-xl w-full">
        @csrf
        <input type="hidden" name="fee_id" value="{{ $fee->id }}">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Amount Paid (₹) *</label>
                    <input type="number" name="amount" step="0.01" required value="{{ old('amount', $fee->amount) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Date *</label>
                    <input type="date" name="paid_on" required value="{{ old('paid_on', date('Y-m-d')) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Mode *</label>
                <select name="payment_mode" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="Cash">Cash</option>
                    <option value="UPI">UPI (GPay / PhonePe / Paytm)</option>
                    <option value="Bank Transfer">Bank Transfer / NEFT</option>
                    <option value="Cheque">Cheque</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Transaction ID (optional)</label>
                <input type="text" name="txn_id" value="{{ old('txn_id') }}" placeholder="UPI ref / Cheque no."
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
        </div>
        <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('fees.index') }}"
                class="px-6 py-2.5 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition-colors text-center order-2 sm:order-1">Cancel</a>
            <button type="submit"
                class="px-10 py-2.5 bg-green-600 text-white font-bold rounded-xl shadow-lg hover:bg-green-700 transition-all order-1 sm:order-2">Save
                Payment</button>
        </div>
    </form>
</x-admin-layout>
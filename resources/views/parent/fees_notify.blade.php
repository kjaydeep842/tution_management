@extends('layouts.parent')

@section('content')
    <div style="margin-bottom:24px;">
        <a href="{{ route('parent.fees') }}"
            style="color:#6366f1; text-decoration:none; font-size:13px; font-weight:600; display:flex; align-items:center; gap:5px; margin-bottom:12px;">
            ← Back to Fees
        </a>
        <h1 style="font-size:22px; font-weight:800; color:#0f172a; margin:0 0 4px;">Notify Payment</h1>
        <p style="color:#64748b; font-size:14px; margin:0;">Submit payment details for:
            <strong>{{ $fee->fee_type ?? 'Monthly Tuition' }}</strong></p>
    </div>

    <div class="card" style="max-width: 600px;">
        <form action="{{ route('parent.fees.store-notify', $fee) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:700; color:#374151; margin-bottom:8px;">Amount Paid
                    (₹)</label>
                <input type="number" name="amount" step="0.01" required class="input-field"
                    value="{{ old('amount', $fee->amount - $fee->payments()->sum('amount')) }}"
                    max="{{ $fee->amount - $fee->payments()->sum('amount') }}" placeholder="Enter amount paid">
                @error('amount')
                    <p style="color:#ef4444; font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:700; color:#374151; margin-bottom:8px;">Payment
                    Mode</label>
                <select name="payment_mode" required class="input-field">
                    <option value="">Select Mode</option>
                    <option value="Cash" {{ old('payment_mode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="Bank Transfer" {{ old('payment_mode') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer
                    </option>
                    <option value="GPay / PhonePe" {{ old('payment_mode') == 'GPay / PhonePe' ? 'selected' : '' }}>GPay /
                        PhonePe</option>
                    <option value="Cheque" {{ old('payment_mode') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                    <option value="Other" {{ old('payment_mode') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('payment_mode')
                    <p style="color:#ef4444; font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:700; color:#374151; margin-bottom:8px;">Transaction
                    ID / Reference (Optional)</label>
                <input type="text" name="txn_id" class="input-field" value="{{ old('txn_id') }}"
                    placeholder="Enter reference number">
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:13px; font-weight:700; color:#374151; margin-bottom:8px;">Upload
                    Receipt (Optional)</label>
                <input type="file" name="receipt" accept="image/*" class="input-field" style="padding: 8px;">
                <p style="color:#94a3b8; font-size:11px; margin-top:4px;">Images only (JPG, PNG). Max 2MB.</p>
            </div>

            <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:12px;">
                🚀 Submit Payment Notification
            </button>
        </form>
    </div>
@endsection